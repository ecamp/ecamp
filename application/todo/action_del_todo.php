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

	$todo_id 	= mysql_real_escape_string($_REQUEST['todo_id']);
	
	$_camp->todo( $todo_id ) || die( "error" );
	
	
	$query = "SELECT * FROM todo WHERE id = $todo_id AND camp_id = $_camp->id";
	$result = mysql_query($query);
	
	if( mysql_num_rows($result) == 0 )
	{
		$ans = array( "error" => true, "msg" => "Aufgabe und Lager passen nicht zusammen!" );
		echo json_encode( $ans );
		die();
	}
	
	
	$query = "DELETE FROM todo WHERE id = $todo_id AND camp_id = $_camp->id";
	$result = mysql_query($query);
	
	$ans = array( "error" => false );
	echo json_encode( $ans );
	die();
	
?>