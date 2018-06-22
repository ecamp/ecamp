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
	$scoutname	= $_REQUEST['scoutname'];
	$firstname	= $_REQUEST['firstname'];
	$surname = $_REQUEST['surname'];
	$mail = $_REQUEST['mail'];

	if ($_camp->is_course)
		$query = "SELECT * FROM dropdown WHERE list = 'function_course'";
	else
		$query = "SELECT * FROM dropdown WHERE list = 'function_camp'";
	
	$reuslt = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	$option = "";
	while ($row = mysqli_fetch_assoc($reuslt))
	{
		if ($row[id] == $std)
		{	$selected = " selected=selected "; }
		else
		{	$selected = ""; }
		
		$option .= gettemplate_app(
			'option', array(
				'value' => $row['id'],
				'content' => $row['entry'],
				'selected' => $selected
			)
		);
	}
	$select = gettemplate_app('select', array("name" => "function", "content" => $option));
	
	$search_arg = array("1");
	if (!empty($scoutname)) {	$search_arg[] = " scoutname LIKE '$scoutname%' "; }
	if (!empty($firstname)) {	$search_arg[] = " firstname LIKE '$firstname%' "; }
	if (!empty($surname)) {	$search_arg[] = " surname LIKE '$surname%' "; }
	if (!empty($mail)) {	$search_arg[] = " mail LIKE '$mail%' "; }
	
	$query = "SELECT * FROM user WHERE ".implode(" AND ", $search_arg);
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	$found_users = "";
	while ($found = mysqli_fetch_assoc($result))
	{	
		$found['function_list'] = $select;
		$found_users .= gettemplate_app('add_search_result_user', $found);	
	}

	$index_content['main'] .= gettemplate_app(
		'add_search_result', array(
			"content" => $found_users,
			"scoutname" => $scoutname,
			"firstname" => $firstname,
			"surname" => $surname,
			"mail" => $mail,
			"std" => $std
		)
	);
?>