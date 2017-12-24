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
	$surname	= $_REQUEST['surname'];
	$mail		= $_REQUEST['mail'];

	# Funktionsoption:
	#
	###########################
	if( $_camp->is_course )
		$query = "SELECT * FROM dropdown WHERE list = 'function_course' ORDER BY id ASC";
	else
		$query = "SELECT * FROM dropdown WHERE list = 'function_camp' ORDER BY id ASC";
		
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	$function_option = "";
	while($row = mysqli_fetch_assoc($result))
	{	if($row[id] == $std)
		{	$selected = " selected=selected";	}
		else
		{	$selected = "";	}
		
		$function_option .= gettemplate_app('option', array("value" => $row['id'], "content" => $row['entry'], "selected" => $selected));
	}

	# Geschlechtsoption:
	#
	###########################
	$query = "SELECT * FROM dropdown WHERE list = 'sex' ORDER BY id ASC";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	$sex_option = "";
	while($row = mysqli_fetch_assoc($result))
	{	$sex_option .= gettemplate_app('option', array("value" => $row['id'], "content" => $row['entry'], "selected" => ""));	}
	
	# JS Ausbildung:
	#
	###########################
	$query = "SELECT * FROM dropdown WHERE list = 'jsedu' ORDER BY id ASC";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	$jsedu_option = "";
	while($row = mysqli_fetch_assoc($result))
	{	$jsedu_option .= gettemplate_app('option', array("value" => $row['id'], "content" => $row['entry'], "selected" => ""));	}
	
	# PBS Ausbildung:
	#
	###########################
	$query = "SELECT * FROM dropdown WHERE list = 'pbsedu' ORDER BY id ASC";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	$pbsedu_option = "";
	while($row = mysqli_fetch_assoc($result))
	{	$pbsedu_option .= gettemplate_app('option', array("value" => $row['id'], "content" => $row['entry'], "selected" => ""));	}

	$replace = array(
		"std" => $std,
		"select_function" 	=> gettemplate_app('select', array('name' => "function", "content" => $function_option)),
		"select_sex" 		=> gettemplate_app('select', array('name' => "sex", 	 "content" => $sex_option)),
		"select_jsedu" 		=> gettemplate_app('select', array('name' => "jsedu", 	 "content" => $jsedu_option)),
		"select_pbsedu"		=> gettemplate_app('select', array('name' => "pbsedu", 	 "content" => $pbsedu_option)),
		"scoutname" => $scoutname,
		"firstname" => $firstname,
		"surname"	=> $surname,
		"mail"		=> $mail
		);

	$index_content['main'] .= gettemplate_app('add_unknown_user', $replace);
