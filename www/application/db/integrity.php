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

	
	$_page->html->set('main_macro', $GLOBALS[tpl_dir].'/global/content_box_fit.tpl/predefine');
	$_page->html->set('box_content', $GLOBALS[tpl_dir].'/application/db/integrity.tpl/integrity');
	$_page->html->set('box_title', 'Integrity:');
	
	
	$subCampLength = array();
	
	$query = "	Select 
					camp.id as camp_id, 
					subcamp.id as subcamp_id, 
					subcamp.length as subcamp_length, 
					days.length as days_length
				FROM 
					camp, 
					subcamp, 
					(
						Select 
							day.subcamp_id, 
							COUNT(day.id) as length 
						FROM 
							day 
						GROUP BY 
							day.subcamp_id
					) as days
				WHERE
					camp.id = subcamp.camp_id AND
					days.subcamp_id = subcamp.id AND
					subcamp.length != days.length";
					
	$result = mysql_query( $query );
	while( $error = mysql_fetch_assoc( $result ) )
	{	$subCampLength[] = $error;	}
	
	
	
	$_page->html->set( 'subCampLength', $subCampLength );
	
	
	
	
	
	
	$eventDetailSorting = array();
	
	$query = "	Select 
					event_id 
				FROM 
				(
					SELECT 
					  	event_id, 
					  	count(id) as dcount, 
					  	SUM(sorting) as dsum, 
					  	MAX(sorting) as dmax 
					FROM 
						event_detail
					GROUP BY 
						event_id
				) as errorTable
				WHERE 
					dmax != dcount OR 
					dsum != ( dcount*(dcount+1)/2 )";
	
	$result = mysql_query( $query );
	while( $error = mysql_fetch_assoc( $result ) )
	{	$eventDetailSorting[] = $error;	}

	$_page->html->set( 'eventDetailSorting', $eventDetailSorting );

	
?>