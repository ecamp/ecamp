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

	
	$query = "	SELECT
    				event.id,
    				event.name,
    				event.progress,
    				event_instance.id as event_instance_id,
    				category.short_name,
    				(day.day_offset + subcamp.start) as date,
    				(day.day_offset + 1) as day_offset,
    				(	SELECT
							count(event_instance_down.id)
						FROM
							event_instance as event_instance_up,
							event_instance as event_instance_down,
							event,
							category
						WHERE
							event_instance_up.id = event_instance.id AND
							event_instance_up.day_id = event_instance_down.day_id AND
							event_instance_down.event_id = event.id AND
							event.category_id = category.id AND
							category.form_type > 0 AND
							(
								event_instance_down.starttime < event_instance_up.starttime OR
								(
									event_instance_down.starttime = event_instance_up.starttime AND
									(
										event_instance_down.dleft < event_instance_up.dleft OR
										(
											event_instance_down.dleft = event_instance_up.dleft AND
											event_instance_down.id <= event_instance_up.id
							)	)	)	)
					) as event_nr,
					category.form_type,
					event_instance.starttime
    			FROM
    				event,
    				category,
    				event_instance,
    				day,
    				subcamp
    			WHERE
    				event.camp_id = " . $_camp->id . " AND
    				event.category_id = category.id AND
    				event_instance.event_id = event.id AND
    				event_instance.day_id = day.id AND
    				day.subcamp_id = subcamp.id
    			ORDER BY date, starttime";
	
	$query = "	SELECT
    				event.id,
    				event.name,
    				event.progress,
    				event_instance.id as event_instance_id,
    				category.short_name,
    				(day.day_offset + subcamp.start) as date,
    				v_event_nr.day_nr as day_offset,
    				v_event_nr.event_nr,
					category.form_type,
					event_instance.starttime
    			FROM
    				v_event_nr,
    				event,
    				category,
    				event_instance,
    				day,
    				subcamp
    			WHERE
    				v_event_nr.event_instance_id = event_instance.id AND
    				event.camp_id = " . $_camp->id . " AND
    				event.category_id = category.id AND
    				event_instance.event_id = event.id AND
    				event_instance.day_id = day.id AND
    				day.subcamp_id = subcamp.id
    			ORDER BY date, starttime";
    
	$result = mysql_query( $query );
	
	$events = array();
	$c_date = new c_date();
	
	while( $row = mysql_fetch_assoc( $result ) )
	{
		$c_date->setDay2000( $row['date'] );
		
		$events[ $row['date'] ]['day_str'] = $c_date->getString( 'd.m.Y' );
		$events[ $row['date'] ]['events'][] = $row;
	}
	
	
	$_page->html->set( 'events', $events );
	
?>