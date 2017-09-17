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

	$pw1 	= mysql_real_escape_string($_REQUEST[pw1]);
	$pw2 	= mysql_real_escape_string($_REQUEST[pw2]);
	$old_pw	= mysql_real_escape_string($_REQUEST[old_pw]);
	
	if( $pw1 != $_REQUEST[pw1] )
	{	$ans = "Das Passwort enhält unerlaubte Zeichen!";	}
	elseif($pw1 == $pw2)
	{
		if( eregi("^[a-zA-Z0-9]{6,25}",$pw1) )
		{
			$pw = md5($pw1);
			$old_pw = md5($old_pw);
			$query = "UPDATE user SET pw = '$pw' WHERE id = '$_user->id' AND pw = '$old_pw'";
			mysql_query($query);
			
			if( mysql_affected_rows() )
			{	$ans = "Passwort wurde erfolgreich geändert.";	}
			else
			{	$ans = "Passwort konnte nicht geändert werden. Das alte Passwort war ungültig.";	}
		}
		else
		{	$ans = "Passwort konnte nicht geändert werden. Das Passwort darf nur aus Buchstaben (a-z, A-Z) und Zahlen (0-9) bestehen. Ausserdem muss es zwischen 6 und 25 Zeichen lang sein.";	}
	}
	else
	{	$ans = "Passwort konnte nicht geändert werden. Du musst beide Mal das selbe Passwort eingeben...";	}
	
	
	// XML-Response senden
	header("Content-type: application/json");
	
	echo json_encode(array("ans" => $ans));
	
	die();
	
?>