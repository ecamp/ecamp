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

	$event_instance_id	= mysql_real_escape_string($_REQUEST['event_instance_id']);
	$time				= mysql_real_escape_string($_REQUEST['time']);
	
	$_camp->event_instance( $event_instance_id ) || die( "error" );
	
	
	$query = "	SELECT
					length
				FROM
					event_instance
				WHERE
					id = $event_instance_id";
	$result = mysql_query($query);
	$length = implode(mysql_fetch_row($result));
	
	if($length > 60)
	{
		$new_length = $length / 2;
		$query = "UPDATE event_instance SET length = $new_length WHERE id = $event_instance_id";
		mysql_query($query);
		
		$move = $new_length;
	}
	else
	{	$move = length;	}
	
	$query = "	INSERT INTO
					event_instance
				(event_id, day_id, starttime, length, dleft, width)	
				(	SELECT
						event_id,
						day_id,
						(starttime + $move) as starttime,
						length,
						dleft,
						width
					FROM
						event_instance
					WHERE
						id = $event_instance_id
				)";
	mysql_query($query);
	
	
	
	header("Content-type: application/json");
	
	$ans = get_program_update( $time );
	echo json_encode( $ans );
	
	die();
?>