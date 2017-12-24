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
	
	$course_checklist = array();
	
	$query = "	SELECT
					course_checklist.*
				FROM
					course_checklist,
					camp
				WHERE
					course_checklist.course_type = camp.type AND
					camp.id = $_camp->id AND
					camp.is_course = 1 AND
					ISNULL( course_checklist.pid )";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	if( !mysqli_error($GLOBALS["___mysqli_ston"]) && mysqli_num_rows( $result ) )
	{
		while( $checklist_group = mysqli_fetch_assoc( $result ) )
		{
			$subquery = "	SELECT
								course_checklist.id,
								course_checklist.short,
								course_checklist.name,
								!ISNULL( event_checklist.id ) as checked
							FROM
								course_checklist
							LEFT JOIN
								(SELECT
									event_checklist.*
								FROM
									event_checklist
								WHERE
									event_id = $event_id
								) as event_checklist
							ON
								event_checklist.checklist_id = course_checklist.id
							WHERE
								course_checklist.pid = " . $checklist_group['id'];
			$subresult = mysqli_query($GLOBALS["___mysqli_ston"],  $subquery );
			
			if( !mysqli_error($GLOBALS["___mysqli_ston"]) && mysqli_num_rows( $subresult ) )
			{
				while( $checklist = mysqli_fetch_assoc( $subresult ) )
				{
					$checklist['display'] = $checklist['short'] . " " . $checklist['name'];
					
					$course_checklist[ $checklist_group['id'] ][ 'short' ] = $checklist_group['short'];
					$course_checklist[ $checklist_group['id'] ][ 'name' ] = $checklist_group['name'];
					$course_checklist[ $checklist_group['id'] ][ 'display' ] = $checklist_group['short'] . " " . $checklist_group['name'];
					$course_checklist[ $checklist_group['id'] ][ 'childs' ][] = $checklist;
				}
			}
		}
	}

	$_js_env->add( 'course_checklist', $course_checklist );	
