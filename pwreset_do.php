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

	include("./config.php");
	include($lib_dir . "/mysql.php");
	include($lib_dir . "/functions/error.php");
	require_once("./lib/PHPTAL.php");
	db_connect();

	$user_id 	= ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'user_id' ] ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
	$login 		= ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'login' ] ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
	$acode		= ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'acode' ] ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
	
	$pw1 		= md5( $_REQUEST[ 'pw1' ] );
	$pw2		= md5( $_REQUEST[ 'pw2' ] );

	if( $pw1 != $pw2 )
	{	header( "location: pwreset.php?user_id=$user_id&login=$login&acode=$acode&msg=Passwort unstimmig." );	die();	}

	$query = "	UPDATE user SET  `pw` =  '$pw1', `acode` =  '' WHERE  
				id = $user_id AND mail = '$login' AND acode = '$acode'
				LIMIT 1 ;";
	mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	if( mysqli_affected_rows($GLOBALS["___mysqli_ston"]) )
	{	header( "location: login.php?msg=Passwort wurde erfolgreich geändert!" );	die();	}
	else
	{	header( "location: pwreset.php?user_id=$user_id&login=$login&acode=$acode&msg=Ein Fehler ist aufgetreten." );	die();	}
