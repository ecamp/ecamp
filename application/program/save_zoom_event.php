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

	include( 'inc/get_program_update.php');
	
	$event_instance_id	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['event_instance_id']);
	$length				= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['length']);
	$width				= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['width']);
	$time				= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['time']);
	
	$_camp->event_instance( $event_instance_id ) || die( "error" );
	
	$query = "	UPDATE 
					event_instance 
				SET 
					`length` = '$length',
					`width` = '$width'
				WHERE 
					`id` = '$event_instance_id';";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	header("Content-type: application/json");
	
	$ans = get_program_update( $time );
	echo json_encode( $ans );
	
	die();
	