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

	function get_username( $id )
	{
		$query = "SELECT user.scoutname, user.firstname, user.surname, user.mail FROM user WHERE id='$id' LIMIT 1";
		$result = mysql_query( $query );
		
		if( mysql_num_rows($result) == 0)
			return "<unbekannt>";

	 	$this_user = mysql_fetch_assoc($result);
		if( trim($this_user['scoutname']) != "" )
			return $this_user['scoutname'];
			
		return $this_user['firstname']." ".$this_user['surname'];
	}
	
	function htmlentities_utf8( $str )
	{
		return htmlentities( $str, ENT_QUOTES, "UTF-8" );
	}
