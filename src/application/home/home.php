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

	$_page->html->set('main_macro', $GLOBALS['tpl_dir'].'/application/home/home.tpl/home');

	// Einladungen suchen
	$query = "SELECT * FROM user_camp WHERE user_id='$_user->id' AND active=0";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	$num = mysqli_num_rows( $result );
	
	if( $num > 0 )
	{
		$_page->html->set( 'inventions', true );
		$_page->html->set( 'num_inventions', $num );
	}
	else
	{
		$_page->html->set( 'inventions', false );
		$_page->html->set( 'num_inventions', 0 );
	}
	
	// Notizen zu den verantwortlichen Programmblöcken anzeigen
	$notes = array();
	$no_notes = true;
	/*
	$query = "SELECT co.id AS comment_id, e.id as event_id, e.name as event, ca.name as camp, co.text, co.t_created, co.t_edited, u.scoutname as creater, cu.id AS comment_user_id
				FROM event_responsible r, 
					 event e,
					 camp ca,
					 comment_user cu,
					 comment co
				LEFT JOIN user u ON u.id = co.user_id
				WHERE  r.user_id=$_user->id
				  AND  r.event_id=e.id
				  AND  e.camp_id = ca.id
				  AND  cu.user_event_id = r.id
				  AND  cu.comment_id = co.id";
	$result = mysql_query($query);

	while( $row = mysql_fetch_array($result, MYSQL_ASSOC) )
	{
		$notes[] = $row;
		$no_notes = false;
	}
	*/

	$no_news = ( count( $_news->load() ) == 0 );

	$_page->html->set( 'notes', $notes );
	$_page->html->set( 'no_notes', $no_notes );
	
	$_page->html->set( 'news', $_news->load() );
	$_page->html->set( 'no_news', $no_news );
