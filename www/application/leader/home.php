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

	$_page->html->set('main_macro', $GLOBALS['tpl_dir'].'/global/content_box_fit.tpl/predefine');
	$_page->html->set('box_content', $GLOBALS['tpl_dir'].'/application/leader/home.tpl/home');
	$_page->html->set('box_title', 'Leiterliste');

	# Leitertabelle anzeigen:
	#
	##############################################
	if( $_camp->is_course )
		$query = "SELECT * FROM dropdown WHERE list='function_course' AND value > '0'";
	else
		$query = "SELECT * FROM dropdown WHERE list='function_camp' AND value > '0'";

	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	$leaders = array();
	
	while($function = mysqli_fetch_assoc($result))
	{
		$subquery = "
			SELECT 
				user.id,
				user.scoutname,
				user.firstname,
				user.surname,
				user.mail,
				user.mobilnr,
				user_camp.active,
				user_camp.id AS user_camp_id
			FROM 
				user,
				user_camp 
			WHERE 
				user_camp.camp_id = '$_camp->id' AND
				user_camp.function_id = '" . $function[id] . "' AND
				user_camp.user_id = user.id";
		
		//echo $subquery;
		
		$subresult = mysqli_query($GLOBALS["___mysqli_ston"], $subquery);
		
		$leader_list = array();
	
		while($leader_data = mysqli_fetch_assoc($subresult))
		{	
			if($leader_data['active'])
			{	$leader_data['green'] = true;		$leader_data['yellow'] = false;	}
			else
			{	$leader_data['green'] = false;	$leader_data['yellow'] = true;	}
			
			$leader_data['scoutname'] = $leader_data['scoutname'];
			$leader_data['firstname'] = $leader_data['firstname'];
			$leader_data['surname'] = $leader_data['surname'];
			$leader_data['mail'] = $leader_data['mail'];
			
			$leader_data['mailto'] = "mailto:" . $leader_data['mail'];
			$leader_data['callto'] = "callto:" . $leader_data['mobilnr'];
			
			$leader_data['vcard'] = "index.php?app=leader&cmd=vcard&user_id=" . $leader_data['id'];
			$leader_data['detail'] = "index.php?app=leader&cmd=show_user&id=" . $leader_data['id'];
			
			if( $_camp->creator_user_id == $leader_data['id']  )
			{
				$leader_data['exit']	= false;
				$leader_data['creator'] 	= true;
			}
			elseif( $_user_camp->auth_level < 50 )
			{
				$leader_data['exit']	= false;
				$leader_data['creator'] 	= false;
			}
			else
			{
				$leader_data['exit']	= true;
				$leader_data['creator'] 	= false;
			}
			
			$leader_list[] = $leader_data;
		}
		
		$show = ( $function[id] == 1 );
		$leaders[] = array( "function_id" => $function['id'], "function_name" => $function['entry'], "show" => $show, "users" => $leader_list );
	}
	
	$leader = array(
		"leaders" => $leaders
	);
	
	//print_r($leader);
	
	$_page->html->set( 'leader', $leader );

	include("module/info/leader.php");
	
	$_page->html->set( 'show_info_box', true );
	$_page->html->set( 'info_box', $GLOBALS['tpl_dir'].'/module/info/info_box.tpl/info_box' );
