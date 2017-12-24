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

	$std = $_REQUEST['std'];

	if( $_camp->is_course )
		$query = "SELECT * FROM dropdown WHERE list = 'function_course' AND id = '$std'";
	else
		$query = "SELECT * FROM dropdown WHERE list = 'function_camp' AND id = '$std'";
		
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	$function = implode(mysqli_fetch_assoc($result));

	$index_content['main'] .= gettemplate_app('add', array("function" => $function, "std" => $std));
