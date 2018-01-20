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

	$user_camp_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['user_camp_id']);

	$query = "SELECT mat_event.id FROM mat_event WHERE user_camp_id = $user_camp_id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	if( mysqli_num_rows($result) )
	{
		// COPY MAT-RESPONSIBILITY TO NEW MAT-LIST CALLED THE SAME AS THE USER BEVOR.
		$query = "	SELECT user.scoutname, user.firstname, user.surname
					FROM user, user_camp
					WHERE user.id = user_camp.user_id AND user_camp.id = $user_camp_id";
		$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		
		$user_name = mysqli_result( $result,  0,  'scoutname' );
		if( !is_string( $user_name ) )
		{	$user_name = mysqli_result( $result,  0,  'firstname' ) . " " . mysqli_result( $result,  0,  'surname' );	}

		$query = "	INSERT INTO mat_list ( `camp_id`, `name` )
					VALUES ( $_camp->id, 'Materialliste von " . $user_name . "' )";
		mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		$mat_list_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);

		$query = "	UPDATE mat_event
					SET user_camp_id = NULL, mat_list_id = $mat_list_id
					WHERE user_camp_id = $user_camp_id";
		mysqli_query($GLOBALS["___mysqli_ston"],  $query ); 
	}

	$query = "SELECT user_id FROM user_camp  WHERE id = '$user_camp_id'";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	$user_id = mysqli_result( $result,  0,  'user_id' );
	
	$query = "DELETE FROM user_camp WHERE id = '$user_camp_id' AND NOT user_id='$_camp->creator_userid' AND camp_id = '$_camp->id'";
	
	mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	if( mysqli_affected_rows($GLOBALS["___mysqli_ston"]) )
	{
		// Extra Delete EventResponsibles  (Due To Design-Error :/ )
		$query = "DELETE FROM event_responsible 
		WHERE user_id=$user_id AND event_id IN 
		( SELECT event.id FROM event WHERE event.camp_id = $_camp->id )";
		
		mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		
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
