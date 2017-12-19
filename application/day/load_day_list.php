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

	$date = new c_date();
	$day_list = array();
	
	$query = "	SELECT
					subcamp.id,
					subcamp.start,
					subcamp.length
				FROM
					subcamp
				WHERE
					subcamp.camp_id = $_camp->id
				ORDER BY
					subcamp.start";
	$result = mysql_query( $query );
	
	while( $subcamp = mysql_fetch_assoc( $result ) )
	{
		$subcamp['end'] = $subcamp['start'] + $subcamp['length'];
		
		$subcamp['start_str'] = $date->setDay2000( $subcamp['start'] )->getString( 'd.m.Y' );
		$subcamp['end_str'] = $date->setDay2000( $subcamp['end'] )->getString( 'd.m.Y' );
		
		$day_list[ $subcamp['id'] ]['subcamp'] = $subcamp;
		$day_list[ $subcamp['id'] ]['days'] = array();
		
		$query = "	SELECT
						day.id,
						day.day_offset
					FROM
						day
					WHERE
						day.subcamp_id = " . $subcamp['id'];
		$day_result = mysql_query( $query );
		
		while( $day = mysql_fetch_assoc( $day_result ) )
		{
			if( ! is_numeric( $day_id ) )
			{	$day_id = $day['id'];	}
			
			$day['date'] = $subcamp['start'] + $day['day_offset'];
			$day['date_str'] = $date->setDay2000( $day['date'] )->getString( 'd.m.Y' );
			$day['day_str'] = strtr( $date->setDay2000( $day['date'] )->getString( 'l' ), $GLOBALS[en_to_de] );
			$day['link'] = "index.php?app=day&cmd=home&day_id=" . $day['id'];
			
			$day['bold'] = ( $day_id == $day['id'] ) ? true : false;
			
			$day_list[ $subcamp['id'] ]['days'][$day['day_offset']] = $day;
		}
		ksort( $day_list[ $subcamp['id'] ]['days'] );
	}
