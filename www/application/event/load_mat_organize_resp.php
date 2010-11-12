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

	/*
		[ 
			{ tag: 'optgroup', label: 'Leiter:', options:
				[
					{ tag: 'option', value: '2', html:'Forte' }, 
					{ tag: 'option', value: '2', html:'Smiley' } 
				]
			},
			{ tag: 'optgroup', label: 'Einkaufslisten:', options:
				[
					{ tag: 'option', value: '2', html:'Baumarkt' }, 
					{ tag: 'option', value: '2', html:'Lebensmittelmarkt' } 
				]
			}
		]
	*/
	
	$options = array();
	$users = array();
	$mat_lists = array();
	
	
	$query = "	SELECT
					user.*
				FROM
					user, user_camp
				WHERE
					user.id = user_camp.user_id AND
					user_camp.camp_id = $_camp->id";
	$result = mysql_query( $query );
	
	while( $u = mysql_fetch_assoc( $result ) )
	{
		$user = array( "tag" => "option", "value" => "user_" . $u[id], "html" => htmlentities_utf8($u[scoutname]) );
		$users[] = $user;
	}
	
	
	
	$query = "	SELECT
					mat_list.*
				FROM
					mat_list
				WHERE
					mat_list.camp_id = $_camp->id";
	$result = mysql_query( $query );
	
	while( $m = mysql_fetch_assoc( $result ) )
	{
		$mat_list = array( "tag" => "option", "value" => "mat_list_" . $m[id], "html" => htmlentities_utf8($m[name]) );
		$mat_lists[] = $mat_list;
	}
	
	
	$options[] = array( "tag" => "optgroup", "label" => "Leiter:", "options" => $users );
	$options[] = array( "tag" => "optgroup", "label" => "Einkaufslisten:", "options" => $mat_lists );
	
	
	$_js_env->add( 'mat_organize_resp', $options );	

?>