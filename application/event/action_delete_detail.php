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

	$event_detail_id = mysql_real_escape_string( $_REQUEST['detail_id'] );
	
	$_camp->event_detail( $event_detail_id ) || die( "error" );
	
	
	$query = "SELECT event_id, event_detail.sorting FROM event_detail WHERE event_detail.id = $event_detail_id";
	$result = mysql_query( $query );
	$sorting = mysql_result( $result, 0, 'sorting' );
	$event_id = mysql_result( $result, 0, 'event_id' );
	
	$query = "
				DELETE FROM
					event_detail
				WHERE
					event_detail.id = $event_detail_id";
	mysql_query( $query );
	
	
	if( mysql_affected_rows() )
	{
		$query = "UPDATE event_detail SET sorting = sorting - 1 WHERE event_id = $event_id AND sorting > $sorting";
		mysql_query( $query );
		$ans = array( "error" 	=> false 	);
	}
	else
	{	$ans = array( "error" => true, "error_msg" => "Detail konnte nicht gelöscht werden" );	}
	
	
	echo json_encode( $ans );
	die();
?>