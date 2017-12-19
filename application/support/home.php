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

	$_page->html->set('main_macro', $GLOBALS['tpl_dir'].'/global/content_box_full.tpl/predefine');
	$_page->html->set('box_content', $GLOBALS['tpl_dir'].'/application/support/home.tpl/home');
	$_page->html->set('box_title', 'Support');
	
	$search_arg = array();
	$select_arg = array();
	
	unset( $camp_id, $camp_desc, $user_id, $user_desc );
	
	if( isset( $_REQUEST['search'] ) && $_REQUEST['search'] == 1 )
	{
		$camp_id 	= $_REQUEST['s_camp_id'];
		$camp_desc 	= $_REQUEST['s_camp_desc'];
		$user_id	= $_REQUEST['s_user_id'];
		$user_desc	= $_REQUEST['s_user_desc'];
		
		if(!empty($camp_id))	{	$search_arg[] = " camp.id 	LIKE '$camp_id%' "; 	}
		if(!empty($camp_desc))	{	$search_arg[] = " camp.name LIKE '$camp_desc%' ";	}
		if(!empty($user_id))	{	$search_arg[] = " user.id 	LIKE '$user_id%' ";		}
		if(!empty($user_desc))	{
									$search_arg[] = " user.scoutname LIKE '$user_desc%' ";
									$search_arg[] = " user.firstname LIKE '$user_desc%' ";
									$search_arg[] = " user.surname   LIKE '$user_desc%' ";
								}
		
		if(!empty($camp_id))	{	$select_arg[] = " (camp.id 		LIKE '$camp_id%')*5 + 	(camp.id 	LIKE '$camp_id')*75 "; 		}
		if(!empty($camp_desc))	{	$select_arg[] = " (camp.name 	LIKE '$camp_desc%')*2 + (camp.name 	LIKE '$camp_desc')*30 ";	}
		if(!empty($user_id))	{	$select_arg[] = " (user.id 		LIKE '$user_id%')*1 + 	(user.id 	LIKE '$user_id')*15 ";		}
		if(!empty($user_desc))	{
			$select_arg[] = " (user.scoutname LIKE '$user_desc%')*1 + (user.scoutname LIKE '$user_desc')*15 ";
			$select_arg[] = " (user.firstname LIKE '$user_desc%')*1 + (user.firstname LIKE '$user_desc')*15 ";
			$select_arg[] = " (user.surname   LIKE '$user_desc%')*1 + (user.surname   LIKE '$user_desc')*15 ";
			}
	}
	
	if( ! count( $select_arg ) )
	{	$select_arg = "0";	}
	else
	{	$select_arg = implode(" + ", 	$select_arg);	}
	
	if( ! count( $search_arg ) )
	{	$search_arg = "1";	}
	else
	{	$search_arg = implode(" OR ", 	$search_arg);	}
	
	$camp_list = array();
	
	$query = "	SELECT 
					camp.id,
					camp.group_name,
					camp.name,
					camp.short_name,
					user.scoutname,
					user.firstname,
					user.surname,
					( $select_arg ) as rank
				FROM 
					camp,
					user
				WHERE
					camp.creator_user_id = user.id
				AND
					( $search_arg )
				
				ORDER BY
					rank desc";
	
	$_page->html->set( 'query', $query );

	$result = mysql_query($query);
	
	while( $camp = mysql_fetch_assoc( $result ) )
	{
		$query = "	SELECT user_camp.* 
					FROM user_camp, dropdown 
					WHERE 
						user_camp.user_id = $_user->id AND 
						user_camp.camp_id = $camp[id] AND 
						user_camp.function_id = dropdown.id AND
						dropdown.entry = 'Support'";
		$is_supported = mysql_query( $query );
		
		if( mysql_num_rows( $is_supported ) )	{	$camp['supported'] = 1;	}
		else									{	$camp['supported'] = 0;	}
		
		if( $camp['scoutname'] != "" )
		{	$camp['creator'] = $camp['scoutname'];	}
		else
		{	$camp['creator'] = $camp['firstname'] . " " . $camp['surname'];	}
		
		$camp_list[] = $camp;
	}
	
	//	print_r( $camp_list );
	
	$_page->html->set( 'camp_list', $camp_list );
	