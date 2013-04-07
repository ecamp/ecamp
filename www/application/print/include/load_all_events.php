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
    				v.day_nr as day_offset,
    				v.event_nr,
					category.form_type,
					event_instance.starttime
    			FROM
    				(".getQueryEventNr($_camp->id).") v,
    				event,
    				category,
    				event_instance,
    				day,
    				subcamp
    			WHERE
    				v.event_instance_id = event_instance.id AND
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