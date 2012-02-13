<?php
/*
 * Copyright (C) 2010 Urban Suppiger, Pirmin Mattmann
 *
 * This file is part of eCamp.
 *
 * eCamp is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * eCamp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with eCamp.  If not, see <http://www.gnu.org/licenses/>.
 */

	$user_camp_id 	= mysql_real_escape_string($_REQUEST[user_camp_id]);
	$camp_id    	= mysql_real_escape_string($_REQUEST[camp_id]);
	
	// Rechte überprüfen
	$query = "SELECT id,camp_id FROM user_camp WHERE id='$user_camp_id' AND user_id='$_user->id' AND camp_id='$camp_id'";
	$result = mysql_query($query);
	if( mysql_num_rows($result) == 0 )
	{
		// error
		//$uri = "&msg_title=".urlencode("Lager verlassen")."&msg_text=".urlencode("Lager wurde nicht verlassen. Keine Berechtigung!");
		//header("Location: index.php?app=camp_admin".$uri);
		//die();
		
		$ans = array("ans" => "Lager wurde nicht verlassen. Keine Berechtigung!", "exit" => false);
		echo json_encode($ans);
		die();
	}
	
	$user_camp = mysql_fetch_assoc($result);
	
	$query = "SELECT short_name FROM camp WHERE id = $camp_id";
	$result = mysql_query( $query );
	$short_name = mysql_result( $result, 0, 'short_name' );
	
	
	
	
	
	
	$query = "SELECT mat_event.id FROM mat_event WHERE user_camp_id = $user_camp_id";
	$result = mysql_query( $query );
	
	if( mysql_num_rows($result) )
	{
		// COPY MAT-RESPONSIBILITY TO NEW MAT-LIST CALLED THE SAME AS THE USER BEVOR.
		
		$query = "	SELECT user.scoutname, user.firstname, user.surname
					FROM user, user_camp
					WHERE user.id = user_camp.user_id AND user_camp.id = $user_camp_id";
		$result = mysql_query( $query );
		
		$user_name = mysql_result( $result, 0, 'scoutname' );
		if( !is_string( $user_name ) )
		{	$user_name = mysql_result( $result, 0, 'firstname' ) . " " . mysql_result( $result, 0, 'surname' );	}
		
		
		$query = "	INSERT INTO mat_list ( `camp_id`, `name` )
					VALUES ( $_camp->id, 'Materialliste von " . $user_name . "' )";
		mysql_query( $query );
		$mat_list_id = mysql_insert_id();
		
		
		
		$query = "	UPDATE mat_event
					SET user_camp_id = NULL, mat_list_id = $mat_list_id
					WHERE user_camp_id = $user_camp_id";
		mysql_query( $query ); 
	}
	
	
	
	
	
	
	
	// Delete UserCamp-Instance:
	$query = "	DELETE FROM 
					user_camp 
				WHERE 
					id = '$user_camp_id' LIMIT 1";
	mysql_query( $query );

	// Extra Delete EventResponsibles  (Due To Design-Error :/ )
	$query = "DELETE FROM 	event_responsible 
		  WHERE id IN (
			SELECT 	event_responsible.id 
			FROM 	event_responsible, event 
			WHERE
				event_responsible.event_id = event.id AND
				event_responsible.user_id = $_user->id AND
				event.camp_id = $camp_id
			)";
    	mysql_query( $query );

    $_news->add2camp( "Lager verlassen", $_user->display_name . " hat das Lager '$short_name' verlassen.", time(), $camp_id );
	$_news->add2user( "Lager verlassen", "Du hast das Lager '$short_name' verlassen.", time(), $_user->id );
	
	
	if($_SESSION[camp_id] == $user_camp[camp_id])
	{	$_SESSION[camp_id] = "";	}
	
	
	//$uri = "&msg_title=".urlencode("Lager verlassen")."&msg_text=".urlencode("Lager wurde verlassen.");
	//header("Location: index.php?app=camp_admin".$uri);
	//die();
	
	$ans = array("ans" => "Lager wurde verlassen!", "exit" => true);
	echo json_encode($ans);
	die();
	
?>