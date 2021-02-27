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

	//Load composer's autoloader
	require '../../vendor/autoload.php';

	include("../config/config.php");

	#############################################################################
    # Register Error Handler
	include_once($module_dir . "/error_handling.php");
	
	include($lib_dir . "/mysql.php");
	include($lib_dir . "/functions/error.php");
	
	db_connect();

	$user_id 	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'user_id' ] );
	$login 		= mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'login' ] );
	$acode		= mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'acode' ] );

	$query = "	SELECT user.id FROM user WHERE id = $user_id AND mail = '$login' AND acode = '$acode'";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	if( mysqli_error($GLOBALS["___mysqli_ston"]) || !mysqli_num_rows( $result ) )
	{	die("FEHLER; Support anfragen" ); }

	if( $_SESSION['skin'] == "" ) $_SESSION['skin'] = $GLOBALS['skin'];
	$html = new PHPTAL("public/skin/".$_SESSION['skin']."/pwreset.tpl");
	
	$html->setEncoding('UTF-8');
	
	$html->set('SHOW_MSG', false);
	
	if( isset( $_REQUEST[ 'msg' ] ) )
	{
		$html->set( 'SHOW_MSG', true );
		$html->set( 'MSG', mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'msg' ] ) );
	}

	$html->set( 'user_id', $user_id );
	$html->set( 'login', $login );
	$html->set( 'acode', $acode );

	echo $html->execute();
