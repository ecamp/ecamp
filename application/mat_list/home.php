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

	$users = array();
	$mat_buy_lists = array();
	
	$query = "	SELECT user.*, user_camp.id as user_camp_id
				FROM user, user_camp, dropdown
				WHERE 	user_camp.function_id = dropdown.id AND dropdown.entry != 'Support' AND
						user.id = user_camp.user_id AND user_camp.camp_id = $_camp->id";
	$result = mysql_query( $query );
	
	while( $u = mysql_fetch_assoc( $result ) )
	{
		if( $u['scoutname'] )	{	$u['display_name'] = $u['scoutname'];	}
		else	{	$u['display_name'] = $u['firstname'] . " " . $u['surname'];	}
		
		$u['href'] = "index.php?app=mat_list&listtype=user&list=" . $u['user_camp_id'];
		
		$users[] = $u;
	}
	
	$query = "	SELECT mat_list.*
				FROM mat_list
				WHERE mat_list.camp_id = $_camp->id";
	$result = mysql_query( $query );
	
	while( $m = mysql_fetch_assoc( $result ) )
	{
		$m['href'] = "index.php?app=mat_list&listtype=mat_list&list=" . $m['id'];
		$mat_lists[] = $m;
	}

	if( isset( $_REQUEST['listtype'] ) && isset( $_REQUEST['list'] ) )
	{
		$selected = true;
		$list_id = $_REQUEST['list'];

		$list_entries = array();
		
		if( $_REQUEST['listtype'] == "user" )
		{
			$query = "	SELECT mat_event.*, event.name as event_name
						FROM mat_event, event
						WHERE
							event.camp_id = $_camp->id AND
							event.id = mat_event.event_id AND
							mat_event.user_camp_id = $list_id
						ORDER BY
							mat_event.event_id";
			
			$result = mysql_query( $query );
			
			while( $list_entry = mysql_fetch_assoc( $result ) )
			{
				$list_entries[] = $list_entry;
			}
		}
		elseif( $_REQUEST['listtype'] == "mat_list" )
		{
			$_camp->mat_list( $list_id ) || die( "error" );
			
			$query = "	SELECT mat_event.*, event.name as event_name
						FROM mat_event, event
						WHERE
							event.camp_id = $_camp->id AND
							event.id = mat_event.event_id AND
							mat_event.mat_list_id = $list_id";
			$result = mysql_query( $query );
			
			while( $list_entry = mysql_fetch_assoc( $result ) )
			{
				$list_entries[] = $list_entry;
			}
		}
	}
	else
	{	$selected = false;	}

	$mat_list = array(
		"select" 		=> array(	"title" => "Materiallisten",	"macro" => $GLOBALS['tpl_dir']."/application/mat_list/select.tpl/select" ),
		"display" 		=> array(	"title" => "Materialliste",		"macro" => $GLOBALS['tpl_dir']."/application/mat_list/display.tpl/display" ),
		"users" 		=> $users,
		"mat_lists"	=> $mat_lists,
		"selected"		=> $selected,
		"list_entries"	=> $list_entries,
	    "listtype"    => $_REQUEST['listtype'],
		"list"        => $_REQUEST['list']
	);
	
	$_page->html->set( 'mat_list', $mat_list );
	$_page->html->set('main_macro', $GLOBALS['tpl_dir'].'/application/mat_list/border.tpl/border');
