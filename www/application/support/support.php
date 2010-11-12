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

	$support = $_REQUEST['support'];
	$camp_id = $_REQUEST['camp_id'];
	
	
	$query = "SELECT is_course FROM camp WHERE id = $camp_id";
	$result = mysql_query( $query );
	$is_course = mysql_result( $result, 0, 'is_course' );
	
	
	if( $is_course )
	{	$query = "SELECT id FROM dropdown WHERE list = 'function_course' AND entry = 'Support'";	}
	else
	{	$query = "SELECT id FROM dropdown WHERE list = 'function_camp'  AND entry = 'Support'";	}
	$result = mysql_query( $query );
	$support_id = mysql_result( $result, 0, 'id' );
	
		
	if($support)
	{
		$query = "SELECT * FROM user_camp WHERE user_id = $_user->id AND camp_id = $camp_id AND function_id = $support_id";
		$result = mysql_query( $query );
		
		if( !mysql_num_rows( $result ) )
		{
			$query = "INSERT INTO user_camp ( user_id, camp_id, function_id, invitation_id, active )
									VALUES 	( $_user->id, $camp_id, $support_id, $_user->id, 1 )";
			$result = mysql_query( $query );
		}
	}
	else
	{
		$query = "SELECT * FROM user_camp WHERE user_id = $_user->id AND camp_id = $camp_id AND function_id = $support_id";
		$result = mysql_query( $query );
		
		if( mysql_num_rows( $result ) )
		{
			$query = "DELETE FROM user_camp WHERE user_id = $_user->id AND camp_id = $camp_id AND function_id = $support_id";
			$result = mysql_query( $query );
		}
		
		if( $camp_id == $_SESSION['camp_id'] )	{	$_SESSION['camp_id'] = 0;	}
	}
	
	header("Location: index.php?app=support&cmd=home");
	die();
?>