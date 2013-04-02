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


	$_page->html->set('main_macro', $GLOBALS[tpl_dir].'/application/option/border.tpl/border');
	
	// Formular-Typen auslesen
	$query = "SELECT * FROM dropdown WHERE list='form'";
	$result = mysql_query($query);
	while( $typ = mysql_fetch_assoc($result) )
	{
		$form[$typ['value']] = $typ['entry'];
	}

	
	
	// Kategorien auslesen
	$query = "SELECT * FROM category WHERE camp_id = '$_camp->id'";
	$result = mysql_query($query);
	$category_list = array();
	while($category = mysql_fetch_assoc($result))
	{
		if( $form[$category[form_type]] == "" )
			$this_typ = htmlspecialchars("<unbekannt>");
		else
			$this_typ = $form[$category[form_type]];
			
		if( ! ctype_xdigit($category[color]) )
			$category[color] = "ffffff";
		
		$category_list[] = array(
								"id" 			=> $category[id],
								"name" 			=> $category[name],
								"short_name" 	=> $category[short_name],
								"color" 		=> $category[color],
								"form_type" 	=> $this_typ,
								"form_type_id"  => $category[form_type] );
	}
	
	// Jobs auslesen
	// Jobs laden
	
	$job_list = array();
	$job_list["master"] = array();
	$job_list["slave"] = array();
	
	$query = "SELECT * FROM job WHERE camp_id = '$_camp->id'";
	$result = mysql_query( $query );
	while( $job = mysql_fetch_assoc($result) )
	{
		if( $job[show_gp] )
			$job_list["master"][] = array( "id" => $job[id], "name" => $job[job_name] );
		else
			$job_list["slave"][] = array( "id" => $job[id], "name" => $job[job_name] );
	}
	
	
	
	
	
	$mat_lists = array();
	
	$query = "SELECT * FROM mat_list WHERE camp_id = $_camp->id";
	$result = mysql_query( $query );
	while( $mat_list = mysql_fetch_assoc( $result ) )
	{	$mat_lists[] = $mat_list;	}
	
	
	
	
	
	
	$option = array(
			"jobs" 			=> array( "title" => "Tagesjobs", "macro" => $GLOBALS[tpl_dir]."/application/option/jobs.tpl/jobs" ),
			"category"		=> array( "title" => "Block - Kategorien", "macro" => $GLOBALS[tpl_dir]."/application/option/category.tpl/category" ),
			"mat_list" 		=> array( "title" => "Einkaufslisten", "macro" => $GLOBALS[tpl_dir]."/application/option/mat_list.tpl/mat_list" ),
			"job_list"		=> $job_list,
			"category_list" => $category_list,
			"mat_lists"		=> $mat_lists
		);
	
	$_page->html->set( 'option', $option );
	
	//print_r($option);
	//die();
?>