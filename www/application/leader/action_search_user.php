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

	$scoutname	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['scoutname']);
	$firstname	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['firstname']);
	$surname	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['surname']);
	$mail		= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['mail']);
	
	// Argumente aufbauen
	$search_arg = array("0");
	if(!empty($scoutname))	{	$search_arg[] = " scoutname LIKE '$scoutname%' "; 	}
	if(!empty($firstname))	{	$search_arg[] = " firstname LIKE '$firstname%' ";	}
	if(!empty($surname))	{	$search_arg[] = " surname LIKE '$surname%' ";	}
	if(!empty($mail))		{	$search_arg[] = " mail LIKE '$mail%' ";	}
	
	$select_arg = array("0");
	if(!empty($scoutname))	{	$select_arg[] = " (scoutname LIKE '$scoutname%')*1 + (scoutname LIKE '$scoutname')*15 "; 	}
	if(!empty($firstname))	{	$select_arg[] = " (firstname LIKE '$firstname%')*1 + (firstname LIKE '$firstname')*15 ";	}
	if(!empty($surname))	{	$select_arg[] = " (surname LIKE '$surname%')*2 + (surname LIKE '$surname')*30 ";	}
	if(!empty($mail))		{	$select_arg[] = " (mail LIKE '$mail%')*5 + (mail LIKE '$mail')*100 ";	}
	
	$select_arg = implode(" + ", $select_arg);
	
    $query = "SELECT *, ($select_arg) AS `rank`  FROM user WHERE (" . implode(" OR ", $search_arg).") AND active='1' ORDER BY `rank` DESC LIMIT 10";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	$found_users = array();
	while( $found = mysqli_fetch_assoc($result) )
	{	
		$found_user['scoutname'] = htmlentities_utf8($found['scoutname']);
 		$found_user['firstname'] = htmlentities_utf8($found['firstname']);
		$found_user['surname'] = htmlentities_utf8($found['surname']);
		$found_user['mail'] = htmlentities_utf8($found['mail']);
		$found_user['city'] = htmlentities_utf8($found['city']);
		$found_user['id'] = htmlentities_utf8($found['id']);
		
		$found_users[] = $found_user;
	}
	
	echo json_encode( $found_users );
	die();
	