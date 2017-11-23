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

	$cat_id     = mysql_real_escape_string($_REQUEST['cat_id']);
	
	$color		= mysql_real_escape_string($_REQUEST['color']);
	$form_type	= mysql_real_escape_string($_REQUEST['type']);
	
	$name		= trim($_REQUEST['name']);
	$short_name	= trim($_REQUEST['short']);
	
	$name_save  = mysql_real_escape_string($name);
	$short_name_save  = mysql_real_escape_string($short_name);

	$_camp->category( $cat_id ) || die( "error" );

	if( $name=="" )
	{
		//$uri = "&msg_title=".urlencode("Kategorie ändern: Fehler")."&msg_text=".urlencode("Bitte gib einen Kategorie-Namen ein!");
		//header( "Location: index.php?app=option".$uri );
		
		$ans = array( "error" => true, "msg" => "Bitte gib einen Kategorie-Namen ein!" );
		echo json_encode( $ans );
		die();
	}
	
	if( $color == "" )
		$color = "FFFFFF";
	elseif( substr($color, 0, 1) == "#" )
		$color = substr($color,1,strlen($color)-1);
		
	if( ! ctype_xdigit($color) )
			$color = "ffffff";
		
	$form_type = intval($form_type);
	
	// Überprüfen, ob Kategorie gefunden
	$query = "SELECT * FROM category WHERE camp_id='$_camp->id' AND id='$cat_id'";
	$result = mysql_query($query);
	if( mysql_num_rows($result) == 0 )
	{
		//$uri = "&msg_title=".urlencode("Kategorie ändern: Fehler")."&msg_text=".urlencode("Kategorie nicht gefunden!");
		//header( "Location: index.php?app=option".$uri );
		
		$ans = array( "error" => true, "msg" => "Kategorie nicht gefunden" );
		echo json_encode( $ans );
		die();
	}
	
	// Überprüfen, ob selbe Kategorie nicht schon vorhanden
	$query = "SELECT * FROM category WHERE camp_id='$_camp->id' AND name='$name_save' AND NOT id='$cat_id'";
	$result = mysql_query($query);
	if( mysql_num_rows($result) > 0 )
	{
		//$uri = "&msg_title=".urlencode("Kategorie ändern: Fehler")."&msg_text=".urlencode("Eine Kategorie mit einem solchen Namen existiert bereits!");
		//header( "Location: index.php?app=option".$uri );
		
		$ans = array( "error" => true, "msg" => "Eine Kategorie mit einem solchen Namen existiert bereits!" );
		echo json_encode( $ans );
		die();
	}
	
	// Kategorie hinzufügen
	$query = "UPDATE `category` SET `name` = '$name_save', `short_name` = '$short_name_save', `color` = '$color', `form_type` = '$form_type' WHERE `id` ='$cat_id' LIMIT 1 ;";
	mysql_query($query);
	$last_camp_id = mysql_insert_id();
	
    //header("Location: index.php?app=option");
	
	$ans = array( "error" => false );
	echo json_encode( $ans );
	die();
