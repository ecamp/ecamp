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

	$job_id   = mysql_real_escape_string($_REQUEST['job_id']);	
	
	$_camp->job( $job_id ) || die( "error" );

	// Authentifizierung überprüfen
	// write --> Ab Lagerleiter (level: 50)
	if( $_user_camp->auth_level < 50 || $job_id == "")
	{
	    // Keine Berechtigung
		if( $_user_camp->auth_level < 50 )
		{
    		//$xml_replace[error] = 1;
			//$xml_replace['error-msg'] = "Keine Berechtigung";
			
			$ans = array( "error" => true, "msg" => "Keine Berechtigung!" );
			echo json_encode( $ans );
			die();
		}
		else
		{
			//$xml_replace[error] = 2;
			//$xml_replace['error-msg'] = "<![CDATA[Bitte zuerst Job auswählen!]]>";
			
			$ans = array( "error" => true, "msg" => "Bitte zuerst einen Job auswälen" );
			echo json_encode( $ans );
			die();
		}
	}
	
	// Überprüfen, ob gleicher Tagesjob scho besteht
	$query = "DELETE FROM job WHERE camp_id='$_camp->id' AND id='$job_id'";
	$result = mysql_query( $query );
	
	$ans = array( "error" => false );
	echo json_encode( $ans );
	die();
