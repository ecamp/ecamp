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
	if( $_user_camp->auth_level <= 50 )
	{
		// Keine Berechtigung
		$ans = array( "error" => true, "msg" => "Keine Berechtigung!" );
		echo json_encode( $ans );
		die();
	}

	// Feld auslesen
	$job_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['job_id']);
	
	$_camp->job( $job_id ) || die( "error" );
	
	// Job überprüfen
	$query = "SELECT * FROM job WHERE camp_id='$_camp->id' AND id='$job_id'";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	if( mysqli_num_rows( $result ) == 0 )
	{
		$ans = array( "error" => true, "msg" => "Lager-ID und Job-ID passen nicht zusammen!" );
		echo json_encode( $ans );
		die();
	}
	
	$query = "UPDATE job SET show_gp = 0 WHERE camp_id='$_camp->id'";
	mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	$query = "UPDATE job SET show_gp = 1 WHERE camp_id='$_camp->id' AND id='$job_id'";
	mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	$ans = array("error" => false, "job_id" => $job_id);
	echo json_encode($ans);
	die();
