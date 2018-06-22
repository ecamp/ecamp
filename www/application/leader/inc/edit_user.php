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

	$id = $_REQUEST['id'];
	
	$query = "SELECT * FROM user WHERE id = '$id'";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	$user = mysqli_fetch_assoc($result);
	$user['birthday'] = date("d.m.Y", $user['birthday']);
	
	# Geschlechtsoption:
	#
	###########################
	$query = "SELECT * FROM dropdown WHERE list = 'sex' ORDER BY id ASC";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	$sex_option = "";
	while ($row = mysqli_fetch_assoc($result))
	{	if ($row['id'] == $user['sex'])
		{	$selected = " selected=selected"; }
		else
		{	$selected = ""; }
		
		$sex_option .= gettemplate_app('option', array("value" => $row['id'], "content" => $row['entry'], "selected" => $selected));
	}
	
	# JS Ausbildung:
	#
	###########################
	$query = "SELECT * FROM dropdown WHERE list = 'jsedu' ORDER BY id ASC";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	$jsedu_option = "";
	while ($row = mysqli_fetch_assoc($result))
	{	if ($row['id'] == $user['jsedu'])
		{	$selected = " selected=selected"; }
		else
		{	$selected = ""; }
		$jsedu_option .= gettemplate_app('option', array("value" => $row['id'], "content" => $row['entry'], "selected" => $selected));
	}
	
	# PBS Ausbildung:
	#
	###########################
	$query = "SELECT * FROM dropdown WHERE list = 'pbsedu' ORDER BY id ASC";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	$pbsedu_option = "";
	while ($row = mysqli_fetch_assoc($result))
	{	if ($row['id'] == $user['pbsedu'])
		{	$selected = " selected=selected"; }
		else
		{	$selected = ""; }
		$pbsedu_option .= gettemplate_app('option', array("value" => $row['id'], "content" => $row['entry'], "selected" => $selected));
	}
	
	$user['select_function'] = gettemplate_app('select', array('name' => "function", "content" => $function_option));
	$user['select_sex'] = gettemplate_app('select', array('name' => "sex", "content" => $sex_option));
	$user['select_jsedu']		= gettemplate_app('select', array('name' => "jsedu", "content" => $jsedu_option));
	$user['select_pbsedu']	= gettemplate_app('select', array('name' => "pbsedu", "content" => $pbsedu_option));

	$index_content['main'] .= gettemplate_app('edit_user', $user);
