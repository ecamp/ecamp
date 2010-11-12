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
	$_page->html->set('box_content', $GLOBALS[tpl_dir].'/application/camp_admin/new_camp.tpl/new_course');
	$_page->html->set('box_title', 'Neuen Kurs erstellen');
	
	$query = "	SELECT *
				FROM dropdown
				WHERE list = 'function_course' AND value > 0";
	$result = mysql_query( $query );
	$functions = array();
	
	
	while( $function = mysql_fetch_assoc( $result ) )
	{	$functions[] = $function;	}
	
	
	
	$query = "	SELECT *
				FROM dropdown
				WHERE list = 'coursetype'";
	$result = mysql_query( $query );
	$coursetypes = array();
	
	while( $coursetype = mysql_fetch_assoc( $result ) )
	{	$coursetypes[] = $coursetype;	}
	
	
	
	$query = "	SELECT *
				FROM dropdown
				WHERE list = 'jstype'";
	$result = mysql_query( $query );
	$jstypes = array();
	
	while( $jstype = mysql_fetch_assoc( $result ) )
	{	$jstypes[] = $jstype;	}
	

	
	
	//$_page->html->set('box_content', $GLOBALS[tpl_dir].'/application/camp_admin/new_camp.tpl/new_course');
	//$_page->html->set('box_title', 'Neuen Kurs erstellen');
	
	$_page->html->set( 'functions', $functions );
	$_page->html->set( 'coursetypes', $coursetypes );
	$_page->html->set( 'jstypes', $jstypes );

?>