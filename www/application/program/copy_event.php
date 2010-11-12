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
	
	
	//***********************************************************************
	
	$query = "	SELECT event_instance.event_id
				FROM event_instance
				WHERE event_instance.id = $event_instance_id";
	$result = mysql_query( $query );
	$event_id = mysql_result( $result, 0, 'event_id' );
	
	$_camp->event( $event_id ) || die( "error" );
	
	
	$copy = array( "type" => "event_copy", "event" => $event_id, "event_instance" => $event_instance_id );
	$copy = json_encode( $copy );
	
	
	$query = "	UPDATE user
				SET copyspace = '$copy'
				WHERE user.id = $_user->id";
	mysql_query( $query );
	

	//***********************************************************************
	//***********************************************************************
	/*
	
	$query = "	SELECT
					dleft,
					width,
					event_id
				FROM
					event_instance
				WHERE
					id = $event_instance_id";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$dleft = $row['dleft'];
	$width = $row['width'];
	$event_id = $row['event_id'];
	
	
	if($width > 0.3)
	{
		$new_width = $width - 0.1;
		$query = "UPDATE event_instance SET width = $new_width WHERE id = $event_instance_id";
		mysql_query($query);
		
		$new_dleft = $dleft + 0.1;
	}
	else
	{
		if($dleft + $width >= 1)	{	$new_dleft = $dleft - 0.1;	}
		else						{	$new_dleft = $dleft + 0.1;	}
	}
	
	
	
	$query = "	INSERT INTO
					event
				(camp_id, category_id, name, place, story, aim, method, topics, notes, seco, progress, in_edition_by, in_edition_time)
				(
					SELECT
						camp_id,
						category_id,
						name,
						place,
						story,
						aim, 
						method,
						topics,
						notes,
						seco,
						progress,
						in_edition_by,
						in_edition_time
					FROM
						event
					WHERE
						event.id = $event_id
				)";
	mysql_query($query);
	
	
	$query = "SELECT  LAST_INSERT_ID()";
	$result = mysql_query($query);
	$new_event_id = implode(mysql_fetch_row($result));
	
	
	
	
	
	$query = "	INSERT INTO
					event_instance
				(event_id, day_id, starttime, length, dleft, width)	
				(	SELECT
						'$new_event_id' as event_id,
						day_id,
						starttime,
						length,
						'$new_dleft' as dleft,
						'$new_width' as width
					FROM
						event_instance
					WHERE
						id = $event_instance_id
				)";
	mysql_query($query);
	
	*/
	//=====================================================================================
	//=====================================================================================
	
	
	
	
	
	header("Content-type: application/json");
	
	$ans = get_program_update( $time );
	echo json_encode( $ans );
		
	die();
?>