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
	
	$day_id	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['day_id'] );
	$time	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['time'] );
	$start	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['start'] );
	
	$_camp->day( $day_id ) || die( "error" );
	
	
	if( $start < $GLOBALS['time_shift'] )
	{	$start += 24*60;	}
	
	$query = "	SELECT copyspace
				FROM user
				WHERE user.id = $_user->id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	$copy = mysqli_result( $result,  0,  'copyspace' );
	
	$copy = json_decode( $copy, true );
	
	if( $copy['type'] == "event_copy" )
	{
		$query = "	SELECT
						new_category.id
					FROM
						event,
						category
					LEFT JOIN
						(
							SELECT	new_category.id, new_category.form_type
							FROM	category as new_category
							WHERE	new_category.camp_id = $_camp->id
						) as new_category
					ON
						new_category.form_type = category.form_type
					WHERE
						event.category_id = category.id AND
						event.id = " . $copy['event'] . "
					
					UNION
					
					SELECT category.id
					FROM 
						(
							SELECT *
							FROM category
							WHERE 1
							ORDER BY category.form_type DESC
						) as category
					WHERE category.camp_id = $_camp->id";
		
		$query = "	SELECT
						category.id
					FROM
						category,
						event
					WHERE
						event.id = " . $copy['event'] . " AND
						event.camp_id = $_camp->id AND
						event.category_id = category.id
					
					UNION
						
					SELECT
						category.id
					FROM
						category
					WHERE
						category.camp_id = $_camp->id
					LIMIT 1";
		$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		
		$i = 0;
		$category_id = mysqli_result( $result,  0,  'id' );
		
		$query = "	INSERT INTO
						event
					(camp_id, category_id, name, place, story, aim, method, topics, notes, seco, progress, in_edition_by, in_edition_time)
					(
						SELECT
							'$_camp->id' as camp_id,
							$category_id as category_id,
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
							event.id = " . $copy['event'] . "
					)";
		mysqli_query($GLOBALS["___mysqli_ston"], $query);
		$new_event_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
		
		$query = "	INSERT INTO
						event_instance
					(event_id, day_id, starttime, length, dleft, width)	
					(	SELECT
							'$new_event_id' as event_id,
							'$day_id' as day_id,
							'$start' as starttime,
							length,
							dleft,
							width
						FROM
							event_instance
						WHERE
							id = " . $copy['event_instance'] . "
					)";
		mysqli_query($GLOBALS["___mysqli_ston"], $query);
		
		if( $category_id )
		{
			$query = "	INSERT INTO
							event_detail
						(event_id, prev_id, time, content, resp, sorting )
						(
							SELECT
								'$new_event_id' as event_id,
								prev_id,
								time,
								content,
								resp,
								sorting
							FROM
								event_detail
							WHERE
								event_detail.event_id = " . $copy['event'] . "
						)";
			mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		}
	}
	
	//header("Content-type: application/json");
	
	$ans = get_program_update( $time );
	echo json_encode( $ans );
	die();
	