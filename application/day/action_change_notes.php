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

	$day_id = mysql_real_escape_string( $_REQUEST['day_id'] );
	$notes = mysql_escape_string( $_REQUEST['notes'] );
	$notes_js = $_REQUEST['notes'] ;
	
	$_camp->day( $day_id ) || die( "error" );
	
	$query = "	UPDATE day
				SET `notes` = '$notes'
				WHERE
				id = $day_id";
	mysql_query( $query );
	
	if( mysql_error() )
	{	$ans = array( "error" => true, "error_msg" => "" );	}
	else
	{	$ans = array( "error" => false, "value" => $notes_js );	}
	
	echo json_encode( $ans );
	
	die();
	
?>