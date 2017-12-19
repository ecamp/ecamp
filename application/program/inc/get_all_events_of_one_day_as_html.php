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

	include_once("application/".$app."/lib/event2html.php");
	
	class event
	{
		var $starttime;
		var $length;
		var $data = array();
		
	}
	
	function get_all_events_of_one_day_as_html( $this_day_id, $this_day_nr )
	{
		// Tagesnummer herausfinden
		if( $this_day_nr == "" )
		{
			$query = "SELECT 
						((
							SELECT 
								count(*) 
							FROM 
								day as sday,
								subcamp as ssubcamp
							WHERE 
								ssubcamp.start + sday.day_offset < subcamp.start + day.day_offset AND 
								ssubcamp.id = sday.subcamp_id AND
								ssubcamp.camp_id = subcamp.camp_id
						) + 1) as daynr
					FROM 
						day,
						subcamp
					WHERE 
                        day.id=$this_day_id AND
                        day.subcamp_id=subcamp.id";
	
			$result = mysql_query($query);
			$result = mysql_fetch_assoc($result);
			$this_day_nr = $result['daynr'];
		}
		
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
		
		//$all_events = array();
		$events = "";
		
		while($event = mysql_fetch_assoc($event_result))
		{
			//$all_events[$event[id]] = $event;
			
			$row = 1;
			while($rows[$row][count($rows[$row])]->starttime + $rows[$row][count($rows[$row])]->length > $event['starttime'])
			{
				$row++;
				if(!is_array($rows[$row]))
				{	$rows[$row] = array();	}
			}
			
			//$all_events[$event[id]][row] = $row;
			
			$rows[$row][count($rows[$row]) + 1] = new event();
			$rows[$row][count($rows[$row])]->starttime 	= $event['starttime'];
			$rows[$row][count($rows[$row])]->length		= $event['length'];
			$rows[$row][count($rows[$row])]->data		= $event;
			$rows[$row][count($rows[$row])]->data[row] 	= $row;
			
			for($time = $event['starttime']; $time < $event['starttime'] + $event['length']; $time++)
			{	$count[$time]++;	}
		}
		
		//print_r($rows);
		//echo "-- new day --";
		
		foreach ($rows as $list_of_events)
		{
			foreach ($list_of_events as $event)
			{
				$max_row = 1;
				for($time = $event->starttime; $time < $event->starttime + $event->length; $time++)
				{	$max_row = max($max_row, $count[$time]);	}
				
				$event->data['max_row'] = $max_row;
				
				$events .= event2html( $event->data, $event->data['eventnr'], $this_day_nr );
				
				//print_r($event->data);
			}
		}
		
		/*
		foreach ($all_events as $event)
		{
			$max_row = 1;
			for($time = $event[starttime]; $time < $event[starttime] + $event[length]; $time++)
			{	$max_row = max($max_row, $count[$time]);	}
			
			$event[max_row] = $max_row;
			
			
			$events .= event2html( $event, $event[eventnr], $this_day_nr );
			
			//print_r($event);
		}*/
		
		//print_r($all_events);
		
		
		
		/*
		// alle Events durchlaufen
		while($event = mysql_fetch_assoc($event_result))
		{
			$events .= event2html( $event, $event[eventnr], $this_day_nr );
		}*/
		
		return $events;		
	}
