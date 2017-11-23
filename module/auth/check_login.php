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

	session_start();

	if(	
		!isset($_SESSION['user_id']) || $_SESSION['user_id'] == "" || 
		!isset($_SESSION['user_ip']) || $_SESSION['user_ip'] != $_SERVER['REMOTE_ADDR']
	)
	{
		header("Location: login.php");
		die();
	}
	else
	{
		$_user->id = $_SESSION['user_id'];
		$_user->ip = $_SESSION['user_ip'];
		$_camp->id = $_SESSION['camp_id'];
		
		
		$query = "SELECT `id`, `mail`, `scoutname`, `firstname`, `surname`, `admin`, `active` FROM `user` WHERE `id` = '" . $_user->id . "'";

		$result = mysql_query($query);
		
		if(mysql_num_rows($result) > 0)
		{
			$_user->load_data( mysql_fetch_assoc($result) );
		
			if($_user->active == "1")
			{	
				// Namen richtig setzten
				if( $_user->scoutname != "" ) 
					$_user->display_name = $_user->scoutname;
				else 
					$_user->display_name = $_user->firstname . " " . $_user->surname;


				// Berechtigungen auslesen
				$_user_camp->auth_level = 10;
				if( $_camp->id > 0 )
				{
					$query = "SELECT id, function_id FROM user_camp WHERE user_id = $_user->id AND camp_id = $_camp->id";
					$result = mysql_query( $query );
					$_user_camp->load_data( mysql_fetch_assoc( $result ) );
					
					# Besitzer überprüfen
					$query = "	SELECT  `camp`.`id` , `is_course`, `type` ,  `creator_user_id` ,  `short_name` ,  `short_prefix` ,  `groups`.`name` 
								FROM  `camp` 
								LEFT JOIN  `groups` ON  `groups`.`id` =  `camp`.`group_id` 
								WHERE  `camp`.`id` ='" . $_camp->id . "'";
					$result = mysql_query($query);
					if(mysql_num_rows($result) > 0)
					{
						$_camp->load_data( mysql_fetch_assoc($result) );
						
						if( $_camp->creator_user_id == $_user->id )
						{	$_user_camp->auth_level = 60;	}
					
						# Sonst: Funktion überprüfen
						else
						{
							if( $_camp->is_course)
							    $fnc = "function_course";
							else
							    $fnc = "function_camp";
							
							$query = "	SELECT 
											MAX(dropdown.value) as level 
										FROM 
											camp, 
											dropdown, 
											user_camp 
										WHERE 
											user_camp.active=1 AND 
											camp.id=user_camp.camp_id AND 
											user_camp.function_id=dropdown.id AND 
											dropdown.list='".$fnc."' AND 
											user_camp.user_id='" . $_user->id . "' 
											AND camp.id='" . $_camp->id . "'";
							$result = mysql_query($query);
							if(mysql_num_rows($result) > 0)
							{
								$val = mysql_fetch_assoc($result);
								if( $val[level] > $_user_camp->auth_level) 
								{	$_user_camp->auth_level = $val[level];	}
							}
						}
					}
					
				}
				
				// Wenn möglich Admin setzen
				if( $_user->admin == 1 ) $_user_camp->auth_level = 100;
			}
			else
			{	
				header("Location: login.php");	
			}
		}
		else
		{	
			header("Location: login.php");	
		}	
	}
?>