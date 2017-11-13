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
	
	$name_save  		= mysql_real_escape_string($name);
	$short_name_save  	= mysql_real_escape_string($short_name);
	
	$color		= mysql_real_escape_string($_REQUEST['color']);
	$form_type	= mysql_real_escape_string($_REQUEST['type']);

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
	
	$form_type = intval($form_type);
	
	// Überprüfen, ob selber Kategorienamen nicht schon existiert
	$query = "SELECT * FROM category WHERE camp_id='$_camp->id' AND name='$name_save'";
	$result = mysql_query($query);
	if( mysql_num_rows($result) > 0 )
	{
		$ans = array( "error" => true, "msg" => "Die Kategorie konnte nicht hinzugef&uuml;gt werden. Eine Kategorie mit einem solchen Namen existiert bereits!" );
		echo json_encode( $ans );
		die();
	}
	
	// Kategorie hinzufügen
	$query = "INSERT INTO category	(camp_id, name, short_name, color, form_type)
							VALUES	('$_camp->id', '$name_save', '$short_name_save', '$color', '$form_type')";
	mysql_query($query);
	$last_camp_id = mysql_insert_id();
	
    //header("Location: index.php?app=option");
	
	$ans = array( "error" => false );
	echo json_encode( $ans );
	die();
?>