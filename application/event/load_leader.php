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

	$query = "	SELECT
					user.id,
					user.scoutname,
					user.firstname,
					user.surname,
					IF( ISNULL( event_responsible.user_id), 0, 1) as resp
				FROM
					dropdown,
					user_camp,
					user
				LEFT JOIN
					(
						select
							event_responsible.user_id
						FROM
							event_responsible
						WHERE
							event_responsible.event_id = $event_id
					) as event_responsible
				ON
					event_responsible.user_id = user.id 
				WHERE
					user_camp.function_id = dropdown.id AND
					dropdown.entry != 'Support' AND
					user.id = user_camp.user_id AND
					user_camp.camp_id = $_camp->id";
					
	$result = mysql_query( $query );
	$leaders = array();
	
	while( $leader = mysql_fetch_assoc( $result ) )
	{
		if( $leader['scoutname'] == "" )
		{	$leader['displayname'] = $leader['firstname'] . " " . $leader['surname'];	}
		else
		{	$leader['displayname'] = $leader['scoutname'];	}
		
		$leaders[] = $leader;
	}
	
	$_page->html->set( 'leaders', $leaders );
	
?>