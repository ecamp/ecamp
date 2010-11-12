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


	function get_program_update( $time )
	{
		global $_camp;
		global $_user;
		
		$data = array();
		$time_str = date( 'Y-m-d H:i:s', $time );
		
		
		
		//	USER:
		// =======
		
		$query = "	SELECT 
						user.id, scoutname, firstname, surname
					FROM 
						user, user_camp, dropdown
					WHERE 
						user_camp.function_id = dropdown.id AND
						dropdown.entry != 'Support' AND
						user.id = user_camp.user_id AND
						user_camp.camp_id = $_camp->id AND
						(
							user.t_edited >= '$time_str' OR
							user_camp.t_edited >= '$time_str'
						);";
		$users = mysql_query($query);
		
		while( $user = mysql_fetch_assoc( $users ) )
		{	$data['users'][] = $user;	}
		
		
		
		//	CATEGORY:
		// ===========
		
		$query = "	SELECT
						id,
						name,
						short_name,
						(form_type > 0) as count,
						color
					FROM
						category
					WHERE
						camp_id = $_camp->id AND
						category.t_edited >= '$time_str' ;";
		$categorys = mysql_query($query);
		
		while( $category = mysql_fetch_assoc( $categorys ) )
		{	$data['categorys'][] = $category;	}
		
		
		
		//	SUBCAMP:
		// ==========
		
		$query = "	SELECT
						id,
						(
							SELECT
								COUNT(*)
							FROM
								subcamp as ss
							WHERE
								ss.start <= s.start AND
								ss.camp_id = s.camp_id
						) as subcamp_nr,
						length,
						camp_id
					FROM
						subcamp as s
					WHERE
						camp_id = $_camp->id AND
						t_edited >= '$time_str' ;";
		$subcamps = mysql_query($query);
		
		while( $subcamp = mysql_fetch_assoc( $subcamps ) )
		{	$data['subcamps'][] = $subcamp;	}
		
		
		
		//	DAY:
		// ======
		
		$query = "	SELECT
						day.id,
						day.subcamp_id,
						(day.day_offset + subcamp.start) as date,
						(day.day_offset + 1) as day_nr,
						day.day_offset,
						(
							SELECT
								SUM(length)
							FROM
								subcamp as ss
							WHERE
								ss.start < subcamp.start AND
								ss.camp_id = subcamp.camp_id
						) as global_subcamp_offset
					FROM
						day,
						subcamp
					WHERE
						day.subcamp_id = subcamp.id AND
						subcamp.camp_id = $_camp->id AND
						(
							day.t_edited >= '$time_str' OR
							subcamp.t_edited >= '$time_str'
						);";
		$days = mysql_query($query);
		
		while( $day = mysql_fetch_assoc( $days ) )
		{	$data['days'][] = $day;	}
		
		
		
		//	EVENT:
		// ========
		
		$query = "	SELECT 
						event.id, 
						event.name, 
						event.category_id, 
						event.progress, 
						event.in_edition_by, 
						event.in_edition_time
					FROM 
						event
					LEFT JOIN 
						event_responsible 
					ON 
						event.id = event_responsible.event_id
					WHERE 
						event.camp_id = $_camp->id AND 
						(
							event.t_edited >= '$time_str' OR 
							event_responsible.t_edited >= '$time_str'
						)";
		$events = mysql_query( $query );
		
		while( $event = mysql_fetch_assoc( $events ) )
		{
			$event['users'] = array();
			
			$query = "	SELECT
							user_id
						FROM
							event_responsible
						WHERE
							event_id = " . $event['id'];
			$event_responsibles = mysql_query( $query );
			
			while( $event_responsible = mysql_fetch_assoc( $event_responsibles ) )
			{	$event['users'][] = $event_responsible['user_id'];	}
			
			$data['events'][] = $event;
		}
		
		
		
		//	EVENT_INSTANCE:
		// =================
		
		$query = "	SELECT
						event_instance.id,
						event_instance.event_id,
						event_instance.day_id,
						event_instance.starttime,
						event_instance.length,
						event_instance.dleft,
						event_instance.width
					FROM
						event_instance,
						event
					WHERE
						event_instance.event_id = event.id AND
						event.camp_id = $_camp->id AND
						(
							event.t_edited >= '$time_str' OR
							event_instance.t_edited >= '$time_str'
						);";
		$event_instances = mysql_query($query);
		
		while( $event_instance = mysql_fetch_assoc( $event_instances) )
		{	$data['event_instances'][] = $event_instance;	}
		
		
		
		
		//	DELETE-LOG:
		// =============
		
		$filename = "application/program/del_protocol/" . $_user->id . ".log";
		touch( $filename );
		
		$filecontent = file_get_contents( $filename );
		$file = json_decode( trim( $filecontent ), true );
		
		unlink( $filename );
		
		$data['del'] = $file;
		
		
		
		
		
		$data['time'] = time();
		
		return $data;
	}
	
	//echo json_encode( get_program_update( 1111111111 ) );	
	
	//die();
?>