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
	
	$event_id	= mysql_real_escape_string($_REQUEST['event_id']);
	$resp_user	= $_REQUEST['resp_user'];
	$user_pool	= $_REQUEST['user_pool'];
	$time		= $_REQUEST['time'];
	
	if( !is_array( $resp_user ) ){	$resp_user = array();	}
	if( !is_array( $user_pool ) ){	$user_pool = array();	}
	
	$_camp->event( $event_id ) || die( "error" );

	foreach($resp_user as $user)
	{
		$user = mysql_real_escape_string( $user );
		
		$query = "SELECT id FROM event_responsible WHERE user_id = $user AND event_id = $event_id";
		$result = mysql_query($query);
		if(mysql_num_rows($result) == 0)
		{	
			$query = "INSERT INTO event_responsible (user_id, event_id) VALUES ($user, $event_id)";
			mysql_query($query);
			
			$query = "SELECT * FROM event WHERE id = $event_id";
			$result = mysql_query( $query );
			$event = mysql_fetch_assoc( $result );
			
			$query = "SELECT active FROM user_camp WHERE camp_id = $_camp->id AND user_id = $user";
			$result = mysql_query( $query );
			$active = mysql_result( $result, 0, 'active' );
			
			if( $user != $_user->id && $active )
			{
				$_news->add2user( 
					"Verantwortung für " . $event['name'],
					"Dir wurde die Verantwortung für den Block '" . $event['name'] . "' zugeteilt.",
					time(), $user );
			}
		}
	}
	
	foreach($user_pool as $user)
	{
		$user = mysql_real_escape_string( $user );
		
		$query = "DELETE FROM event_responsible WHERE user_id = $user AND event_id = $event_id";
		mysql_query($query);
	}

	$query = "	UPDATE event 
				SET t_edited = CURRENT_TIMESTAMP
				WHERE id = $event_id";
	mysql_query( $query );

	header("Content-type: application/json");
	
	$ans = get_program_update( $time );
	echo json_encode( $ans );
	
	die();
?>