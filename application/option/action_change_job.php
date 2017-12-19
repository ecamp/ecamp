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

	// Authentifizierung überprüfen
	// write --> Ab Lagerleiter (level: 50)
	if( $_user_camp->auth_level < 50 )
	{
	    // Keine Berechtigung
    	$ans = array( "error" => true, "msg" => "Keine Berechtigung!" );
		echo json_encode( $ans );
		die();
	}

	// Feld auslesen
	$job_change_id = mysql_real_escape_string($_REQUEST['job_id']);
	$change_job = trim($_REQUEST['job_name']);
	$change_job_save = mysql_real_escape_string($change_job);
	
	$_camp->job( $job_change_id ) || die( "error" );

	// Job überprüfen
	$query = "SELECT * FROM job WHERE camp_id='$_camp->id' AND id='$job_change_id'";
	$result = mysql_query( $query );
	
	$query2 = "SELECT * FROM job WHERE camp_id='$_camp->id' AND NOT id='$job_change_id' AND job_name='$change_job_save'";
	$result2 = mysql_query( $query2 );
	
	if( mysql_num_rows( $result ) == 0 || mysql_num_rows($result2) != 0 )
	{
		// Job und Camp passen nicht zusammen
		if( mysql_num_rows( $result ) == 0)
		{
    		//$xml_replace[error] = 1;
			//$xml_replace['error-msg'] = "Lager-ID und Job-ID passen nicht zusammen!";
			
			$ans = array( "error" => true, "msg" => "Lager-ID und Job-ID passen nicht zusammen!" );
			echo json_encode( $ans );
			die();
		}
		// Job mit selbem Namen gibt es bereits
		else
		{
			//$xml_replace[error] = 2;
			//$xml_replace['error-msg'] = "Ein Job mit einem solchen Namen besteht bereits!";
			
			$ans = array( "error" => true, "msg" => "Ein Job mit einem solchen Namen besteht bereits!" );
			echo json_decode( $ans );
			die();
		}
	}
	
	$query = "UPDATE job SET job_name = '$change_job_save' WHERE camp_id='$_camp->id' AND id='$job_change_id'";
	mysql_query($query);
	
	$ans = array( "error" => false, "job_id" => $job_change_id, "job_name" => htmlentities_utf8($change_job) );
	echo json_encode( $ans );
	die();
