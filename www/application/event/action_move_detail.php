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

	$direction = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['direction'] );
	$base_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['detail_id'] );
	
	$_camp->event_detail( $base_id ) || die( "error" );

	$query = "SELECT event_id, sorting FROM event_detail WHERE id = $base_id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	$event_id = mysqli_result( $result,  0,  'event_id' );
	$base_sorting = mysqli_result( $result,  0,  'sorting' );

	if( $direction == "up" )
	{
		$query = "SELECT id FROM event_detail WHERE event_id = $event_id AND sorting = " . ( $base_sorting - 1 );
		$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		
		if( ! mysqli_num_rows( $result ) )
		{
			$ans = array( "error" => true, "error_msg" => "Ein Fehler ist aufgetreten" );
			echo json_encode( $ans );
			die();
		}
		
		$swap_id = mysqli_result( $result,  0,  'id' );
		$swap_sorting = $base_sorting - 1;

		$query = "UPDATE event_detail SET sorting = $base_sorting WHERE id = $swap_id";
		mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		
		$query = "UPDATE event_detail SET sorting = $swap_sorting WHERE id = $base_id";
		mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	}
	
	if( $direction == "down" )
	{
		$query = "SELECT id FROM event_detail WHERE event_id = $event_id AND sorting = " . ( $base_sorting + 1 );
		$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		
		if( ! mysqli_num_rows( $result ) )
		{
			$ans = array( "error" => true, "error_msg" => "Ein Fehler ist aufgetreten" );
			echo json_encode( $ans );
			die();
		}

		$swap_id = mysqli_result( $result,  0,  'id' );
		$swap_sorting = $base_sorting + 1;

		$query = "UPDATE event_detail SET sorting = $base_sorting WHERE id = $swap_id";
		mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		
		$query = "UPDATE event_detail SET sorting = $swap_sorting WHERE id = $base_id";
		mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	}
	
	$ans = array( "error" => false );
	echo json_encode( $ans );
	die();
