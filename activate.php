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
	
	
	
	
		
	$user_id 	= mysql_real_escape_string( $_REQUEST[ 'user_id' ] );
	$login 		= mysql_real_escape_string( $_REQUEST[ 'login' ] );
	$acode		= mysql_real_escape_string( $_REQUEST[ 'acode' ] );
	
	
	$query = "SELECT user.active, user.acode FROM user WHERE user.id = $user_id AND mail = '$login'";
	$result = mysql_query( $query );
	
	if( !mysql_num_rows( $result ) )
	{
		header( "location: login.php?msg=Aktivierung ist fehlgeschlagen. Bitte Support kontaktieren." );
		die();
	}
	
	
	if( mysql_result( $result, 0, 'active' ) )
	{
		header( "location: login.php?msg=Account ist bereits aktiviert" );
		die();
	}
	
	
	
	
	if( $acode != mysql_result( $result, 0, 'acode' ) )
	{
		header( "location: login.php?msg=Aktivierung ist fehlgeschlagen. Bitte Support kontaktieren." );
		die();
	}
	
	
	
	
	$query = "	UPDATE  user 
				SET  `active` =  '1', `acode` =  '' 
				WHERE  `user`.`id` = $user_id LIMIT 1 ;";
	mysql_query( $query );
	
	
	
	header( "location: login.php?msg=Account wurde erfolgreich aktiviert" );

	die();
	
	
	
?>