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

	$event_id = mysql_real_escape_string( $_REQUEST['event_id'] );
	
	$_camp->event( $event_id ) || die( "error" );

	
	$query = "	SELECT
					count(*)
				FROM
					event_detail
				WHERE
					event_id = '$event_id'";
	
	$result = mysql_query( $query );
	$count = mysql_result( $result, 0 );
	
	$count++;
	
	$query = "	INSERT INTO
					event_detail
				(
					`event_id`,
					`sorting`
				)
				VALUES
				(
					'$event_id',
					'$count'
				)";
	
	
	$result = mysql_query( $query );
	$event_detail_id = mysql_insert_id();
	
	
	$ans = array( "error" => false, "event_detail_id" => $event_detail_id );
	echo json_encode( $ans );
	die();	
	
?>