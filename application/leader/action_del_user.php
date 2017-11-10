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

	
	$user_camp_id = mysql_real_escape_string($_REQUEST[user_camp_id]);
	
	
	
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
	
	
	
	$query = "DELETE FROM user_camp WHERE id = '$user_camp_id' AND NOT user_id='$_camp->creator_userid' AND camp_id = '$_camp->id'";
	mysql_query($query);
	
	if( mysql_affected_rows() )
	{
		$ans = array( "error" => false );
		echo json_encode( $ans );
		die();
	}
	else
	{
		$ans = array( "error" => true, "msg" => "Dieser Leiter konnte nicht entfernt werden!" );
		echo json_encode( $ans );
		die();
	}
	
?>