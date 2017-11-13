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

	$user_id = mysql_real_escape_string( $_REQUEST['user'] );
	$day_id  = mysql_real_escape_string( $_REQUEST['day_id'] );
	
	$_camp->day( $day_id ) || die( "error" );

	if( $user_id )
	{
		$query = "	SELECT
						user_camp.id
					FROM
						user_camp
					WHERE
						user_camp.camp_id = $_camp->id AND
						user_camp.user_id = $user_id";
		$result = mysql_query( $query );
		$user_camp_id = mysql_result( $result, 0, 'id' );
	
		$query = "
					SELECT
						job_day.id as job_day_id,
						job.id as job_id
					FROM
						job_day,
						job
					WHERE
						job.show_gp = 1 AND
						job.camp_id = $_camp->id AND
						job_day.day_id = $day_id AND
						job.id = job_day.job_id
					";
		$result = mysql_query( $query );
		
		if( mysql_num_rows( $result ) )
		{
			$job_day_id = mysql_result( $result, 'job_day_id' );
			
			$query = "	UPDATE job_day
						SET user_camp_id = $user_camp_id
						WHERE id = $job_day_id";
			mysql_query( $query );
		}
		else
		{
			$query = "	SELECT job.id as job_id
						FROM job
						WHERE 
							job.camp_id = $_camp->id AND
							job.show_gp = 1";
			$result = mysql_query( $query );
			$job_id = mysql_result( $result, 'job_id' );
			
			$query = "	INSERT INTO job_day
						( `job_id`, `day_id`, `user_camp_id` )
						VALUES
						( $job_id, $day_id, $user_camp_id )";
			mysql_query( $query );
		}
	}
	else
	{
		$query = "	SELECT job.id as job_id
					FROM job
					WHERE 
						job.camp_id = $_camp->id AND
						job.show_gp = 1";
		$result = mysql_query( $query );
		$job_id = mysql_result( $result, 'job_id' );
		
		$query = "	DELETE FROM job_day WHERE job_id = $job_id AND day_id = $day_id";
		mysql_query( $query );
	}

	header("Content-type: application/json");
	
	$ans_array= array( "error" => false, "value" => $user_id );
	echo json_encode($ans_array);
	die();
?>