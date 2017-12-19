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
	
	$job_list = array();
	
	$query = "	SELECT
					user.id,
					user.scoutname,
					user.firstname,
					user.surname
				FROM
					user,
					user_camp,
					dropdown
				WHERE
					user_camp.function_id = dropdown.id AND
					dropdown.entry != 'Support' AND
					user.id = user_camp.user_id AND
					user_camp.camp_id = $_camp->id";
	$result = mysql_query( $query );
	
	while( $user = mysql_fetch_assoc( $result ) )
	{	$job_list['users'][ $user['id'] ] = $user;	}

	$query = "	SELECT
					job.id,
					job.job_name,
					IF( ISNULL( job_day.user_camp_id ), '0', job_day.user_camp_id ) as user_camp_id,
					IF( ISNULL( user_camp.user_id ), '0', user_camp.user_id ) as user_id
				FROM
					job
				LEFT JOIN
					(
						SELECT
							job_day.*
						FROM
							job_day
						WHERE
							job_day.day_id = $day_id
					) as job_day
				ON
					job.id = job_day.job_id
				LEFT JOIN
					user_camp
				ON
					user_camp.id = job_day.user_camp_id 
				WHERE
					job.camp_id = $_camp->id";
	$result = mysql_query( $query );
	
	while( $job = mysql_fetch_assoc( $result ) )
	{	$job_list['jobs'][ $job['id'] ] = $job;	}
