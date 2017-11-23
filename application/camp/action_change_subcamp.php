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

	// Input validieren & interpretieren
	$change_start = mysql_real_escape_string($_REQUEST['subcamp_start']);
	$change_end   = mysql_real_escape_string($_REQUEST['subcamp_end']);
    $subcamp_change_id = mysql_real_escape_string($_REQUEST['subcamp_id']);
	
	$change_start = ereg("([0-9]{1,2})[\/\. -]+([0-9]{1,2})[\/\. -]+([0-9]{1,4})", $change_start, $regs);
	$change_start = gmmktime(0, 0, 0, $regs[2], $regs[1], $regs[3]);
	
	$change_end   = ereg("([0-9]{1,2})[\/\. -]+([0-9]{1,2})[\/\. -]+([0-9]{1,4})", $change_end  , $regs);
	$change_end   = gmmktime(0, 0, 0, $regs[2], $regs[1], $regs[3]);
	
	$_camp->subcamp( $subcamp_change_id ) || die( "error" );

	// Subcamp suchen
	$query = "SELECT * FROM subcamp WHERE id=$subcamp_change_id AND camp_id='$_camp->id'";
	$result = mysql_query( $query );
	
	if( mysql_num_rows($result) == 0 )
	{
		//header( "Location: index.php?app=camp" );
		$ans = array( "error" => true, "msg" => "Fehler" );
		echo json_encode( $ans );
		die();
	}
	
	$subcamp = mysql_fetch_assoc( $result );
	$subcamp['end'] = $subcamp['start'] + $subcamp['length'] - 1;
	
	// Datum auslesen
	$c_start = new c_date();
	$c_end = new c_date();
	
	$c_start->setUnix($change_start);
	$c_end->setUnix($change_end);
	
	$start = $c_start->getValue();
	$end   = $c_end->getValue();
	$length = $end - $start + 1;
	
	// Verkehrt rum
	if($length <= 0 )
	{
		$ans = array( "error" => true, "msg" => "Das Enddatum darf nicht vor dem Startdatum liegen!" );
		echo json_encode( $ans );
		die();
	}
	// zu lang
	else if( $length > 40 )
	{
		$ans = array( "error" => true, "msg" => "Die maximale Länge eines Lagerabschnitts beträgt 40 Tage. Verwende bitte mehrere Lagerabschnitt für überlange Lager!" );
		echo json_encode( $ans );
		die();
	}
	
	// Überschneidungen prüfen
	$query = "SELECT * FROM `subcamp` WHERE camp_id=".$_camp->id." AND NOT id=".$subcamp[id]." AND(`start` BETWEEN -10000 AND ".($end).") AND ((`start`+`length`-1) BETWEEN ".$start." AND 32000)";
	$result = mysql_query( $query );
	
	if( mysql_num_rows( $result ) >= 1 )
	{	
		$ans = array( "error" => true, "msg" => "Der ausgewählte Zeitabschnitt überschneidet sich mit einem anderen Lagerabschnitt. Wähle einen freien Lagerabschnitt aus!" );
		echo json_encode( $ans );
		die();
	}
	
	// Check: keine Blöcke drin
	$query = "SELECT event.id FROM event, event_instance, day, subcamp WHERE event_instance.event_id = event.id AND event_instance.day_id=day.id AND day.subcamp_id=subcamp.id AND subcamp.id=".$subcamp[id]." AND NOT ((subcamp.start+day.day_offset) BETWEEN $start AND $end)";
	$result = mysql_query( $query );
	$error = mysql_num_rows( $result );
	if( $error != 0 )
	{
		$ans = array( "error" => true, "msg" => "Das Zeitfenster kann nicht verändert werden. Es würden dabei ".$error." Programmblöcke verloren gehen.<br><br>Bitte lösche/verschiebe die entsprechenden Blöcke und führe die Änderung erneut durch." );
		echo json_encode( $ans );
		die();
	}

	/////////////////////////////////////////////////
	// Zeitfenster-Veränderung vornehmen

	  // Verorene Tage löschen	
	  $query = "DELETE FROM `day` WHERE `subcamp_id`=$subcamp[id] AND NOT ((`day_offset`+$subcamp[start]) BETWEEN $start AND $end)";
	  mysql_query( $query );
	  
	  // Verbliebene Tage verschieben
	  if( $start >= $subcamp['start'] )
	  	$summand = "- ".($start - $subcamp['start']);
	  else
	    $summand = "+ ".($subcamp['start'] - $start);
		
	  $query = "UPDATE day SET day_offset=day_offset ".$summand." WHERE day.subcamp_id=".$subcamp['id'];
	  mysql_query( $query );
	  
	  // Zusätzliche Tage vorne hinzufügen
	  if( $start < $subcamp['start'] )
	  {
	  	for( $i=0; $i < $subcamp['start'] - $start; $i++ )
		{
			$query = "INSERT INTO day 	    ( subcamp_id, day_offset)
				 	  VALUES 				( '$subcamp[id]', '$i')";
			mysql_query($query);
		}
	  }
	  
	  // Zustäzliche Tage hinten hinzufügen  
	  if( $end > $subcamp['end'] )
	  {
	  	for( $i=$subcamp['end']-$start+1; $i <= $end - $start; $i++ )
		{
			$query = "INSERT INTO day 	    ( subcamp_id, day_offset)
				 	  VALUES 				( '$subcamp[id]', '$i')";
			mysql_query($query);
		}
	  }
	  
	  // Subcamp anpassen
	  $query = "UPDATE subcamp SET `start`=$start, `length`=".($end-$start+1)." WHERE `id`=".$subcamp['id'];
	  mysql_query( $query );
	
	$ans = array( "error" => false, "subcamp_start" => $c_start->getString("d.m.Y"), "subcamp_end" => $c_end->getString("d.m.Y") );
	echo json_encode( $ans );
	die();
