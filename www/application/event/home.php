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

	
	$_page->html = new PHPTAL('template/application/event/home.tpl');
	
	
	
	$observer = 		file_get_contents( "public/global/js/observer.js" );
	$autocompleter = 	file_get_contents( "public/global/js/autocompleter.js" );
	
	$_page->html->set( 'observer', 		$observer );
	$_page->html->set( 'autocompleter', $autocompleter );
	
	
	
	
	$event_id = mysql_real_escape_string($_REQUEST[event_id]);
	$_camp->event( $event_id ) || die( "error" );
	
	$_page->html->set( 'event_id', $event_id );
	
//	NAME:
// =======

	$query = "	SELECT
					event.name,
					event.place,
					event.progress,
					category.short_name,
					category.form_type
				FROM
					event,
					category
				WHERE
					event.id = $event_id AND
					event.category_id = category.id";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	
	if( $row['short_name'] != "" )
	{	$_page->html->set( 'category_short', $row['short_name'] . ":" );	}
	else
	{	$_page->html->set( 'category_short', "" );	}
	$_page->html->set( 'name', $row['name'] );
	$_page->html->set( 'form_type', $row['form_type'] );
	$event_place = $row['place'];
	
	if( $row['form_type'] == 0 )	{	die();	}
	
	$_page->html->set( 'event_progress', $row['progress'] );

//	HEADER:
// =========
	
	$query = "	SELECT
					user.scoutname,
					user.firstname,
					user.surname
				FROM
					event_responsible,
					user
				WHERE
					event_responsible.event_id = $event_id AND
					event_responsible.user_id = user.id ";
	
	$result = mysql_query($query);
	
	$users = array();
	$dp_header = array( "users" => $users );
	
	while($row = mysql_fetch_assoc($result))
	{
		if(!empty($row[scoutname]))
		{	array_push( $dp_header['users'], $row[scoutname] );	}
		else
		{	array_push( $dp_header['users'], $row[firstname] . " " . $row[surname] );	}
	}
	
	$dp_header['place'] =  array(
									"value" 	=> $event_place,
									"event_id" 	=> $event_id,
									"script"	=> "action_change_place"
								);
	
	$query = "	SELECT
					event_instance.starttime,
					event_instance.length,
					day.day_offset + subcamp.start as startdate,
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
					day.day_offset + 1 as day_nr
				FROM
					event_instance,
					day,
					subcamp
				WHERE
					event_instance.event_id = $event_id AND
					event_instance.day_id = day.id AND
					day.subcamp_id = subcamp.id
				ORDER BY
					startdate, event_nr";
	
	$query = "	SELECT
					event_instance.starttime,
					event_instance.length,
					day.day_offset + subcamp.start as startdate,
					v_event_nr.event_nr,
					v_event_nr.day_nr
				FROM
					v_event_nr,
					event_instance,
					day,
					subcamp
				WHERE
					v_event_nr.event_instance_id = event_instance.id AND
					event_instance.event_id = $event_id AND
					event_instance.day_id = day.id AND
					day.subcamp_id = subcamp.id
				ORDER BY
					startdate, event_nr";
	$result = mysql_query( $query );
	
	$date 	= new c_date;
	$start 	= new c_time;
	$end 	= new c_time;
	$dp_header['event_instance'] = array();
	
	
	
	$row = mysql_fetch_assoc( $result );
	$_page->html->set( 'event_nr', "(" . $row['day_nr'] . "." . $row['event_nr'] . ")");
	
	do 
	{
		$date->setDay2000($row['startdate']);
		$start->setValue($row['starttime']);
		$end->setValue($row['starttime'] + $row['length']);
		
		$dp_header['event_instance'][] = array(
												'event_nr'	=> "(" . $row['day_nr'] . "." . $row['event_nr'] . ")",
												'startdate' => date("d.m.Y", $date->getUnix()),
												'starttime' => $start->getString("H:i") . " - " . $end->getString("H:i")
											);
	} while($row = mysql_fetch_assoc( $result ) );
	
	$_page->html->set( 'dp_header', $dp_header );
	
	//echo "dp_header=>";
	//print_r( $dp_header );
	
	
//	HEAD:
// =======
	
	$dp_head_show = array();
	$query = "	SELECT
					dropdown.value as form,
					(dropdown.value = category.form_type) as show_form
				FROM
					event,
					category,
					dropdown
				WHERE
					event.id = $event_id AND
					event.category_id = category.id AND
					dropdown.list = 'form'";
	$result = mysql_query($query);
	while( $row = mysql_fetch_assoc( $result ) )
	{	$dp_head_show[ $row[form] ] = $row[show_form];	}
	
	$_page->html->set( 'dp_head_show', $dp_head_show );
	
	
	$query = "	SELECT
					event.aim as aim,
					event.story as story,
					event.method as method,
					event.topics as topics,
					'true' as visible
				FROM
					event
				WHERE
					event.id = $event_id";
	$result = mysql_query($query);
	$replace = mysql_fetch_assoc($result);
	
	$dp_head = array();
	
	$dp_head['aim'] = array(
								"value" => $replace['aim'],
								"script"	=> "action_change_aim",
								"event_id"	=> $event_id
							);
	$dp_head['story'] = array(
								"value" => $replace['story'],
								"script"	=> "action_change_story",
								"event_id"	=>	$event_id
							);
	$dp_head['method'] = array(
								"value" => $replace['method'],
								"script"	=> "action_change_method",
								"event_id"	=>	$event_id
							);
							
	
	$dp_head['topics'] = array(
								"value" => $replace['topics'],
								"script"	=> "action_change_topics",
								"event_id"	=>	$event_id
							);
	
							
	$_page->html->set( 'dp_head', $dp_head );	

	
	
	
	
	// 	LOAD:
	// =======
	
	include( "load_ablauf.php" );
	include( "load_mat.php" );
	include( "load_siko.php" );
	include( "load_pdf.php" );
	include( "load_comment.php" );
	
	include( "load_aim.php" );
	include( "load_checklist.php" );
	
	include( "load_mat_list.php" );
	include( "load_leader.php" );
	include( "load_mat_organize_resp.php" );
	
	
	//$_js_env->add( 'event_id', $event_id );
	
?>