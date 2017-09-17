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

	$job_name = htmlentities_utf8(trim($_REQUEST['job_name']));	
	$job_name_save = mysql_real_escape_string($_REQUEST['job_name']);
	
	$cmd      = mysql_real_escape_string($_REQUEST['cmd']);	
	
	// Authentifizierung überprüfen
	// write --> Ab Lagerleiter (level: 50)
	if( $_user_camp->auth_level < 50 || $job_name =="" )
	{
	    // Keine Berechtigung
		if( $_user_camp->auth_level < 50 )
		{
    		//$xml_replace[error] = 1;
			//$xml_replace['error-msg'] = "Keine Berechtigung";
			$ans = array( "error" => true, "msg" => "Keine berechtigung!" );
			echo json_encode( $ans );
			die();
		}
		else
		{
			//$xml_replace[error] = 2;
			//$xml_replace['error-msg'] = "Bitte gib zuerst einen Job-Namen ein!";
			$ans = array( "error" => true, "msg" => "Bitte gib zuerst einen Job-Namen ein!" );
			echo json_encode( $ans );
			die();
		}
	}
	
	
	// Überprüfen, ob gleicher Tagesjob scho besteht
	$query = "SELECT * FROM job WHERE camp_id='$_camp->id' AND job_name='$job_name_save'";
	$result = mysql_query( $query );
	if( mysql_num_rows($result) > 0 )
	{
		$ans = array( "error" => true, "msg" => "Ein Job mit diesem Namen besteht bereits!" );
		echo json_encode( $ans );
		die();
	}
	
	
	$query = "INSERT INTO `job` (`camp_id` ,`job_name` ,`show_gp`)
			  VALUES ('$_camp->id', '$job_name_save', '0');";
	mysql_query($query);
	$id = mysql_insert_id();
	
	$ans = array( "error" => false, "job_id" => $id, "job_name" => $job_name );
	echo json_encode( $ans );
	die();
?>