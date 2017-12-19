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

	// Authentifizierung überprüfen
	// write --> Ab Lagerleiter (level: 50)
	if( $_user_camp->auth_level < 50 )
	{	
		$ans = array("error" => true, "msg" => "Keine berechtigung, diese Datan zu ändern");
		echo json_encode($ans);
		die();
	}

	// Feld auslesen
	$valid_fields = array("name","group_name","slogan","short_name","ca_name","ca_street","ca_zipcode","ca_city","ca_tel","ca_coor");
    $field = mysql_real_escape_string($_REQUEST['field']);	
	$value = $_REQUEST['value'];
	$value_save = mysql_real_escape_string($_REQUEST['value']);

	if( !in_array($field, $valid_fields) )
	{
		$ans = array("error" => true, "error_msg" => "Das Feld existiert nicht!");
		echo json_encode($ans);
		die();
	}
	
	// Spezialberechnungen durchführen
	if( $field == "ca_coor" ) // Koordinaten zusammenführen
	{
		$value1 = mysql_real_escape_string($_REQUEST['value1']);
    	$value2 = mysql_real_escape_string($_REQUEST['value2']);
		$value3 = mysql_real_escape_string($_REQUEST['value3']);
		$value4 = mysql_real_escape_string($_REQUEST['value4']);
		
		if( $value1=="" && $value2=="" && $value3=="" && $value4 == "")
		{	$value = "";	}
		else
		{	
			$value1 = intval($value1);
			$value2 = intval($value2);
			$value3 = intval($value3);
			$value4 = intval($value4);
			
			if( $value1 > 999 || $value1 < 0 ){$value1 = "000";}
			if( $value2 > 999 || $value2 < 0 ){$value2 = "000";}
			if( $value3 > 999 || $value3 < 0 ){$value3 = "000";}
			if( $value4 > 999 || $value4 < 0 ){$value4 = "000";}
			
			$value1 = substr( "000" . $value1, -3 );
			$value2 = substr( "000" . $value2, -3 );
			$value3 = substr( "000" . $value3, -3 );
			$value4 = substr( "000" . $value4, -3 );

			$value = $value1.".".$value2."/".$value3.".".$value4;
			$value_save = $value;
		}
	}
	else if( $field == "ca_zipcode" )
	{
		if( $value != "" )
		{
			$value = intval($value);
			if( $value > 9999 || $value < 0 ){ $value = ""; }
		}
		else
		{	$value = "";	}
		$value_save = $value;
	}

	$query = "UPDATE camp SET $field = '$value_save' WHERE id = '$_camp->id'";
	mysql_query($query);

	$ans = array();
	$ans['error'] = false;
	$ans['value'] = $value;
	
	if( $field == "ca_coor" )
	{
		$ans['value1'] = $value1;
		$ans['value2'] = $value2;
		$ans['value3'] = $value3;
		$ans['value4'] = $value4;
	}
	
	echo json_encode($ans);
	die();
