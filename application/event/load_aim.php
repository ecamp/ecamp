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

	$course_aim = array();
	
	$query = "	SELECT
					course_aim.*
				FROM
					course_aim
				WHERE
					course_aim.camp_id = $_camp->id AND
					ISNULL( course_aim.pid )";	
	$result = mysql_query( $query );
	
	if( !mysql_error() && mysql_num_rows( $result ) )
	{
		while( $aim_group = mysql_fetch_assoc( $result ) )
		{
			$subquery = "	SELECT
								course_aim.id,
								course_aim.aim,
								!ISNULL( event_aim.id ) as checked
							FROM
								course_aim
							LEFT JOIN
								(
									SELECT *
									FROM event_aim
									WHERE event_aim.event_id = $event_id
								) as event_aim
							ON
								event_aim.aim_id = course_aim.id
							WHERE
								course_aim.camp_id = $_camp->id AND
								course_aim.pid = " . $aim_group['id'];
			$subresult = mysql_query( $subquery );
			
			if( !mysql_error() && mysql_num_rows( $subresult ) )
			{
				while( $aim = mysql_fetch_assoc( $subresult ) )
				{				
					$course_aim[ $aim_group['id'] ][ 'aim' ] = $aim_group['aim'];
					$course_aim[ $aim_group['id'] ][ 'childs' ][] = $aim;
				}
			}
		}
	}
	
	$_js_env->add( 'course_aim', $course_aim );
