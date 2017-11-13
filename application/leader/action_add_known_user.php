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

	$user = mysql_real_escape_string($_REQUEST['add_user_id']);
	$function = mysql_real_escape_string($_REQUEST['function_id']);
	
	$query = "SELECT * FROM user_camp WHERE user_id = '$user' AND camp_id = '$_camp->id'";
	//die( $query );
	
	$result = mysql_query($query);

	if( mysql_num_rows($result) > 0)
	{	
		$ans = array("error" => true, "msg" => "Diese Person arbeitet beim ausgewählten Lager bereits mit. Solle diese nicht der Fall sein, kontaktiere bitte den Support." );
		echo json_encode( $ans );
		die();
	}

	$query = "INSERT INTO user_camp	(user_id ,camp_id ,function_id, invitation_id, active)
			  VALUES ('$user', '$_camp->id', '$function','$_user->id','0')";
	$result = mysql_query($query);

	$ans = array("error" => false, "msg" => "Die Person wurde dem Lager eingeladen. Sie muss die Einladung erst annehmen, bevor sie mitarbeiten kann." );
	echo json_encode( $ans );
	die();
?>