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

	$event_document_id 	= mysql_real_escape_string( $_REQUEST['event_document_id'] );
	$print				= mysql_real_escape_string( $_REQUEST['print'] );
	
	if( $print == "on" )	{	$print = 1;	}
	else					{	$print = 0;	}
	
	$query = "	UPDATE event_document
				SET `print` = '$print'
				WHERE id = $event_document_id";
	mysql_query( $query );

	if( mysql_affected_rows() )
	{
		$ans = array( "error" => 0, "error_msg" => "", "print" => $print );
		echo json_encode( $ans );
	}
	else
	{
		$ans = array( "error" => 1, "error_msg" => "FEHLER" );
		echo json_encode( $ans );
	}
	die();
