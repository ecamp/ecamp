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

	$event_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['event_id'] );
	$resp_user = $_REQUEST['resp_user'];
	
	$_camp->event( $event_id ) || die( "error" );
	
	$ans = array( 'value' => array() );
	
	foreach( $resp_user as $user_id => $is_resp )
	{
		$user_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $user_id );
		$is_resp = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $is_resp );
				
		$query = "	SELECT
						*
					FROM
						event_responsible
					WHERE
						user_id = $user_id AND
						event_id  = $event_id";
		$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		
		if( mysqli_num_rows( $result ) > 0 && $is_resp == 'false' )
		{
			$query = "	DELETE FROM event_responsible
						WHERE user_id = $user_id AND event_id = $event_id";
			mysqli_query($GLOBALS["___mysqli_ston"],  $query );
			
			$query = "	UPDATE event 
						SET t_edited = CURRENT_TIMESTAMP
						WHERE id = $event_id";
			mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		}
		
		if( mysqli_num_rows( $result ) == 0 && $is_resp == 'true' )
		{
			$query = "	INSERT INTO event_responsible	(	`user_id`, `event_id`	)
						VALUES 							(	$user_id,	$event_id	)";
			mysqli_query($GLOBALS["___mysqli_ston"],  $query );
			
			$query = "	UPDATE event 
						SET t_edited = CURRENT_TIMESTAMP
						WHERE id = $event_id";
			mysqli_query($GLOBALS["___mysqli_ston"],  $query );
			
			$query = "SELECT * FROM event WHERE id = $event_id";
			$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
			$event = mysqli_fetch_assoc( $result );
			
			$query = "SELECT active FROM user_camp WHERE camp_id = $_camp->id AND user_id = $user_id";
			$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
			$active = mysqli_result( $result,  0,  'active' );
			
			if( $user_id != $_user->id && $active )
			{
				$_news->add2user( 
					"Verantwortung für " . $event['name'],
					"Dir wurde die Verantwortung für den Block '" . $event['name'] . "' zugeteilt.",
					time(), $user_id );
			}
			
		}
		
		if( mysqli_error($GLOBALS["___mysqli_ston"]) )
		{	/* error */	}
		
		$ans['value'][] = array( 'value' => $user_id, 'selected' => ( $is_resp == 'true' ) );
	}
	
	$ans['error'] = false;
	echo json_encode( $ans );
	die();
	