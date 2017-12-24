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

	$_page->html->set('main_macro', $GLOBALS['tpl_dir'].'/global/content_box_fit.tpl/predefine');
	$_page->html->set('box_content', $GLOBALS['tpl_dir'].'/application/camp_admin/new_camp.tpl/new_camp');
	$_page->html->set('box_title', 'Neues Lager erstellen');
	
	$query = "	SELECT *
				FROM dropdown
				WHERE list = 'function_camp' AND value > 0";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	$functions = array();

	while( $function = mysqli_fetch_assoc( $result ) )
	{	$functions[] = $function;	}
	
	$query = "	SELECT *
				FROM dropdown
				WHERE list = 'camptype'";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	$camptypes = array();
	
	while( $camptype = mysqli_fetch_assoc( $result ) )
	{	$camptypes[] = $camptype;	}

	$query = "	SELECT *
				FROM dropdown
				WHERE list = 'jstype'";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	$jstypes = array();
	
	while( $jstype = mysqli_fetch_assoc( $result ) )
	{	$jstypes[] = $jstype;	}

	$_page->html->set( 'functions', $functions );
	$_page->html->set( 'camptypes', $camptypes );
	$_page->html->set( 'jstypes', $jstypes );
