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
	include($lib_dir . "/functions/error.php");
	require_once("./lib/PHPTAL.php");
	
	require_once( "./lib/recaptchalib.php" );

	if( $_SESSION['skin'] == "" ) $_SESSION['skin'] = $GLOBALS['skin'];
	$html = new PHPTAL("public/skin/".$_SESSION['skin']."/register.tpl");
	
	$html->setEncoding('UTF-8');
	
	$html->set('SHOW_MSG', false);
	
	if( isset( $_REQUEST[ 'msg' ] ) )
	{
		$html->set( 'SHOW_MSG', true );
		$html->set( 'MSG', ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'msg' ] ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : "")) );
	}
	
	$html->set( 'captcha' ,recaptcha_get_html( $GLOBALS['captcha_pub'], null, true ) );
	
	echo $html->execute();
