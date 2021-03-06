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

	$day_id = 				mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['day_id'] );
	$event_id = 			mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['event_id'] );
	$event_instance_id = 	mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['event_instance_id'] );
	
	$name = 				mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['name'] );
	$category_id = 			mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['category_id'] );
	
	$start_h = 				mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['start_h'] );
	$start_min = 			mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['start_min'] );
	
	$length_h = 			mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['length_h'] );
	$length_min = 			mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['length_min'] );

	$_camp->day( $day_id ) || 						die( "error" );
	$_camp->event( $event_id ) || 					die( "error" );
	$_camp->event_instance( $event_instance_id ) || die( "error" );
	$_camp->category( $category_id ) || 			die( "error" );

	if( $start_h < 5 )
	{	$start_h += 24;	}
	
	$start 	= $start_h  * 60 + $start_min;
	$length = $length_h * 60 + $length_min;

	$query = "	SELECT
					event.*
				FROM
					event,
					event_instance
				WHERE
					event.id = event_instance.event_id AND
					event_instance.id = $event_instance_id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	if( !mysqli_num_rows( $result ) ) 
	{
		$ans = array( "error" => true, "error_msg" => "Fehler!" );
		echo json_encode( $ans );
		die();
	}

	$query = "	UPDATE 
					event
				SET 
					`name` = '$name',
					`category_id` = '$category_id'
				WHERE 
					id = $event_id";
	mysqli_query($GLOBALS["___mysqli_ston"],  $query );

	$query = "	UPDATE
					event_instance
				SET
					`starttime` = $start,
					`length`	= $length
				WHERE
					id = $event_instance_id";
	mysqli_query($GLOBALS["___mysqli_ston"],  $query );

	if( mysqli_error($GLOBALS["___mysqli_ston"]) )
	{	$ans = array( "error" => true, "error_msg" => "Fehler" );	}
	else
	{	$ans = array( "error" => false, "error_msg" => "" );	}
	
	echo json_encode( $ans );
	die();
