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

		$article = mysql_real_escape_string( $_REQUEST['article'] );
		$quantity = mysql_real_escape_string( $_REQUEST['quantity'] );
		$event_id = mysql_real_escape_string( $_REQUEST['event_id'] );
		
		$_camp->event( $event_id ) || die( "error" );
		
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
		$result = mysql_query( $query );
		
		if( mysql_num_rows( $result ) )
		{	$id = mysql_result( $result, 0, 'id' );	}
		else
		{	$id = "NULL";	}
		
		$query = "	SELECT
						*
					FROM
						mat_article_event
					WHERE
						event_id = $event_id AND
						mat_article_id = $id AND
						article_name = '$article'";
		$result = mysql_query( $query );
		
		if( mysql_num_rows($result) )
		{
			$mode = mysql_real_escape_string( $_REQUEST['mode'] );
			if( $mode == "concat" )
			{}
			elseif( $mode == "seperate" )
			{}
			elseif( !isset( $mode ) || $mode == "" )
			{
				$ans = array( "ans" => "aks_concat_seperate" );
				echo json_encode( $ans );
			}
		}
		else
		{
			$query = "	INSERT INTO  
							mat_article_event
						(
							`event_id` ,
							`mat_article_id` ,
							`article_name` ,
							`quantity`
						)
						VALUES 
						(
							$event_id, 
							$id , 
							'$article', 
							$quantity
						)";
			mysql_query( $query );
			
			
			$ans = array( "ans" => "saved" );
			echo json_encode( $ans );
		}

	die();
