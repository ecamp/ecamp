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

  #############################################################################
  #
  # Filename:     login.php
  # Beschreibung: Übernimmt den Login-Vorgang
  #
  # ToDo:  - Herausfinden der Berechtigungen nach dem Login   --> user[auth_level]
  #					=> NICHT BEI ANMELDUNG, SONDERN BEI LAGERWAHL!!!
  #        - Überprüfen, wie oft ein Login versucht wurde --> Kennwortrücksetzung anbieten
  #        - Validieren der User-Eingaben
  
	include("./config/config.php");
	include($lib_dir."/session.php");
	include($lib_dir."/functions/error.php");
	require_once("./lib/PHPTAL.php");
	
	if ($_SESSION['skin'] == "") $_SESSION['skin'] = $GLOBALS['skin'];
	$html = new PHPTAL("public/skin/".$_SESSION['skin']."/login.tpl");
	
	$html->setEncoding('UTF-8');
	$html->set('SHOW_MSG', false);
	
	session_start();

	if(isset( $_REQUEST['msg'] ) )
	{
		$html->set('SHOW_MSG', true);
		$html->set('MSG', $_REQUEST['msg']);
	}
	
	if($_POST['Form'] == "Login")
	{
		include($lib_dir . "/mysql.php");
		db_connect();
		
		// Verhindern von injection!!!
		$_POST['Login'] = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['Login']);
		
		$query = "SELECT pw, id, scoutname, firstname, active, last_camp FROM user WHERE mail = '" . $_POST['Login'] . "' LIMIT 1";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
		
		if(mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_assoc($result);
			if($row['active'] == 1)
			{
				if(md5($_POST['Passwort']) == $row['pw'])
				{				
					$user_id = $row['id'];

					if( $_REQUEST['autologin'] )
					{	autologin_setup( $user_id );	}
					
					session_setup( $user_id );
					
					header("Location: index.php");                    
					die();
				} else
				{
					$html->set('SHOW_MSG', true);
					$html->set('MSG', "Login ist fehlgeschlagen.");
				}
			} else
			{
				$html->set('SHOW_MSG', true);
				$html->set('MSG', "	Du musst deinen Account zuerst aktivieren. 
									<br /><br /><a href='resendacode.php'>Wie aktiviere ich meinen Account?</a>");
			}
		} else
		{
			$html->set('SHOW_MSG', true);
			$html->set('MSG', "Login ist fehlgeschlagen.");
		}
	}

	if( isset( $_COOKIE['autologin'] ) && $_COOKIE['autologin'] && isset( $_COOKIE['auth_key'] ) && is_numeric( $_COOKIE['user_id'] ) )
	{
		include($lib_dir . "/mysql.php");
		db_connect();
		
		$user_id 	= $_COOKIE['user_id'];
		$auth_key 	= md5( $_COOKIE['auth_key'] );
		
		$query = "SELECT id FROM user WHERE id = $user_id AND auth_key = '" . $auth_key . "'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		
		if( mysqli_num_rows( $result ) )
		{
			session_setup( $user_id );
			
			header( "Location: index.php" );
			die();
		} else
		{
			setcookie( 'autologin', false );
			setcookie( 'user_id', '' );
			setcookie( 'auth_key', '' );
		}
	}

	echo $html->execute();
