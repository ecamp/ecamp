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

	$valid_fields = array("scoutname","firstname","surname","street","zipcode","city","homenr","mobilnr","birthday","ahv","sex","jspersnr","jsedu","pbsedu");
	
	$field = mysql_real_escape_string($_REQUEST['field']);
	$value = $_REQUEST['value'];
	$value_save = mysql_real_escape_string($value);
	
	if( !in_array($field,$valid_fields) )
	{	die();	}	
	
	if($field == "birthday")
	{
		$birthday = new c_date;
		$birthday->setString($value_save);
		
		$value_save = $birthday->getValue();
	}
	
	$query = "UPDATE user SET $field = '$value_save' WHERE id = '$_user->id'";	
	mysql_query($query);
	
	if($field == "birthday")	{	$value_save = $birthday->getString("d.m.Y");	}
	
	// XML-Response senden
	header("Content-type: application/json");
	
	$ans_array= array("field" => $field, "value" => $value);
	echo json_encode($ans_array);
	die();
	