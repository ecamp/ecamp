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

	$event_id 	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['event_id']);
	$day_id 	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['day_id']);
	
	$_camp->event( $event_id ) || die( "error" );
	$_camp->day( $day_id ) || die( "error" );
	
	// Zugehörigkeit zum Lager überprüfen (Sicherheitsabfrage)
	$query = "SELECT event.id, event.detail_id FROM event,day,subcamp WHERE event.id='$event_id' AND event.day_id=day.id AND day.subcamp_id=subcamp.id AND subcamp.camp_id='$camp[id]'";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	if( mysqli_num_rows($result) == 0 )
	{
		echo "error";
		die();
	}
	
	$event = mysqli_fetch_assoc($result);
	
	// Event-Details löschen (Rest per innoDB)
	$query = "	DELETE FROM
					event_detail 
				WHERE id = '$event[detail_id]'";
	mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	// Event löschen
	$query = "DELETE FROM event WHERE id = '$event_id'";
	mysqli_query($GLOBALS["___mysqli_ston"], $query);

	header( "Location: index.php?app=day&dayid=".$day_id );
	die();
