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

	class event
	{
		var $starttime;
		var $length;
		var $row;
		var $row_max;
		var $event_nr;
	}
	
	function get_detail_of_all_events_of_one_day( $this_day_id )
	{
		$events = "";
		$event_query = "SELECT 
							event.id,
							event.name,
							event.responsible,
							event.progress,
							event_instance.id as event_instance_id,
							event_instance.starttime,
							event_instance.length,
							category.color,
							category.short_name,
							category.form_type,
							category.id as cat_id,
							v.event_nr as eventnr
						FROM 	
							event,
							event_instance,
							category,
							(".getQueryEventNr($_camp->id).") v	
						WHERE 
							v.event_instance_id = event_instance.id AND
							event.category_id = category.id AND
							event_instance.day_id = $this_day_id AND
							event_instance.event_id = event.id
						ORDER BY starttime ASC, length DESC, id DESC ";
						
							
		$event_result = mysql_query($event_query);
		$event_nr = 0;
		
		$rows = array();
		$count = array();
		
		$events = array();
		
		while($event = mysql_fetch_assoc($event_result))
		{
			//$event[starttime] = (($event[starttime] + (24*60) - $GLOBALS[time_shift]) % (24*60)) + $GLOBALS[time_shift];
			
			
			$row = 1;
			while($rows[$row][count($rows[$row])]->starttime + $rows[$row][count($rows[$row])]->length > $event[starttime])
			{
				$row++;
				if(!is_array($rows[$row]))
				{	$rows[$row] = array();	}
			}
			
			if($event['form_type'] == 0)	{	$event['eventnr'] = 0;	}
			
			$rows[$row][count($rows[$row]) + 1] = new event();
			$rows[$row][count($rows[$row])]->starttime 	= $event['starttime'];
			$rows[$row][count($rows[$row])]->length		= $event['length'];
			$rows[$row][count($rows[$row])]->row 		= $row;
			$rows[$row][count($rows[$row])]->id 		= $event['event_instance_id'];
			
			
			$events[$event['event_instance_id']] = new event();
			$events[$event['event_instance_id']]->starttime	= $event['starttime'];
			$events[$event['event_instance_id']]->length		= $event['length'];
			$events[$event['event_instance_id']]->row			= $row;
			$events[$event['event_instance_id']]->event_nr	= $event['eventnr'];

			for($time = $event['starttime']; $time < $event['starttime'] + $event['length']; $time++)
			{	$count[$time]++;	}
		}

		foreach ($rows as $list_of_events)
		{
			foreach ($list_of_events as $event)
			{
				$max_row = 1;
				for($time = $event->starttime; $time < $event->starttime + $event->length; $time++)
				{	$max_row = max($max_row, $count[$time]);	}
				
				$events[$event->id]->row_max = $max_row;
			}
		}
		
		return $events;
	}
