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

	// Camp-ID neu setzten
	// --> Die Authentifizierung ob überhaupt erlaubt findet erst nach der Weiterleitung statt
	//
	if( isset( $_REQUEST['camp']) )
	{
		$camp = $_REQUEST['camp'];
		
		if( $camp == "old_camp" )
		{
			header("Location: index.php?app=camp_admin");
			die();
		}
		
		$result = mysql_query("SELECT id FROM user_camp WHERE user_id='$_user->id' AND camp_id='$camp'");
		
		if( mysql_num_rows($result) == 0 )
		{
			header("Location: index.php?app=home");
			die();
		}

		//echo $_SESSION['camp_id'];
		
		$_SESSION['camp_id'] = $camp;
		
		//echo $_SESSION['camp_id'];
		
		$query = "UPDATE user SET last_camp = '$camp' WHERE id = '" . $_user->id . "'";

		//echo $query;
		mysql_query($query);
	}
	
	header("Location: index.php?app=camp&cmd=home");
	die();
?>