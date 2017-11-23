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

	$todo = mysql_real_escape_string( $_REQUEST['todo'] );

	if( $todo == "add" )
	{
		$inputs = $_REQUEST['inputs'];
		
		$quantity = mysql_real_escape_string( $inputs[1] );
		$article  = mysql_real_escape_string( $inputs[2] );
		
		$quantity_js = htmlentities_utf8($inputs[1]);
		$article_js = htmlentities_utf8($inputs[2]);

		$event_id = mysql_real_escape_string( $_REQUEST['event_id'] );
		
		$_camp->event( $event_id ) || die( "error" );

		$query = "	INSERT INTO  
						mat_event
					(
						`event_id`,
						`article_name`,
						`quantity`
					)
					VALUES 
					(
						$event_id, 
						'$article', 
						'$quantity'
					)";
		mysql_query( $query );
		$id = mysql_insert_id();
				
		if( $id != 0 )
		{	$ans = array( "error" => false, "id" => $id, "values" => array( $quantity_js, $article_js ) );	}
		else
		{	$ans = array( "error" => true, "error_msg" => "Alle Felder ausfüllen." );	}
		echo json_encode( $ans );
		die();
	}

	if( $todo == "edit" )
	{
		$inputs = $_REQUEST['inputs'];
		
		$quantity = mysql_real_escape_string( $inputs[1] );
		$article  = mysql_real_escape_string( $inputs[2] );
		$article_js = htmlentities_utf8($inputs[2]);
		$quantity_js = htmlentities_utf8($inputs[1]);
		$event_id = mysql_real_escape_string( $_REQUEST['event_id'] );
		$entry_id = mysql_real_escape_string( $_REQUEST['id'] );
		
		$_camp->event( $event_id ) || 		die( "error" );
		$_camp->mat_event( $entry_id ) || 	die( "error" );
		
		$query = "	UPDATE mat_event
					SET 
						`article_name` = '$article',
						`quantity` = '$quantity'
					WHERE
						id = $entry_id";	
		$result = mysql_query( $query );
		if( !mysql_error() )
		{
			$ans = array( "error" => false, "values" => array( "1" => $quantity_js,  "2" => $article_js ) );
			echo json_encode( $ans );
			die();
		}
		else
		{
			$ans = array( "error" => true, "error_msg" => "Fehler aufgetreten" );
			echo json_encode( $ans );
			die();
		}
	}

	if( $todo == "del" )
	{
		$event_id = mysql_real_escape_string( $_REQUEST['event_id'] );
		$entry_id = mysql_real_escape_string( $_REQUEST['id'] );
		
		$_camp->event( $event_id ) || 		die( "error" );
		$_camp->mat_event( $entry_id ) || 	die( "error" );
		
		$query = "	DELETE FROM mat_event
					WHERE id = $entry_id";
		mysql_query( $query );
		
		if( !mysql_error() )
		{
			$ans = array( "error" => false );
			echo json_encode( $ans );
			die();
		}
	}
	die();
