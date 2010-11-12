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

	
	$_page->html->set('main_macro', $GLOBALS[tpl_dir].'/application/day/border.tpl/border');
	
	$day_id = mysql_real_escape_string( $_REQUEST['day_id'] );
	
	if( is_numeric( $day_id ) )
	{	$_camp->day( $day_id ) || die( "error" );	}
	
	
	include( 'load_day_list.php' );
	
	
	if( is_numeric( $day_id ) )
	{
		$_page->html->set( 'day_selected', true );
		include( 'load_job_list.php' );
		include( 'load_event_list.php' );
		
		$query = "	SELECT
						day.story,
						day.notes,
						(day.day_offset + subcamp.start) as day_date
					FROM
						day,
						subcamp
					WHERE
						day.id = $day_id AND
						day.subcamp_id = subcamp.id";
		$result = mysql_query( $query );
		
		$day_date = new c_date();
		$day_date->setDay2000( mysql_result( $result, 0, 'day_date' ) );
		
		$day_str = strtr( $day_date->getString( 'l d.m.Y' ), $GLOBALS[en_to_de] );
		
		$day_story = mysql_result( $result, 0, 'story' );
		$day_notes = mysql_result( $result, 0, 'notes' );
	}
	else
	{
		$_page->html->set( 'day_selected', false );
	}
	
	
	
	$query = "	SELECT category.*
				FROM category
				WHERE category.camp_id = $_camp->id";
	$result = mysql_query( $query );
	
	$categories = array();
	while( $category = mysql_fetch_assoc( $result ) )
	{	$categories[] = $category;	}
	
	$_js_env->add( 'categories', $categories );
	
	
	$day = array(
			"list_border" 	=> array( "title" => "Liste aller Tage", "macro" => $GLOBALS[tpl_dir]."/application/day/list.tpl/list" ),
			"day_border"	=> array( "title" => "Tagesübersicht", "macro" => $GLOBALS[tpl_dir]."/application/day/day.tpl/day" ),
			"day_list"		=> $day_list,
			"job_list"		=> $job_list,
			"event_list"	=> $event_list,
			"day_str"		=> $day_str,
			"day_id"		=> $day_id,
			"day_story"		=> $day_story,
			"day_notes"		=> $day_notes
		);
	
	//print_r( $day );
	
	$_page->html->set( 'day', $day );
	$_js_env->add( 'event_list', $event_list );

	
	
	
	//	INFOBOX:
	// ==========
	
	include("module/info/category.php");
	
	$_page->html->set( 'show_info_box', true );
	$_page->html->set( 'info_box', $GLOBALS[tpl_dir].'/module/info/info_box.tpl/info_box' );
?>