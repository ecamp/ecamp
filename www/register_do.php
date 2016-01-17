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
	db_connect();
	
	require_once( "./lib/recaptchalib.php" );
	
	
	
	
	//	CHECK ALL INPUTS:
	// ===================
	
	
	$resp = recaptcha_check_answer ($GLOBALS[captcha_prv], $_SERVER["REMOTE_ADDR"], 
									$_REQUEST["recaptcha_challenge_field"],
									$_REQUEST["recaptcha_response_field"]	);
	
	
	if (!$resp->is_valid)
	{	header( 'location: register.php?msg=Bitte CAPTCHA richtig abschreiben!' );	die();	}
	
	if( $_REQUEST[ 'Login' ] == "" )
	{	header( 'location: register.php?msg=eMail - Adresse muss angegeben werden!' );	die();	}
	
	if( !filter_var( $_REQUEST[ 'Login' ], FILTER_VALIDATE_EMAIL) )
	{	header( 'location: register.php?msg=Eine gültige eMail - Adresse muss angegeben werden!' );	die();	}
	
	if( $_REQUEST[ 'Passwort1' ] == "" )
	{	header( 'location: register.php?msg=Passwort muss angegeben werden!' );	die();	}
	
	if( $_REQUEST[ 'Passwort2' ] == "" )
	{	header( 'location: register.php?msg=Wiederholung muss angegeben werden!' );	die();	}
	
	if( $_REQUEST[ 'firstname' ] == "" )
	{	header( 'location: register.php?msg=Vorname muss angegeben werden!' );	die();	}
	
	if( $_REQUEST[ 'surname' ] == "" )
	{	header( 'location: register.php?msg=Nachname muss angegeben werden!' );	die();	}
	
	
	
	
	$login 	= mysql_real_escape_string( $_REQUEST[ 'Login' ] );
	$pw1	= md5( $_REQUEST[ 'Passwort1' ] );
	$pw2	= md5( $_REQUEST[ 'Passwort2' ] );
	
	$scoutname 	= mysql_real_escape_string( $_REQUEST[ 'scoutname' ] );
	$firstname 	= mysql_real_escape_string( $_REQUEST[ 'firstname' ] );
	$surname 	= mysql_real_escape_string( $_REQUEST[ 'surname' ] );
	
	
	if( $pw1 != $pw2 )
	{	header( 'location: register.php?msg=Passwort unstimmig' );	die();	}
	
	
	$query = "SELECT user.id FROM user WHERE user.mail = '" . $login . "'";
	$result = mysql_query( $query );
	
	if( mysql_num_rows( $result ) )
	{	header( 'location: register.php?msg=eMail-Adresse ist bereits registriert' );	die();	}
	
	
	
	
	
	
	
	
	
	//	INSERT NEW USER:
	// ==================
	
	
	$acode = md5( time() . $pw1 );
	
	
	$query = "	INSERT INTO user ( `mail`, `pw`, `scoutname`, `firstname`, `surname`, `acode` )
				VALUES ( '$login', '$pw1', '$scoutname', '$firstname', '$surname', '$acode' );";
	mysql_query( $query );
	
	
	$user_id = mysql_insert_id();
	
	
	
	
	
	
	
	//	SEND MAIL FOR ACTIVATION:
	// ===========================
	
	
 	$text = "eCamp - Willkommen \n\n
Um dich bie eCamp einloggen zu können, musst du deinen Account aktivieren.
Zu diesem Zweck musst du nachfolgendem Link folgen:
\n\n
" . $GLOBALS[base_uri] . "activate.php?user_id=$user_id&login=$login&acode=$acode
\n\n
 ";

	ecamp_send_mail($login, "eCamp - Willkommen", $text);
 	// mail( $login, "eCamp - Willkommen", $text, "From: eCamp Pfadi Luzern <ecamp@pfadiluzern.ch>" );
	
	/*
	$text = urlencode( $text );
 	$subject = urlencode( "eCamp - Willkommen" );
	fopen( "http://ecamp2.pfadiluzern.ch/mail.php?to=$login&subject=$subject&message=$text", "r" );
	*/
	
	header( 'location: login.php?msg=Vor dem ersten Login muss der Account aktiviert werden. Dafür bitte Mailbox überprüfen.' );
	die();
	
	
?>