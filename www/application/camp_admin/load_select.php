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

	$pid = mysql_real_escape_string( $_REQUEST['pid'] );
	
	
	$ans = array();
	
	if( $pid == 0 )
	{
		$query = "	SELECT *
					FROM groups
					WHERE ISNULL( pid ) AND active=1
					ORDER BY name";
	}
	else
	{
		$query = "	SELECT *
					FROM groups
					WHERE pid = $pid AND active=1
					ORDER BY name";
	}
	
	$result = mysql_query( $query );
	while( $g = mysql_fetch_assoc( $result ) )
	{
		$g['text']  = $g['prefix'] . " " . $g['name'];
		
		$ans['values'][] = $g;
	}
	
	$ans['num_values' ] = count( $ans['values'] );
	
	echo json_encode( $ans );
	die();
?>