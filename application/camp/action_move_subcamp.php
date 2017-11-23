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
	$move_to = mysql_real_escape_string($_REQUEST['subcamp_start']);
    $subcamp_move_id = mysql_real_escape_string($_REQUEST['subcamp_id']);
	
	$move_to = ereg("([0-9]{1,2})[\/\. -]+([0-9]{1,2})[\/\. -]+([0-9]{1,4})", $move_to, $regs);
	$move_to = gmmktime(0, 0, 0, $regs[2], $regs[1], $regs[3]);

	$_camp->subcamp( $subcamp_move_id ) || die( "error" );

	// Subcamp suchen
	$query = "SELECT * FROM subcamp WHERE id=$subcamp_move_id AND camp_id=$_camp->id";
	$result = mysql_query( $query );
	$subcamp = mysql_fetch_assoc( $result );
	
	if( !$subcamp )
	{
		//header( "Location: index.php?app=camp" );
		$ans = array( "error" => true, "msg" => "Fehler" );
		echo json_encode( $ans );
		die();
	}

	// Überschneidungen prüfen
	$start = new c_date(); $start->setUnix( $move_to );
	$end   = new c_date(); $end->setDay2000( $start->getValue() + $subcamp['length'] - 1 );
	
	$query = "SELECT * FROM `subcamp` WHERE camp_id=".$_camp->id." AND NOT id=".$subcamp['id']." AND(`start` BETWEEN -10000 AND ".($start->getValue()+$subcamp[length]-1).") AND ((`start`+`length`-1) BETWEEN ".$start->getValue()." AND 32000)";
	$result = mysql_query( $query );
	
	if( mysql_num_rows( $result ) >= 1 )
	{	
		$ans = array( "error" => true, "msg" => "Der ausgewählte Zeitabschnitt überschneidet sich mit einem anderen Lagerabschnitt. Wähle einen freien Lagerabschnitt aus!");
		echo json_encode( $ans );
		die();
	}

	// Verschiebung durchführen
	$query = "UPDATE subcamp SET start=".$start->getValue()." WHERE id=".$subcamp['id'];
	mysql_query( $query );

	$ans = array( "error" => false, "subcamp_start" => $start->getString("d.m.Y"), "subcamp_end" => $end->getString("d.m.Y") );
	echo json_encode( $ans );
	die();	
