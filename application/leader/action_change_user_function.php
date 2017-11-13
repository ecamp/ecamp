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

	$user_camp_id = $_REQUEST['user_camp_id'];
	$function_id = $_REQUEST['function_id'];
	
	if( $_user_camp->auth_level < 50 )	{	die( "ERROR" );	}
	
	$query = "	UPDATE user_camp
				SET function_id = $function_id
				WHERE user_camp.id = $user_camp_id
				AND user_camp.camp_id = " . $_camp->id;
	
	mysql_query( $query );
	
	if( mysql_error() )
	{	die( "Error" );	}
	else
	{
		header( "Location: index.php?app=leader" );
		die();
	}
	
	die();
?>