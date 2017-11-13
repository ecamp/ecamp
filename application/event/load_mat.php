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

	//	MAT-ARTICLE:
	// ==============
	$query = "	SELECT
					mat_event.*,
					mat_article.name
				FROM
					mat_event
				LEFT JOIN
					mat_article
				ON
					mat_event.mat_article_id = mat_article.id
				WHERE
					(
						mat_event.user_camp_id IS NOT NULL OR
						mat_event.mat_list_id IS NOT NULL
					) AND
					event_id = $event_id";
	$result = mysql_query( $query );
	
	$mat_article_event = array();
	
	while( $row = mysql_fetch_assoc( $result ) )
	{
		if( $row['user_camp_id'] )
		{
			$query = "	SELECT user.scoutname
						FROM user, user_camp
						WHERE user.id = user_camp.user_id 
						AND user_camp.id = " . $row['user_camp_id'];
			$subresult = mysql_query( $query );
			$resp_str = mysql_result( $subresult, 0, 'scoutname' );
		}
		if( $row['mat_list_id'] )
		{
			$query = "	SELECT mat_list.name
						FROM mat_list
						WHERE mat_list.id = " . $row['mat_list_id'];
			$subresult = mysql_query( $query );
			$resp_str = mysql_result( $subresult, 0, 'name' );
		}
		
		$row['list_name'] = $row['article_name'];
		$row['resp_str'] = $resp_str;
		$mat_article_event[] = $row;
	}
	$_page->html->set( 'mat_article_event_list', $mat_article_event );
	
	//print_r( $mat_article_event );
	//die();

	//	MAT-STUFF - STOCKED:
	// ======================
	$query = "	SELECT
					mat_event.id,
					mat_event.article_name,
					mat_event.quantity
				FROM
					mat_event
				WHERE
					ISNULL( mat_event.user_camp_id ) AND
					ISNULL( mat_event.mat_list_id ) AND
					mat_event.event_id = $event_id";
	$result = mysql_query( $query );
	$mat_stuff_stocked = array();
	
	while( $row = mysql_fetch_assoc( $result ) )
	{
		$mat_stuff_stocked[] = $row;
	}
	$_page->html->set( 'mat_stuff_stocked_list', $mat_stuff_stocked );

	//	MAT-STUFF - NONSTOCKED:
	// =========================
	/*
	$query = "	SELECT
					mat_available.id,
					mat_available.name,
					mat_available.quantity
				FROM
					mat_available
				WHERE
					mat_available.event_id = $event_id";
	$result = mysql_query( $query );
	$mat_stuff_nonstocked = array();
	
	while( $row = mysql_fetch_assoc( $result ) )
	{
		$mat_stuff_nonstocked[] = $row;
	}
	$_page->html->set( 'mat_stuff_nonstocked_list', $mat_stuff_nonstocked );
	*/
?>