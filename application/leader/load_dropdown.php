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
		$query = "SELECT id, entry FROM dropdown WHERE list = 'function_course' AND value > '0'";
	else
		$query = "SELECT id, entry FROM dropdown WHERE list = 'function_camp' AND value > '0'";
	
	$reslut_function = mysql_query($query);
	
	$ans_function = array();
	
	while( $row = mysql_fetch_assoc($reslut_function) )
	{	$ans_function[] = $row;	}
	
	
	$ans = $ans_function;
	echo json_encode($ans);
	die();
