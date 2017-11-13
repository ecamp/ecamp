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

	include_once( 'include/load_all_events.php' );

	$print = array(
		"view" 			=> array(	"title" => "Zusammenstellung",	"macro" => $GLOBALS['tpl_dir']."/application/print/view.tpl/view" ),
		"libary" 		=> array(	"title" => "Auswahl",			"macro" => $GLOBALS['tpl_dir']."/application/print/libary.tpl/libary" ),
		"bin"			=> array(	"title" => "Abfalleimer", 		"macro" => $GLOBALS['tpl_dir']."/application/print/bin.tpl/bin" )
	);
	
	$_page->html->set( 'print', $print );
	$_page->html->set( 'main_macro', $GLOBALS['tpl_dir'].'/application/print/border.tpl/border' );
?>