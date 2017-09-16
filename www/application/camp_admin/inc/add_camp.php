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

	$select_content = "";
	
	if( $_camp->is_course )
		$query = "SELECT * FROM dropdown WHERE list = 'function_course'";
	else
		$query = "SELECT * FROM dropdown WHERE list = 'function_camp'";
		
	$result = mysql_query($query);
	while($option = mysql_fetch_assoc($result))
	{	$select_content .= gettemplate_app('add_camp_function', array("value" => $option[id], "function" => $option[entry]));	}

	$index_content['main'] .= gettemplate_app('add_camp', array("function" => $select_content));
?>