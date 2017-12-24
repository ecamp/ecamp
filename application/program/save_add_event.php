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

	//	index.php?app=program&cmd=save_add_event&day_id=1&name=&category=1&starttime_h=0&starttime_min=0&length_h=0&length_min=0&resp_user=
	
	include( 'inc/get_program_update.php');
	$time				= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['time']);
	
	$day_id				= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['day_id']);
	
	$event_name			= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['name']);
	$event_category_id	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['category']);
	
	$event_instance_starttime_h 	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['starttime_h']);
	$event_instance_starttime_min 	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['starttime_min']);
	
	$event_instance_length_h 	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['length_h']);
	$event_instance_length_min 	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['length_min']);
	
	$event_resp_user	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['resp_user']);
	$event_resp_user 	= explode("_", substr($event_resp_user, 0, -1) );
	
	$_camp->day( $day_id ) || die( "error" );
	$_camp->category( $event_category_id ) || die( "error" );
	
	$starttime 	= 60 * $event_instance_starttime_h + $event_instance_starttime_min;
	$length 	= 60 * $event_instance_length_h + $event_instance_length_min;
	
	$query = "INSERT INTO event ( camp_id, category_id, name ) VALUES ( $_camp->id, $event_category_id, '$event_name' )";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	$event_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
	
	foreach( $event_resp_user as $resp_user )
	{
		$resp_user = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $resp_user );
		if( !is_numeric( $resp_user ) )
		{	break;	}
		
		$query = "INSERT INTO event_responsible ( user_id, event_id ) VALUES ( $resp_user, $event_id )";
		mysqli_query($GLOBALS["___mysqli_ston"], $query);
		
		$query = "SELECT active FROM user_camp WHERE camp_id = $_camp->id AND user_id = $resp_user";
		$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		$active = mysqli_result( $result,  0,  'active' );
		
		if( $resp_user != $_user->id && $active )
		{
			$_news->add2user( 
				"Verantwortung für $event_name",
				"Dir wurde die Verantwortung für den Block '$event_name' zugeteilt.",
				time(), $resp_user );
		}
	}
	
	$query = "	SELECT day2.id 
				FROM day as day1, day as day2 
				WHERE
					day2.subcamp_id = day1.subcamp_id AND
					day2.day_offset = day1.day_offset + 1 AND
					day1.id = " . $day_id;
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	if( 	// Block splitting!
			mysqli_num_rows( $result )
			&&
			(
				( $starttime < $GLOBALS['time_shift'] && ( $starttime + $length ) > $GLOBALS['time_shift'] )
				||
				( $starttime > $GLOBALS['time_shift'] && ( $starttime + $length ) > 24*60 + $GLOBALS['time_shift'] )
			)
		)
	{
		$day2_id = mysqli_result( $result,  0,  'id' );
		
		$starttime1 = $starttime;
		$starttime2 = $GLOBALS['time_shift'];
		
		if( $starttime < $GLOBALS['time_shift'] )
		{	$length1 = $GLOBALS['time_shift'] - $starttime;	}
		else
		{	$length1 = 24*60 + $GLOBALS['time_shift'] - $starttime;	}
		
		$length2 = $length - $length1;
		
		$query = "INSERT INTO event_instance ( event_id, day_id, starttime, length ) VALUES ( $event_id, $day_id, $starttime1, $length1 )";
		mysqli_query($GLOBALS["___mysqli_ston"], $query);
		$query = "INSERT INTO event_instance ( event_id, day_id, starttime, length ) VALUES ( $event_id, $day2_id, $starttime2, $length2 )";
		mysqli_query($GLOBALS["___mysqli_ston"], $query);
	}
	else
	{
		$query = "INSERT INTO event_instance ( event_id, day_id, starttime, length ) VALUES ( $event_id, $day_id, $starttime, $length )";
		mysqli_query($GLOBALS["___mysqli_ston"], $query);
	}
	
	header("Content-type: application/json");
	
	$ans = get_program_update( $time );
	echo json_encode( $ans );
	
	die();
	
	die();
	