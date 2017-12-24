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
	include($lib_dir . "/functions/mail.php");
	db_connect();

	$login = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'Login' ] ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

	$query = "	SELECT id, active, acode FROM user WHERE mail = '$login'";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	if( ! mysqli_num_rows( $result ) )
	{
		header( "location: login.php?msg=Angegebene Mailadresse ist nicht registriert!" );
		die();
	}
	
	$active = mysqli_result( $result,  0,  'active' );
	if( $active )
	{
		header( "location: login.php?msg=Account ist bereits aktiviert!<br /> Du kannst dich einloggen!" );
		die();
	}
	
	$user_id = mysqli_result( $result,  0,  'id' );
	$acode 	= mysqli_result( $result,  0,  'acode' );
	if( $acode == "" )
	{
		$acode = md5( microtime() );
		$query = "UPDATE user SET acode = '$acode' WHERE id = ". $user_id;
		mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	}
	
	//	SEND MAIL FOR ACTIVATION:
	// ===========================
 	$text = "eCamp - Willkommen \n\n
Um dich bie eCamp einloggen zu können, musst du deinen Account aktivieren.
Zu diesem Zweck musst du nachfolgendem Link folgen:
\n\n
" . $GLOBALS['base_uri'] . "activate.php?user_id=$user_id&login=$login&acode=$acode
\n\n
 ";
 	
 	//ecamp_send_mail($login, "eCamp - Willkommen", $text);
	mail( $login, "eCamp - Willkommen", $text, "From: eCamp Pfadi Luzern <ecamp@pfadiluzern.ch>" );
	
	/*
	$text = urlencode( $text );
 	$subject = urlencode( "eCamp - Passwort ändern" );
	fopen( "http://ecamp2.pfadiluzern.ch/mail.php?to=$login&subject=$subject&message=$text", "r" );
	*/
	
	header( 'location: login.php?msg=Überprüfe nun bitte deine Mailbox.' );
	die();
