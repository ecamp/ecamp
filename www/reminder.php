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

	require 'vendor/autoload.php';
	use Phelium\Component\reCAPTCHA;

	include("./config/config.php");
	include($lib_dir . "/mysql.php");
	include($lib_dir . "/functions/error.php");
	require_once("./lib/PHPTAL.php");
	db_connect();

	$captcha = new reCAPTCHA($GLOBALS['captcha_pub'], $GLOBALS['captcha_prv']);

	if( $_SESSION['skin'] == "" ) $_SESSION['skin'] = $GLOBALS['skin'];
	$html = new PHPTAL("public/skin/".$_SESSION['skin']."/reminder.tpl");
	
	$html->setEncoding('UTF-8');
	
	$html->set('SHOW_MSG', false);
	
	if( isset( $_REQUEST[ 'msg' ] ) )
	{
		$html->set( 'SHOW_MSG', true );
		$html->set( 'MSG', mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'msg' ] ) );
	}

	$html->set('captcha_script', $captcha->getScript());
	$html->set('captcha_html', $captcha->getHtml());

	echo $html->execute();
