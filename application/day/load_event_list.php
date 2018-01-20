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

	$event_list = array();
	
	$event_date = new c_date();
	$event_time = new c_time();
	
	$query = "	SELECT
					event.id as event_id,
					event.name,
					category.id as category_id,
					category.short_name,
					category.form_type,
					category.color,
					event_instance.id,
					event_instance.starttime,
					event_instance.length,
					(subcamp.start + day.day_offset) as event_date,
					event.progress,
					day.id as day_id,
					v.day_nr as daynr,
					v.event_nr as eventnr
				FROM
					(".getQueryEventNr($_camp->id).") v,
					event,
					event_instance,
					category,
					day,
					subcamp
				WHERE
					v.event_instance_id = event_instance.id AND
					subcamp.camp_id = $_camp->id AND
					day.id = $day_id AND
					day.subcamp_id = subcamp.id AND
					event_instance.day_id = day.id AND
					
					event.camp_id = $_camp->id AND
					event.category_id = category.id AND
					
					event.id = event_instance.event_id
				ORDER BY
					event_instance.starttime, eventnr";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	while( $event_instance = mysqli_fetch_assoc( $result ) )
	{
		$event_instance['event_date_str'] = $event_date->setDay2000( $event_instance['event_date'] )->getString( 'd.m.Y' );
		$event_instance['starttime_str'] = $event_time->setValue( $event_instance['starttime'] )->getString( 'H:i' );
		$event_instance['endtime'] = $event_instance['starttime'] + $event_instance['length'];
		$event_instance['endtime_str'] = $event_time->setValue( $event_instance['endtime'] )->getString( 'H:i' );
		
		if( $event_instance['length_str'] = $event_time->setValue( $event_instance['length'] )->getMin() )
		{	$event_instance['length_str'] = $event_time->setValue( $event_instance['length'] )->getString( 'G\h i\m\i\n' );	}
		else
		{	$event_instance['length_str'] = $event_time->setValue( $event_instance['length'] )->getString( 'G\h' );	}
		
		if( $event_instance['short_name'] )
		{	$event_instance['short_name_str'] = $event_instance['short_name'] . ":";	}
		else
		{	$event_instance['short_name_str'] = "";	}
		
		$event_instance['color_str'] = "background-color: #" . $event_instance['color'];
		
		if( $event_instance['form_type'] )	{	$event_instance['progress'] .= "%";	}
		else								{	$event_instance['progress'] = "";	}
		
		$event_list[ $event_instance['id'] ] = $event_instance;
	}
	
	//print_r( $event_list );
