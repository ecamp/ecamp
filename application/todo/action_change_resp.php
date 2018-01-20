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

	$todo_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['todo_id'] );
	$user = $_REQUEST['user'];
	
	$_camp->todo( $todo_id ) || die( "error" );

	foreach( $user as $user_id => $selected )
	{
		$user_id 	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $user_id  );
		$selected 	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $selected );

		$query = "SELECT user_camp.id FROM user_camp WHERE user_camp.camp_id = $_camp->id AND user_camp.user_id = $user_id";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
		
		if( mysqli_error($GLOBALS["___mysqli_ston"]) || mysqli_num_rows($result) == 0 )
		{
			$ans = array( "error" => true, "msg" => "User arbeitet nicht in diesem Lager" );
			die( json_encode( $ans ) );
		}
		
		$user_camp_id = mysqli_result( $result,  0,  'id' );

		$query = "SELECT * FROM todo WHERE id = $todo_id AND camp_id = $_camp->id";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
		if( mysqli_num_rows($result) == 0 )
		{
			$ans = array( "error" => true, "msg" => "Aufgabe und Lager passen nicht zusammen!" );
			die( json_encode( $ans ) );
		}

		$query = "SELECT * FROM todo_user_camp WHERE user_camp_id = $user_camp_id AND todo_id = $todo_id";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
		$num_rows = mysqli_num_rows( $result );
		if( $num_rows > 0 && ( $selected == 'false' ) )
		{
			$query = "DELETE FROM todo_user_camp WHERE user_camp_id = $user_camp_id AND todo_id = $todo_id";
			$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
		}
		if( $num_rows == 0 && ( $selected =='true' ) )
		{
			$query = "INSERT INTO todo_user_camp (todo_id, user_camp_id) VALUES ( $todo_id, $user_camp_id )";
			$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
		}
	}

	$query = "	SELECT
					user_camp.user_id,
					IF( ISNULL( todo_user_camp.todo_id ), 0, 1) as resp
				FROM
					dropdown,
					user_camp
				LEFT JOIN
					(
						SELECT
							todo_user_camp.todo_id,
							todo_user_camp.user_camp_id
						FROM
							todo_user_camp
						WHERE
							todo_user_camp.todo_id = $todo_id
					) as todo_user_camp
				ON
					todo_user_camp.user_camp_id = user_camp.id
				WHERE
					user_camp.function_id = dropdown.id AND
					dropdown.entry != 'Support' AND
					user_camp.camp_id = $_camp->id";

	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	while( $row = mysqli_fetch_assoc( $result ) )
	{	$ans['value'][] = array( 'value' => $row['user_id'], 'selected' => ( $row['resp'] == 1 ) );	}
	
	$ans['error'] = false;
	die( json_encode( $ans ) );
