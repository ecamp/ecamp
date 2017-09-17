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

	require_once( "application/day/inc/prog_color.php" );
	
	$_page->html->set('main_macro', $GLOBALS[tpl_dir].'/global/content_box_fit.tpl/predefine');
	$_page->html->set('box_content', $GLOBALS[tpl_dir].'/application/my_resp/home.tpl/home');
	$_page->html->set('box_title', "Meine Verantwortung");
    $date = new c_date();

    // Events
    $events = array();
    $query = "	SELECT
    				event.id,
    				event.name,
    				event.progress,
    				category.form_type,
    				category.short_name,
    				category.color,
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
    				event_responsible,
    				category,
    				event_instance,
    				day,
    				subcamp
    			WHERE
    				event_responsible.user_id = " . $_user->id . " AND
    				event.camp_id = " . $_camp->id . " AND
    				event_responsible.event_id = event.id AND
    				event.category_id = category.id AND
    				event_instance.event_id = event.id AND
    				event_instance.day_id = day.id AND
    				day.subcamp_id = subcamp.id
    			ORDER BY date, starttime";
    
    $query = "	SELECT
    				event.id,
    				event.name,
    				event.progress,
    				category.form_type,
    				category.short_name,
    				category.color,
    				(day.day_offset + subcamp.start) as date,
    				v.day_nr as day_offset,
    				v.event_nr,
					category.form_type,
					event_instance.starttime
    			FROM
    				(".getQueryEventNr($_camp->id).") v,
    				event,
    				event_responsible,
    				category,
    				event_instance,
    				day,
    				subcamp
    			WHERE
    				v.event_instance_id = event_instance.id AND
    				event_responsible.user_id = " . $_user->id . " AND
    				event.camp_id = " . $_camp->id . " AND
    				event_responsible.event_id = event.id AND
    				event.category_id = category.id AND
    				event_instance.event_id = event.id AND
    				event_instance.day_id = day.id AND
    				day.subcamp_id = subcamp.id
    			ORDER BY date, starttime";
    $result = mysql_query($query);
    while( $event = mysql_fetch_assoc($result) )
    {
    	$date->setDay2000( $event['date'] );
    	
    	$event['link'] = '$event.edit(' . $event[id] . ')';
    	$event['color_str'] = "background-color:#" . $event['color'];
    	
    	if( $event['form_type'] )
		{	$event['prog_color'] = get_progress_color( $event['progress'] );	}
		else
		{	$event['prog_color'] = "#000000";	}
		
    	$event['show_event_nr'] = ( $event[form_type] > 0 );
    	
    	
    	$events[$event['date']]['day_offset'] = $event['day_offset'];
    	$events[$event['date']]['date'] = $date->getString( 'd.m.Y' );
    	$events[$event['date']]['data'][] = $event;
    }
    //echo "events => ";
    //print_r($events);

    // day_jobs
    $day_jobs = array();
    $query = "	SELECT
    				job.job_name,
    				day.id,
    				(day.day_offset + subcamp.start) as date,
    				(
    					SELECT
    						IFNULL( SUM( s.length ), 0 )
    					FROM
    						subcamp s
    					WHERE
    						s.camp_id = subcamp.camp_id AND
    						s.start < subcamp.start
    				) + day.day_offset + 1 as day_offset 
    			FROM
    				job, 
    				job_day,
    				day,
    				subcamp
    			WHERE
    				job.camp_id = " . $_camp->id . " AND
    				job_day.user_camp_id = " . $_user_camp->id . " AND
    				job.id = job_day.job_id AND
    				job_day.day_id = day.id AND
    				day.subcamp_id = subcamp.id
    			ORDER BY day_offset";
    $result = mysql_query($query);
    while( $day_job = mysql_fetch_assoc( $result ) )
    {
    	$date->setDay2000( $day_job['date'] );
    	
    	$day_job['date_string'] = $date->getString( "d.m.Y" );
    	$day_jobs[$day_job['date']]['link'] = "index.php?app=day&cmd=home&day_id=" . $day_job['id'];
    	$day_jobs[$day_job['date']]['date'] = $day_job['date_string'];
    	$day_jobs[$day_job['date']]['day_offset'] = $day_job['day_offset'];
    	$day_jobs[$day_job['date']]['data'][] = $day_job;
    }
    //echo "day_jobs => ";
    //print_r($day_jobs);
    
    // todo
    $todos = array();
    $query = "	SELECT
    				todo.title,
    				todo.date,
    				todo.done
    			FROM
    				todo,
    				todo_user_camp
    			WHERE
    				todo.camp_id = " . $_camp->id . " AND
    				todo_user_camp.user_camp_id = " . $_user_camp->id . " AND
    				todo.id = todo_user_camp.todo_id 
       			ORDER BY todo.date";
    $result = mysql_query($query);
    while( $todo = mysql_fetch_assoc( $result ) )
    {
    	$date->setDay2000( $todo['date'] );
    	$todo['date_string'] = $date->getString( 'd.m.Y' );
    	$todos[] = $todo;
    }
    //echo "todos => ";
    //print_r($todos);

    $_page->html->set('events', $events);
    $_page->html->set('day_jobs', $day_jobs);
    $_page->html->set('todos', $todos);

	//	INFOBOX:
	// ==========
	include("module/info/category.php");
	
	$_page->html->set( 'show_info_box', true );
	$_page->html->set( 'info_box', $GLOBALS['tpl_dir'].'/module/info/info_box.tpl/info_box' );
?>