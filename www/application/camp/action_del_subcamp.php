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

	$subcamp_id = mysql_real_escape_string($_REQUEST[subcamp_id]);

	$_camp->subcamp( $subcamp_id ) || die( "error" );

	// Überprüfen, ob noch eines vorhanden ist
	$query = "SELECT * FROM subcamp WHERE camp_id = $_camp->id";
	$result = mysql_query($query);
	if( mysql_num_rows($result) >= 2 )
	{
		$query = "	DELETE FROM 
						subcamp 
					WHERE 
						subcamp.id = '$subcamp_id' AND
						subcamp.camp_id = $_camp->id";
		
		// Subcamp löschen
		// Der Rest (day, event) wird automatisch gelöscht (innoDB)
		mysql_query($query);
		
		
		$query = "	SELECT event.id
					FROM event
					LEFT JOIN event_instance 
					ON event.id = event_instance.event_id
					WHERE ISNULL( event_instance.id )";
		$result = mysql_query( $query );
		
		while( $row = mysql_fetch_assoc( $result ) )
		{	mysql_query( "DELETE FROM event WHERE id = " . $row['id']	);	}
		
		
		$ans = array( "error" => false );
		echo json_encode($ans);
		die();
	}

	$ans = array( 
					"error" => true,
					"msg"	=> "Der ausgewählte Lagerabschnitt konnte nicht gelöscht werden. Ein Lager muss immer aus min. 1 Lagerabschnitt bestehen.<br /><br />Verwende &quot;Zeitfenster verändern&quot; oder &quot;Programm verschieben&quot; um den Lagerzeitpunkt zu ändern."
				);
	echo json_encode($ans);
	die();
?>