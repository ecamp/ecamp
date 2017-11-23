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

	$camp_del_id 	= mysql_real_escape_string($_REQUEST['camp_id']);
	
	// Rechte überprüfen (nur Ersteller darf Lager löschen
	$query = "SELECT id, short_name FROM camp WHERE id='$camp_del_id' AND creator_user_id='$_user->id'";
	$result = mysql_query($query);
	if( mysql_num_rows($result) == 0 )
	{
		// error
		$ans = array("ans" => "Lager wurde nicht gel&ouml;scht. Keine Berechtigung!", "del" => false);
		echo json_encode($ans);
		die();
	}
	else
	{
		$short_name = mysql_result( $result, 0, 'short_name' );

		$query = "	DELETE FROM 
						camp 
					WHERE 
						camp.id = '$camp_del_id'";
		
		// Camp löschen
		// Der Rest (subcamp, day, event, category, user_camp, preuser_camp, preuser) wird automatisch gelöscht (innoDB)
		mysql_query($query);
		
		//$q[camp] 		= "DELETE FROM camp			WHERE id = '$camp_del_id'";
		//$q[user_camp]	= "DELETE FROM user_camp 	WHERE camp_id = '$camp_del_id'";
		//$q[subcamp]		= "DELETE FROM subcamp 		WHERE camp_id = '$camp_del_id'";
		//$q[category]	= "DELETE FROM category 	WHERE camp_id = '$camp_del_id'";
		
		//$q[helper]		= "DELETE FROM helper		WHERE camp_id = '$camp_del_id'";
		//$q[event]		= "DELETE FROM program		WHERE camp_id = '$camp_del_id'";
		//$q[tn]			= "DELETE FROM tn			WHERE camp_id = '$camp_del_id'";
		
		//$q[budget] 		= "DELETE FROM budget 		WHERE camp_id = '$camp_del_id'";
		
		// foreach($q as $query)
		//{	mysql_query($query);	}
		
	    $_news->add2camp( "Lager gelöscht", $_user->display_name . " hat das Lager '$short_name' gelöscht.", time(), $camp_id );
		$_news->add2user( "Lager gelöscht", "Du hast das Lager '$short_name' gelöscht.", time(), $_user->id );

		if($_SESSION['camp_id'] == $camp_del_id)
		{
			$_SESSION['camp_id'] = "";
			$reload = true;
		}
		else
		{	$reload = false;	}
		
		$ans = array("ans" => "Lager wurde gelöscht!", "del" => true, "reload" => $reload );
		echo json_encode($ans);
		die();
	}
	
	die();
