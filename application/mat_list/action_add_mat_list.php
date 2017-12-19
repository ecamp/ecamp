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

	$mat_list_name = mysql_real_escape_string( $_REQUEST['mat_list_name'] );
	$mat_list_name_js = htmlentities_utf8($_REQUEST['mat_list_name']);
	
	$query = "INSERT INTO mat_list (`camp_id`, `name`) VALUES ( $_camp->id, '$mat_list_name' )";
	mysql_query( $query );
	
	if( mysql_error() )
	{
		$ans = array( "error" => true, "error_msg" => "Einkaufliste konnte nicht erstellt werden." );
		echo json_encode( $ans );
		die();
	}
	else
	{
		$mat_list_id = mysql_insert_id();
		
		$ans = array( "error" => false, "mat_list_id" => $mat_list_id, "mat_list_name" => $mat_list_name_js );
		echo json_encode( $ans );
		die();
	}
	
	die();
