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

	# Search for all camps, the user is working
	#
	#########################################################
	$c_date = new c_date;
	$c_date->setUnix( time() );

	$dropdown = array();

	$query = "	SELECT
					camp.*,
					groups.id as groups_id,
					groups.short_prefix,
					groups.name as groups_name
				FROM
					user_camp,
					camp
				LEFT JOIN
					groups
				ON
					groups.id = camp.group_id
				WHERE
					user_camp.active = 1 AND
					user_camp.camp_id = camp.id AND
					user_camp.user_id = $_user->id";
	
	$result = mysql_query( $query );
	
	while( $camp = mysql_fetch_assoc( $result ) )
	{
		$subquery = "	SELECT	MAX( subcamp.start + subcamp.length - 1 ) as camp_end
						FROM	subcamp
						WHERE	subcamp.camp_id = " . $camp['id'];
		$subresult = mysql_query( $subquery );
		$camp_end = mysql_result( $subresult, 0 , 'camp_end' );
		
		
		//$dropdown[$camp[groups_id]] = array();
		$dropdown[$camp[groups_id]][group_name] = $camp[short_prefix] . " " . $camp[groups_name];
		//$dropdown[$camp[groups_id]][camp_list]  = array();
		
		//$dropdown[$camp[groups_id]][camp_list][$camp[id]] = array();
		$dropdown[$camp[groups_id]][camp_list][$camp[id]][short_name] = $camp[short_name];
		$dropdown[$camp[groups_id]][camp_list][$camp[id]][id] = $camp[id];
		
		$dropdown[$camp[groups_id]][camp_list][$camp[id]][past] = ( $camp_end < $c_date->getValue() );
		
		
		if( $camp[id] == $_camp->id )
		{	$dropdown[$camp[groups_id]][camp_list][$camp[id]][selected] = true;		}
		else
		{	$dropdown[$camp[groups_id]][camp_list][$camp[id]][selected] = false;	}
		
		
		if( !$dropdown[$camp[groups_id]][child_num] )
		{	$dropdown[$camp[groups_id]][child_num] = false;	}
		
		$dropdown[$camp[groups_id]][child_num] = 	$dropdown[$camp[groups_id]][child_num] || 
													!$dropdown[$camp[groups_id]][camp_list][$camp[id]][past] ||
													$dropdown[$camp[groups_id]][camp_list][$camp[id]][selected];
	}

	/*
	if($_user_camp->auth_level == 100)
	{	$query = "SELECT * FROM dropdown WHERE list = 'function'";	}
	else
	{	$query = "SELECT * FROM dropdown WHERE list = 'function' AND value > 0";	}
	$result = mysql_query($query);
	
	
	while($function = mysql_fetch_assoc($result))
	{
		$dropdown[$function[id]] = array();
		$dropdown[$function[id]][func_name] = $function['entry'];
		$dropdown[$function[id]][camp_list] = array();
		
		$query = "	SELECT 
						camp.group_name,
						camp.name, 
						camp.short_name,
						camp.id 
					FROM 
						user_camp,
						camp
					WHERE
						user_camp.user_id = ".$_user->id." AND
						user_camp.function_id = ".$function[id]." AND
						user_camp.camp_id = camp.id AND
						user_camp.active = '1'";
		$subresult = mysql_query($query);
		$option = "";
		
		while($camp = mysql_fetch_assoc($subresult))
		{
			$dropdown[$function[id]][camp_list][$camp[id]] = array();
			$dropdown[$function[id]][camp_list][$camp[id]][short_name] = $camp[short_name];
			$dropdown[$function[id]][camp_list][$camp[id]][id] = $camp[id];
			
			if($camp['id'] == $_camp->id )
			{	$dropdown[$function[id]][camp_list][$camp[id]][selected] = true;	}
			else
			{	$dropdown[$function[id]][camp_list][$camp[id]][selected] = false;	}
			
		}
	}
	*/
	$_page->html->set('menu_dropdown', $dropdown);
?>