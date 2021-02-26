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

	
	$day_id  = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'day_id' ] );
	$job_id  = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'job_id' ] );
	$user_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'user_id' ] );
	
	$_camp->day( $day_id ) || die( "error" );
	$_camp->job( $job_id ) || die( "error" );
	
	
	if( $user_id )
	{
		$query = "	SELECT
						user_camp.id
					FROM
						user_camp
					WHERE
						user_camp.camp_id = $_camp->id AND
						user_camp.user_id = $user_id";
		$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		$user_camp_id = mysqli_result( $result,  0,  'id' );
		
		$query = "	SELECT
						job_day.id
					FROM
						job_day
					WHERE
						job_day.day_id = $day_id AND
						job_day.job_id = $job_id";
		$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		
		if( mysqli_num_rows( $result ) )
		{
			$query = "	UPDATE
							job_day
						SET
							job_day.user_camp_id = $user_camp_id
						WHERE
							job_day.day_id = $day_id AND
							job_day.job_id = $job_id";
			$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		}
		else
		{
			$query = "	INSERT INTO
							job_day
						( `job_id`, `day_id`, `user_camp_id` )
						VALUES
						( $job_id, $day_id, $user_camp_id )";
			$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		}
	}
	else
	{
		$query = "	DELETE FROM job_day WHERE job_id = $job_id AND day_id = $day_id";
		mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	}
	
	if( mysqli_error($GLOBALS["___mysqli_ston"]) )
	{
		$ans = array( "error" => true, "error_msg" => "Fehler aufgetreten" );
		echo json_encode( $ans );
		die();
	}
	else
	{
		$ans = array( "error" => false, "value" => $user_id );
		echo json_encode( $ans );
		die();
	}
	
	
	die();
	
?>