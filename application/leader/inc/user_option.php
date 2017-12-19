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

	$id = mysql_real_escape_string($_REQUEST['id']);
	
	$query = "SELECT id, scoutname, firstname FROM user WHERE id = '$id'";
	$result = mysql_query($query);
	$user_option = mysql_fetch_assoc($result);
	
	if(empty($user_option['scoutname']))	{	$user_option['scoutname'] = $user_option['firstname'];	}

	$index_content['main'] .= gettemplate_app('user_option', $user_option);
	