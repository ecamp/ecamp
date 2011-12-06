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

	$_page->html->set('main_macro', $GLOBALS[tpl_dir].'/application/course_checklist/border.tpl/border');
		
    ////////////////////////////
	// Todo: Kurstyp von den Einstellungen lsen
	$type = 1; // Basis 1. Stufe
	///////////////////////////
	$type = $_camp->type;
	
	/* alle Events des Camps laden */
	// Events suchen, die die Chechliste erfüllen
	$campevents = array();
	mysql_query("SET SESSION group_concat_max_len = 512");
	$query =   	"SELECT
								  i.id AS instance,
								  e.id,
								  e.name,
								  CONCAT(v.day_nr,'.',v.event_nr) AS nr,
								  i.starttime AS start,
								  i.starttime + i.length AS end,
								  s.start + d.day_offset AS day,
								  c.short_name
								FROM
								  event e,
								  event_instance i,
								  v_event_nr v,
								  day d,
								  subcamp s,
								  category c
								WHERE 
								    e.camp_id=$_camp->id
								AND i.event_id = e.id
								AND v.event_instance_id = i.id
								AND i.day_id = d.id
								AND d.subcamp_id = s.id
								AND e.category_id = c.id
								ORDER BY v.day_nr, v.event_nr";
	
	$result = mysql_query($query);
	while( $this_event = @mysql_fetch_assoc($result) )
	{
		$campevents[$this_event['instance']] = $this_event;
	}
	
	// PBS=0 // J+S=1  //
	for( $i=0; $i<=1; $i++ )
	{
		$list[$i] = array();
		$query = "SELECT * FROM course_checklist WHERE course_type=$type AND checklist_type=$i AND IsNull(pid) ORDER BY short_1";
		$result1 = mysql_query( $query );
		
		while( $this_level1 = @mysql_fetch_assoc($result1) )
		{
			$query = "SELECT * FROM course_checklist WHERE pid=".$this_level1[id]." ORDER BY short_2";
			$result2 = mysql_query( $query );
			$level2 = array();
			
			while( $this_level2 = @mysql_fetch_assoc($result2) )
			{
				// Events suchen, die die Checkliste erfüllen
				$events = array();
				$query =   	"SELECT 
							  i.id
							FROM
							  event_checklist ch,
							  event e,
							  event_instance i
							WHERE 
							    ch.checklist_id = $this_level2[id]
							AND e.camp_id=$_camp->id
							AND e.id = ch.event_id
							AND i.event_id = e.id
							ORDER BY i.day_id, i.starttime";
					
				$result3 = mysql_query($query);
				$no_events = true;
				while( $this_level3_instance = @mysql_fetch_assoc($result3) )
				{
					$this_level3 = $campevents[$this_level3_instance["id"]];
					
					$no_events = false;
					
					$start = new c_time();
					$start->setValue($this_level3[start]);
					
					$end = new c_time();
					$end->setValue($this_level3[end]);
					
					$date = new c_date();
					$date->setDay2000($this_level3[day]);
					
					$this_level3[date] = $GLOBALS[en_to_de][$date->getString("D")].", ".$date->getString("j.n.")." ".$start->getString("G:i")."-".$end->getString("G:i");//"Fr, 5.10. 17:15-18:00";
					
					if( $this_level3['short_name'] )
					{	$this_level3['short_name'] .= ": ";	}
					
					$events[] = $this_level3;
				}
				
				$level2[] = array("short" => $this_level2[short], "name" => $this_level2[name], "no_events" => $no_events, "events" => $events);
			}
			
			$list[$i][] = array("level2" => $level2, "short" => $this_level1[short], "name" => $this_level1[name] );
		}
	}
	
	// PHPTAL Variablen setzen
    $_page->html->set("pbs_list", $list[0]);
	$_page->html->set("js_list", $list[1]);
	
	/* Wechsel zu neuen Checklisten zulassen */
	if( $_camp->type>0 && $_camp->type<=4 )
		$_page->html->set("new_checklist", 1);
	else
		$_page->html->set("new_checklist", 0);
?>