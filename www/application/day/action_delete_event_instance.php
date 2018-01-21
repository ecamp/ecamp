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

	$event_instance_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['event_instance_id'] );
	
	$_camp->event_instance( $event_instance_id ) || die( "error" );

	$query = "	SELECT
					event_instance.event_id
				FROM
					event_instance
				WHERE
					event_instance.id = $event_instance_id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	$event_id = mysqli_result( $result,  0,  'event_id' );
	
	$query = "	DELETE FROM event_instance
				WHERE event_instance.id = $event_instance_id";
	mysqli_query($GLOBALS["___mysqli_ston"],  $query );

	if( mysqli_error($GLOBALS["___mysqli_ston"]) )
	{
		$ans = array( "error" => true, "error_msg" => "Fehler!" );
		echo json_encode( $ans );
		die();
	}

	$query = "	SELECT 	*
				FROM 	event_instance
				WHERE	event_instance.event_id = $event_id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	if( !mysqli_num_rows( $result ) )
	{
		$query = "	DELETE FROM event
					WHERE event.id = $event_id";
		mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	}
	
	$ans = array( "error" => false );
	echo json_encode( $ans );
	die();
