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

	$_page->html->set('main_macro', $GLOBALS['tpl_dir'].'/application/aim/border.tpl/border');
	
	/* alle Events des Camps laden */
	$campevents = array();
	mysqli_query($GLOBALS["___mysqli_ston"], "SET SESSION group_concat_max_len = 512");
	$query = "SELECT
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
								  (".getQueryEventNr($_camp->id).") v,
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
	
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	while( $this_event = @mysqli_fetch_assoc($result) )
	{
		$campevents[$this_event['instance']] = $this_event;
	}
	
	// Leitziele laden
	$query = "SELECT * FROM course_aim WHERE IsNull(pid) AND camp_id = $_camp->id";
	$result1 = mysqli_query($GLOBALS["___mysqli_ston"],  $query );

	$aim_level1 = array();
	while( $this_aim1 = mysqli_fetch_assoc($result1) )
	{
		// Ausbildungsziele laden
		$query = "SELECT * FROM course_aim WHERE pid=".$this_aim1['id']." AND camp_id = $_camp->id";
		$result2 = mysqli_query($GLOBALS["___mysqli_ston"],  $query );

		$aim_level2 = array();
		while( $this_aim2 = mysqli_fetch_assoc($result2) )
		{
			// Programmblöcke laden
			$query = "SELECT i.id
						FROM event_aim a, event e, event_instance i
						WHERE   a.aim_id=".$this_aim2['id']." 
							AND a.event_id=e.id
							AND e.id = i.event_id
						ORDER BY i.day_id, i.starttime";
							
			$result3 = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
			
			$event = array();
			while( $this_event_instance = mysqli_fetch_assoc($result3) )
			{
				$this_event = $campevents[$this_event_instance["id"]];
				
				$start = new c_time();
				$start->setValue($this_event['start']);
				
				$end = new c_time();
				$end->setValue($this_event['end']);
				
				$date = new c_date();
				$date->setDay2000($this_event['day']);
				
				$this_date = $GLOBALS['en_to_de'][$date->getString("D")].", ".$date->getString("j.n.")." ".$start->getString("G:i")."-".$end->getString("G:i"); //"Fr, 5.10. 17:15-18:00";
				
				if ($this_event['short_name'])
				{	$this_event['short_name'] .= ": "; }
				
				$event[] = array("nr" => $this_event['nr'], "short_name" => $this_event['short_name'], "name" => $this_event['name'], "id" => $this_event['id'], "date" => $this_date);
			}
		
			$aim_level2[] = array("text" => $this_aim2['aim'], "id" => $this_aim2['id'], "event" => $event, "hasNoChildren" => (mysqli_num_rows($result3) == 0));
		}
		
		
		$aim_level1[] = array("text" => $this_aim1['aim'], "id" => $this_aim1['id'], "aim_level2" => $aim_level2, "hasNoChildren" => (mysqli_num_rows($result2) == 0));
	}

	$_page->html->set('aim_level1', $aim_level1);
	if ($_REQUEST['overview'] == 1) $_page->html->set('overview', true);
	else $_page->html->set('overview', false);
	
	// JS Umgebung laden
	$_js_env->add("template_aim1", file("template/application/aim/popup_new_aim1.tpl"));
	$_js_env->add("template_aim2", file("template/application/aim/popup_new_aim2.tpl"));
	
	$aim = array( 
		"intro" => array(
			"title" => "Kursziele",
			"macro" => $GLOBALS['tpl_dir']."/application/aim/main.tpl/home"
		),
		"level1"=> array(
			"title" => "Leitziele",
			"macro" => $GLOBALS['tpl_dir']."/application/aim/main.tpl/level1"
		)
	);
	$_page->html->set('aim', $aim);
