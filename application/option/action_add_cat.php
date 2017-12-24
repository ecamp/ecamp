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

	$name		= trim($_REQUEST['name']);
	$short_name	= trim($_REQUEST['short']);
	
	$name_save  		= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $name);
	$short_name_save  	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $short_name);
	
	$color		= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['color']);
	$form_type	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['type']);
	
	
	if( $name=="" )
	{
		$ans = array( "error" => true, "msg" => "Bitte gib einen Kategorie-Namen ein!" );
		echo json_encode( $ans );
		die();
	}
	
	if( $color == "" )
		$color = "FFFFFF";
	else
		$color = substr($color,1,strlen($color)-1);
	
	if( ! ctype_xdigit($color) )
		$color = "ffffff";
			
	$form_type = intval($form_type);
	
	// Überprüfen, ob selber Kategorienamen nicht schon existiert
	$query = "SELECT * FROM category WHERE camp_id='$_camp->id' AND name='$name_save'";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	if( mysqli_num_rows($result) > 0 )
	{
		$ans = array( "error" => true, "msg" => "Die Kategorie konnte nicht hinzugef&uuml;gt werden. Eine Kategorie mit einem solchen Namen existiert bereits!" );
		echo json_encode( $ans );
		die();
	}
	
	// Kategorie hinzufügen
	$query = "INSERT INTO category	(camp_id, name, short_name, color, form_type)
							VALUES	('$_camp->id', '$name_save', '$short_name_save', '$color', '$form_type')";
	mysqli_query($GLOBALS["___mysqli_ston"], $query);
	$last_camp_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
	
    //header("Location: index.php?app=option");
	
	$ans = array( "error" => false );
	echo json_encode( $ans );
	die();
?>