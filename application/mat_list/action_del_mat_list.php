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

	$mat_list_id = mysql_real_escape_string( $_REQUEST['mat_list_id'] );
	
	$_camp->mat_list( $mat_list_id ) || die( "error" );

	$query = "DELETE FROM mat_list WHERE id = $mat_list_id";
	mysql_query( $query );
	
	if( mysql_error() )
	{	$ans = array( "error" => true, "error_msg" => "Diese Einkaufsliste kann nicht gelöscht werden");	}
	else
	{	$ans = array( "error" => false );	}
	
	echo json_encode( $ans );
	die();
?>