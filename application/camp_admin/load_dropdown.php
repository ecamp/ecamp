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

	if( $_camp->is_course )
		$query_function = "SELECT * FROM dropdown WHERE list = 'function_course' AND value > '0'";
	else
		$query_function = "SELECT * FROM dropdown WHERE list = 'function_camp' AND value > '0'";
			
	$query_camptype = "SELECT value, entry 	FROM dropdown WHERE list = 'camptype'";
	
	$result_function = mysqli_query($GLOBALS["___mysqli_ston"], $query_function);
	$result_camptype = mysqli_query($GLOBALS["___mysqli_ston"], $query_camptype);
	
	$ans_function = array();
	$ans_camptype = array();
	
	while( $row = mysqli_fetch_assoc($result_function) )
	{	$ans_function[] = $row;	}
	
	while( $row = mysqli_fetch_assoc($result_camptype) )
	{	$ans_camptype[] = $row;	}

	$ans = array("function_list" => $ans_function, "camptype_list" => $ans_camptype);
	echo json_encode($ans);
	die();
