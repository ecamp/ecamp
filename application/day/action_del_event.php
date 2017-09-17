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

	$event_id 	= mysql_real_escape_string($_REQUEST[event_id]);
	$day_id 	= mysql_real_escape_string($_REQUEST[day_id]); 
	
	$_camp->event( $event_id ) || die( "error" );
	$_camp->day( $day_id ) || die( "error" );
	
	// Zugehörigkeit zum Lager überprüfen (Sicherheitsabfrage)
	$query = "SELECT event.id, event.detail_id FROM event,day,subcamp WHERE event.id='$event_id' AND event.day_id=day.id AND day.subcamp_id=subcamp.id AND subcamp.camp_id='$camp[id]'";
	$result = mysql_query($query);
	if( mysql_num_rows($result) == 0 )
	{
		echo "error";
		die();
	}
	
	$event = mysql_fetch_assoc($result);
	
	// Event-Details löschen (Rest per innoDB)
	$query = "	DELETE FROM
					event_detail 
				WHERE id = '$event[detail_id]'";
	mysql_query($query);
	
	// Event löschen
	$query = "DELETE FROM event WHERE id = '$event_id'";
	mysql_query($query);

	header( "Location: index.php?app=day&dayid=".$day_id );
	die();
?>