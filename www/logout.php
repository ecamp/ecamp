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
  # Filename:     logout.php
  # Beschreibung: Üernimmt den Logout-Vorgang
  #
  # ToDo:  - 
  #
  	include("./config/config.php");
	include("lib/mysql.php");
	include("./class.php");
	db_connect();
	
	$_user 		= new user;
	$_camp 		= new camp;
	$_user_camp = new user_camp;
	
	include("module/auth/check_login.php");
	
	# Session-Variablen löchen
	$_SESSION = array();
	session_unset();
  
	# Cookie löchen  
	setcookie(session_name(), '', time()-42000, '/');
	setcookie('autologin', false, time()-42000, '/' );
	setcookie('user_id', '', time()-42000, '/' );
	setcookie('auth_key', '', time()-42000, '/' );
	
	# Session-Daten löchen
	session_destroy();
	
	# zum Login weiterleiten
	if(isset($_REQUEST['msg']))
	{	header("Location: login.php?msg=".$_REQUEST['msg']);	} else
	{	header("Location: login.php");	}
?>

