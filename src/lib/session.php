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

	function session_setup( $user_id )
	{
		$query = "SELECT camp.id FROM camp, user WHERE user.last_camp = camp.id AND user.id = $user_id";
		$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		
		if( mysqli_num_rows( $result ) )
		{	$camp_id = mysqli_result( $result,  0,  'id' );	}
		else
		{	$camp_id = 0;	}

		session_unset();
		
		$_SESSION['user_id'] = $user_id;
		$_SESSION['camp_id'] = $camp_id;
	}

	function autologin_setup( $user_id )
	{
		if( !is_numeric( $user_id ) )
		{	return;	}

		$auth_key = md5( microtime() );
		$auth_key_db = md5( $auth_key );
		
		$query = "UPDATE user SET auth_key = '$auth_key_db' WHERE id = $user_id LIMIT 1";
		mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		
		setcookie( 'autologin', true, time() + 14*24*60*60, '/' );
		setcookie( 'user_id', $user_id, time() + 14*24*60*60, '/' );
		setcookie( 'auth_key', $auth_key, time() + 14*24*60*60, '/' );
	}
