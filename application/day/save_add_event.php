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

	$name 		= mysql_real_escape_string( $_REQUEST['name'] );
	$category 	= mysql_real_escape_string( $_REQUEST['category'] );
	$start_h	= mysql_real_escape_string( $_REQUEST['start_h'] );
	$start_min	= mysql_real_escape_string( $_REQUEST['start_min'] );
	$length_h	= mysql_real_escape_string( $_REQUEST['length_h'] );
	$length_min	= mysql_real_escape_string( $_REQUEST['length_min'] );
	$day_id 	= mysql_real_escape_string( $_REQUEST['day_id'] );
	
	$_camp->category( $category ) || die( "error" );
	$_camp->day( $day_id ) || die( "error" );

	$start  = $start_h * 60  + $start_min;
	$length = $length_h * 60 + $length_min;
	
	if( $start < $GLOBALS['time_shift'] )	{	$start += 24*60;	}
	
	$query = "	INSERT INTO event
				( `camp_id`, `category_id`, `name` )
				VALUES
				( $_camp->id, $category, '$name' )";
	$result = mysql_query( $query );
	$event_id = mysql_insert_id();

	$query = "	SELECT day2.id 
				FROM day as day1, day as day2 
				WHERE
					day2.subcamp_id = day1.subcamp_id AND
					day2.day_offset = day1.day_offset + 1 AND
					day1.id = " . $day_id;
	$result = mysql_query( $query );
	
	if( 	// Block splitting!
			mysql_num_rows( $result )
			&&
			(
				( $start < $GLOBALS['time_shift'] && ( $start + $length ) > $GLOBALS['time_shift'] )
				||
				( $start > $GLOBALS['time_shift'] && ( $start + $length ) > 24*60 + $GLOBALS['time_shift'] )
			)
		)
	{
		$day2_id = mysql_result( $result, 0, 'id');
		
		$starttime1 = $start;
		$starttime2 = $GLOBALS['time_shift'];
		
		if( $start < $GLOBALS['time_shift'] )
		{	$length1 = $GLOBALS['time_shift'] - $start;	}
		else
		{	$length1 = 24*60 + $GLOBALS['time_shift'] - $start;	}
		
		$length2 = $length - $length1;

		$query = "INSERT INTO event_instance ( event_id, day_id, starttime, length ) VALUES ( $event_id, $day_id, $starttime1, $length1 )";
		mysql_query($query);
		$query = "INSERT INTO event_instance ( event_id, day_id, starttime, length ) VALUES ( $event_id, $day2_id, $starttime2, $length2 )";
		mysql_query($query);
	}
	else
	{
		$query = "	INSERT INTO event_instance
				( `event_id`, `day_id`, `starttime`, `length`, `dleft`, `width` )
				VALUES
				( $event_id, $day_id, $start, $length, 0, 1 )";
		mysql_query( $query );
	}

	$ans = array( "error" => false );
	echo json_encode( $ans );
	die();
