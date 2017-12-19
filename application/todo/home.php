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
	
	$_page->html->set('main_macro', $GLOBALS['tpl_dir'].'/application/todo/border.tpl/border');
	
	$todo_list = array();
	$date = new c_date();

	//	SUBCAMPS:
	// ===========
	$query = "	SELECT camp.id, subcamp.start , subcamp.start + subcamp.length as end
				FROM camp, subcamp
				WHERE camp.id = subcamp.camp_id AND camp_id = " . $_camp->id;
	$result = mysql_query( $query );
	
	while( $subcamp = mysql_fetch_assoc( $result ) )
	{
		$date->setDay2000( $subcamp['end'] );
		$end = $date->getString( 'd.m.Y' );
		
		$date->setDay2000( $subcamp['start'] );
		$start = $date->getString( 'd.m.Y' );
		
		$todo_list[$date->getString('Ym')]['name'] = strtr( $date->getString("F Y"), $GLOBALS[en_to_de] );
		$todo_list[$date->getString('Ym')]['todos'][$date->getString('d')][] = array( 
			"date" => $start,
			"camptime" => true,
			"entry" => false,
			"today" => false,
			"short" => $start . " - " . $end );
			
		ksort( $todo_list[$date->getString("Ym")]['todos'] );
	}

	//  TODAY:
	// ========
	
	$todo_list[date("Ym")]['name'] = strtr( date("F Y"), $GLOBALS['en_to_de'] );
	$todo_list[date("Ym")]['todos'][date("d")][] = array( "date" => strtr( date("D d. M"), $GLOBALS['en_to_de'] ), "camptime" => false, "entry" => false, "today" => true );
	ksort( $todo_list[date("Ym")]['todos'] );

	$query = "	SELECT
					todo.*
				FROM
					todo
				WHERE
					todo.camp_id = $_camp->id
				ORDER BY
					todo.date";
	$result = mysql_query($query);
	
	while( $todo = mysql_fetch_assoc($result) )
	{
		if( $date->getUnix() < time() )
		{
			$date->setDay2000( $todo['date'] );
			
			if( $date->getUnix() > time() )
			{
				//$todo_list[date("Ym")]['name'] = strtr( date("F Y"), $GLOBALS[en_to_de] );
				//$todo_list[date("Ym")]['todos'][] = array( "date" => strtr( date("D d. M"), $GLOBALS[en_to_de] ), "camptime" => false, "entry" => false, "today" => true );
			}
		}
		
		$date->setDay2000( $todo['date'] );
		
		$todo['camptime'] = false;
		$todo['today'] = false;
		$todo['entry'] = true;
		$todo['resp'] = array();
		
		$todo['date'] = strtr( $date->getString("D d. M"), $GLOBALS['en_to_de'] );
		$todo['date_value'] = $date->getString("d.m.Y");
		
		$todo['disabled'] = ( $todo['done'] ) ? 'disabled' : '';
		
		$subquery = "	SELECT
							user.id,
							user.scoutname,
							user.firstname,
							user.surname,
							IF( ISNULL( todo_user_camp.todo_id ), 0, 1) as resp
						FROM
							dropdown,
							user,
							user_camp
						LEFT JOIN
							(
								SELECT
									todo_user_camp.todo_id,
									todo_user_camp.user_camp_id
								FROM
									todo_user_camp
								WHERE
									todo_user_camp.todo_id = $todo[id]
							) as todo_user_camp
						ON
							todo_user_camp.user_camp_id = user_camp.id
						WHERE
							user_camp.function_id = dropdown.id AND
							dropdown.entry != 'Support' AND
							user.id = user_camp.user_id AND
							user_camp.camp_id = $_camp->id";

		$todo['resp_class'] = "";
		
		$subresult = mysql_query($subquery);
		while( $todo_user = mysql_fetch_assoc($subresult) )
		{
			if( $todo_user['scoutname'] )
			{	$todo['resp'][] = array( "id" => $todo_user[id], "resp" => $todo_user[resp], "class" => "resp_user", "name" => $todo_user[scoutname] );	}
			else
			{	$todo['resp'][] = array( "id" => $todo_user[id], "resp" => $todo_user[resp], "class" => "resp_user", "name" => $todo_user[firstname] . " " . $todo_user[surname] );	}
			
			if( $todo_user['resp'] == 1 )
			{	$todo['resp_class'] .= "user_" . $todo_user[id] . " ";	}
		}

		$todo_list[$date->getString("Ym")]['name'] = strtr( $date->getString("F Y"), $GLOBALS[en_to_de] );
		$todo_list[$date->getString("Ym")]['todos'][$date->getString('d')][] = $todo;
		
		ksort( $todo_list[$date->getString("Ym")]['todos'] );
	}
	
	if( $date->getUnix() < time() )
	{
		//$todo_list[date("Ym")]['name'] = strtr( date("F y"), $GLOBALS[en_to_de] );
		//$todo_list[date("Ym")]['todos'][] = array( "date" => strtr( date("D d. M"), $GLOBALS[en_to_de] ), "camptime" => false, "entry" => false, "today" => true );
	}
	
	ksort( $todo_list );
	
	$_page->html->set('todo_list', $todo_list);

	$user_list = array();
	$query = "	SELECT
					user.id,
					user.scoutname,
					user.firstname,
					user.surname
				FROM
					user,
					user_camp,
					dropdown
				WHERE
					user_camp.function_id = dropdown.id AND
					dropdown.entry != 'Support' AND
					user.id = user_camp.user_id AND
					user_camp.camp_id = $_camp->id
				ORDER BY
					user.scoutname";
	$result = mysql_query($query);
	while( $user = mysql_fetch_assoc($result) )
	{
		if( $user['scoutname'] )
		{	$user['name'] = $user['scoutname'];	}
		else
		{	$user['name'] = $user['firstname'] . " " . $user['surname'];	}
		
		$user_list[] = $user;
	}
	
	$_page->html->set( 'user_list', $user_list );
