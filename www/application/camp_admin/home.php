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

	
	$_page->html->set('main_macro', $GLOBALS[tpl_dir].'/application/camp_admin/border.tpl/border');
	$_page->html->set('box_content', $GLOBALS[tpl_dir].'/application/camp_admin/home.tpl/home');
	$_page->html->set('box_title', 'Lager-Admin');
	
	
	//if( $_camp->is_course )
	//	$query = "SELECT * FROM dropdown WHERE list = 'function_course'";
	//else
	//	$query = "SELECT * FROM dropdown WHERE list = 'function_camp'";
	
	$query = "SELECT * FROM dropdown WHERE list = 'function_camp' OR list = 'function_course'";
		
	$result = mysql_query($query);
	$function_list = array();
	while($row = mysql_fetch_assoc($result))
	{	$function_list[$row[id]] = $row[entry];	}
	
	$active_camp_list = array();
	$request_camp_list = array();
	
	
	$query = "	SELECT 
					camp.*,
					user_camp.function_id,
					user_c.scoutname AS scoutname_c,
					user_c.surname AS surname_c,
					user_c.firstname AS firstname_c,
					user_camp.id AS user_camp_id
				FROM
					user,
					user_camp,
					camp
					LEFT JOIN (user AS user_c) ON user_c.id=camp.creator_user_id
				WHERE
					user_camp.user_id = '$_user->id' AND
					user_camp.camp_id = camp.id AND
					user_camp.active = 1 AND
					user_camp.user_id = user.id
				ORDER BY camp.id DESC";
	
	$result = mysql_query($query);
	while($camp_detail = mysql_fetch_assoc($result))
	{
		$subquery = "SELECT 
						MIN( subcamp.start ) AS start , 
						MAX( subcamp.start + subcamp.length - 1 ) AS end
					FROM 
						camp, 
						subcamp 
					WHERE 
						subcamp.camp_id = camp.id AND
						camp.id = $camp_detail[id]";
						
		$subresult = mysql_query($subquery);
		$camp_time = mysql_fetch_assoc($subresult);
		
		$c_start = new c_date;
		$c_end = new c_date;
		$c_today = new c_date;
		
		$camp_detail['sort'] = $camp_time['start'];
		
		$c_start->setDay2000($camp_time['start']);
		$c_end->setDay2000($camp_time['end']);
		$c_today->setUnix( time() );
		
		$camp_detail['past'] = ( $c_end->getValue() < $c_today->getValue() );
		
		$camp_detail['start'] = date("d.m.Y", $c_start->getUnix());
		$camp_detail['end'] = date("d.m.Y", $c_end->getUnix());
		
		$camp_detail['creator'] = $camp_detail[scoutname_c] . " / " . $camp_detail[firstname_c] . " " . $camp_detail[surname_c];
		$camp_detail['function'] = $function_list[$camp_detail['function_id']];
		
		if( $camp_detail[creator_user_id] == $_user->id )
		{	$camp_detail['delete'] = true;	$camp_detail['exit'] = false;	}
		else
		{	$camp_detail['delete'] = false;	$camp_detail['exit'] = true;	}
		
		$camp_detail['change_camp'] = "index.php?app=camp&cmd=action_change_camp&camp=" . $camp_detail[id];
		
		$active_camp_list[] = $camp_detail;
		$active_camp_sort[] = $camp_detail['sort'];
	}
	
	if( is_array( $active_camp_sort ) )
	{	array_multisort( $active_camp_sort, SORT_DESC, $active_camp_list );	}
	
	
	
	
	$query = 
		"SELECT camp.*,
			user.mail,
			user.scoutname,
			user.surname,
			user.firstname,
			user_camp.id AS user_camp_id
		FROM
			camp,
			user_camp
			LEFT JOIN user ON user.id=user_camp.invitation_id
		WHERE
			user_camp.user_id = '$_user->id' AND
			user_camp.camp_id = camp.id AND
			user_camp.active = 0";
	
	$result = mysql_query($query);
	
	$request_camp_show = ( mysql_num_rows($result) > 0 );
	
	while($camp_detail = mysql_fetch_assoc($result))
	{
		$subquery = "SELECT 
						MIN( subcamp.start ) AS start , 
						MAX( subcamp.start + subcamp.length ) AS end
					FROM 
						camp, 
						subcamp 
					WHERE 
						subcamp.camp_id = camp.id AND
						camp.id = $camp_detail[id]";
						
		$subresult = mysql_query($subquery);
		$camp_time = mysql_fetch_assoc($subresult);
		
		$c_start = new c_date;
		$c_end = new c_date;
		
		$c_start->setDay2000($camp_time['start']);
		$c_end->setDay2000($camp_time['end']);
		
		$camp_detail['start'] = date("d.m.Y", $c_start->getUnix());
		$camp_detail['end'] = date("d.m.Y", $c_end->getUnix());
		
		$camp_detail[scout]  = $camp_detail[scout];
		$camp_detail[name]   =  $camp_detail[name];
		$camp_detail[slogan] = $camp_detail[slogan];
		
		if( $camp_detail[mail] == "" )
			$camp_detail[from] = "<unbekannt>";
		else
			$camp_detail[from] = $camp_detail[scoutname]." / ".$camp_detail[firstname]." ".$camp_detail[surname];
		
		$request_camp_list[] = $camp_detail;
	}
	
	
	$show_list = ( $_REQUEST['show_list'] == 1 ) ? true : false;
	
	$_page->html->set('show_list', 			$show_list );
	$_page->html->set('active_camp_list', 	$active_camp_list );
	$_page->html->set('request_camp_list', 	$request_camp_list );
	$_page->html->set('request_camp_show', 	$request_camp_show );
	
?>