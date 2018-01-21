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

	$todo = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['todo'] );
	
	if( $todo == "add" )
	{
		$inputs = $_REQUEST['inputs'];
		
		$quantity = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $inputs[1] );
		$article  = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $inputs[2] );
		$resp 	  = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $inputs[3] );
		
		$quantity_js = htmlentities_utf8( $inputs[1] );
		$article_js  = htmlentities_utf8( $inputs[2] );
		$resp_js     = htmlentities_utf8( $inputs[3] );
		
		$event_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['event_id'] );
		
		$_camp->event( $event_id ) || die( "error" );
		
		if( substr( $resp, 0, 4 ) == "user" )
		{
			$user_id = substr( $resp, 5 );
			$query = "	SELECT user_camp.id
						FROM user_camp
						WHERE user_id = $user_id AND camp_id = " . $_camp->id;
			$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );

			$user_camp_id = mysqli_result( $result,  0,  'id' );
			$mat_list_id = "NULL";
			
			$query = "	SELECT user.scoutname 
						FROM user
						WHERE user.id = $user_id";
			$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
			$resp_str = mysqli_result( $result,  0,  'scoutname' );
		}
		if( substr( $resp, 0, 8 ) == "mat_list" )
		{
			$user_camp_id = "NULL";
			$mat_list_id = substr( $resp, 9 );
			
			$query = "	SELECT mat_list.name 
						FROM mat_list
						WHERE mat_list.id = $mat_list_id";
			$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
			$resp_str = mysqli_result( $result,  0,  'name' );
		}
				
		$query = "	SELECT
						id
					FROM
					(
						SELECT	
							id as id,
							name as name
						FROM
							mat_article
						
						UNION
						
						SELECT
							mat_article.id as id,
							concat( mat_article_alias.name, ' (', mat_article.name, ')' ) as name
						FROM
							mat_article,
							mat_article_alias
						WHERE
							mat_article_alias.mat_article_id = mat_article.id
						
						ORDER BY name
					) as mat
					WHERE
						mat.name = '$article'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		
		if( mysqli_num_rows( $result ) )
		{	$id = mysqli_result( $result,  0,  'id' );	}
		else
		{	$id = "NULL";	}

		$query = "	INSERT INTO  
						mat_event
					(
						`event_id` ,
						`user_camp_id`,
						`mat_list_id`,
						`mat_article_id`,
						`article_name`,
						`quantity`
					)
					VALUES 
					(
						$event_id,
						$user_camp_id,
						$mat_list_id, 
						$id , 
						'$article', 
						'$quantity'
					)";
		mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		$id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
		
		if( $id != 0 )
		{	$ans = array( "error" => false, "id" => $id, "values" => array( $quantity_js, $article_js, $resp_str ) );	}
		else
		{	$ans = array( "error" => true, "error_msg" => "Alle Felder ausfüllen." );	}
		
		echo json_encode( $ans );
		die();
	}

	if( $todo == "edit" )
	{
		$inputs = $_REQUEST['inputs'];
		
		$quantity = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $inputs[1] );
		$article  = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $inputs[2] );
		$resp 	  = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $inputs[3] );
		
		$quantity_js = htmlentities_utf8( $inputs[1] );
		$article_js  = htmlentities_utf8( $inputs[2] );
		$resp_js     = htmlentities_utf8( $inputs[3] );
		
		$event_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['event_id'] );
		$entry_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['id'] );
		
		$_camp->event( $event_id ) || die( "error" );
		$_camp->mat_event( $entry_id ) || die( "error" );

		if( substr( $resp, 0, 4 ) == "user" )
		{
			$user_id = substr( $resp, 5 );
			$query = "	SELECT user_camp.id
						FROM user_camp
						WHERE user_id = $user_id AND camp_id = " . $_camp->id;
			$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );

			$user_camp_id = mysqli_result( $result,  0,  'id' );
			$mat_list_id = "NULL";
			
			$query = "	SELECT user.scoutname 
						FROM user, user_camp
						WHERE user.id = user_camp.user_id
						AND user_camp.id = $user_camp_id";
			$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
			$resp_str = mysqli_result( $result,  0,  'scoutname' );
		}
		if( substr( $resp, 0, 8 ) == "mat_list" )
		{
			$user_camp_id = "NULL";
			$mat_list_id = substr( $resp, 9 );
			
			$query = "	SELECT mat_list.name 
						FROM mat_list
						WHERE mat_list.id = $mat_list_id";
			$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
			$resp_str = mysqli_result( $result,  0,  'name' );
		}
		
		$resp_str_js = htmlentities_utf8( $resp_str );

		$query = "	SELECT
						id
					FROM
					(
						SELECT	
							id as id,
							name as name
						FROM
							mat_article
						
						UNION
						
						SELECT
							mat_article.id as id,
							concat( mat_article_alias.name, ' (', mat_article.name, ')' ) as name
						FROM
							mat_article,
							mat_article_alias
						WHERE
							mat_article_alias.mat_article_id = mat_article.id
						
						ORDER BY name
					) as mat
					WHERE
						mat.name = '$article'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		
		if( mysqli_num_rows( $result ) )
		{	$id = mysqli_result( $result,  0,  'id' );	}
		else
		{	$id = "NULL";	}
		
		$query = "	UPDATE mat_event
					SET 
						`user_camp_id` = $user_camp_id,
						`mat_list_id` = $mat_list_id,
						`mat_article_id` = $id,
						`article_name` = '$article',
						`quantity` = '$quantity'
					WHERE
						id = $entry_id";	
		$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		if( !mysqli_error($GLOBALS["___mysqli_ston"]) )
		{
			$ans = array( "values" => array( "1" => $quantity_js,  "2" => $article_js, "3" => $resp_str_js ) );
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
		$event_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['event_id'] );
		$entry_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['id'] );
		
		$_camp->event( $event_id ) || die( "error" );
		$_camp->mat_event( $entry_id ) || die( "error" );
		
		$query = "	DELETE FROM mat_event
					WHERE id = $entry_id";
		mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		
		if( !mysqli_error($GLOBALS["___mysqli_ston"]) )
		{
			$ans = array( "error" => false );
			echo json_encode( $ans );
			die();
		}
	}
	die();
