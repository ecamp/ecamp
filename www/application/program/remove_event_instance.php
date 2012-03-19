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

	include( 'inc/get_program_update.php');

	$event_instance_id	= mysql_real_escape_string($_REQUEST['event_instance_id']);
	$time				= mysql_real_escape_string($_REQUEST['time']);
	
	$_camp->event_instance( $event_instance_id ) || die( "error" );
	
	
	$log = array();
	
	
	$query = "SELECT event_id FROM event_instance WHERE id = '$event_instance_id'";
	$result = mysql_query($query);
	if(mysql_num_rows($result) == 0)
	{
		$ans = get_program_update( $time );
		echo json_encode( $ans );
		die();
	}
	$event_id = mysql_result( $result, 0, 'event_id' );
	
	
	
	$query = "DELETE FROM event_instance WHERE id = $event_instance_id";
	mysql_query($query);
	$log[] = array( "type" => "event_instance", "id" => $event_instance_id );
	
	
	
	$query = "SELECT COUNT(id) as count FROM event_instance WHERE event_id = $event_id";
	$result = mysql_query($query);
	$count = mysql_result( $result, 0, 'count' );
	
	if($count == 0)
	{
		$query = "DELETE FROM event WHERE id = $event_id";
		mysql_query($query);
		$log[] = array( "type" => "event", "id" => $event_id );
	}
	
	
	
	
	$query = "	SELECT user_id
				FROM user_camp
				WHERE camp_id = $_camp->id";
	$result = mysql_query( $query );
	while( $user = mysql_fetch_assoc( $result ) )
	{
		$filename = "application/program/del_protocol/" . $user['user_id'] . ".log";
		touch( $filename );
		
		$filecontent = file_get_contents( $filename );
		$file = json_decode( trim( $filecontent ), true );
		
		if( !$file ){	$file = array();	}
		$file = array_merge( $file, $log );
		
		$file = json_encode( $file );
		file_put_contents( $filename, $file );
	}
	
	
	
	
	header("Content-type: application/json");
	
	$ans = get_program_update( $time );
	echo json_encode( $ans );
	
	die();
?>
	