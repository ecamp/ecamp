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

	// Authentifizierung überprüfen
	$start = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['subcamp_start']);
	$end = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['subcamp_end']);

	$start = preg_match("/([0-9]{1,2})[\/\. -]+([0-9]{1,2})[\/\. -]+([0-9]{1,4})/", $start, $regs);
	$start = gmmktime(0, 0, 0, $regs[2], $regs[1], $regs[3]);
	
	//$start = preg_replace("/^\s*([0-9]{1,2})[\/\. -]+([0-9]{1,2})[\/\. -]+([0-9]{1,4})/", "\\2/\\1/\\3", $start);
	//$start = strtotime($start);
	
	$end = preg_match("/([0-9]{1,2})[\/\. -]+([0-9]{1,2})[\/\. -]+([0-9]{1,4})/", $end, $regs);
	$end = gmmktime(0, 0, 0, $regs[2], $regs[1], $regs[3]);
	
	//$end = preg_replace("/^\s*([0-9]{1,2})[\/\. -]+([0-9]{1,2})[\/\. -]+([0-9]{1,4})/", "\\2/\\1/\\3", $end);
	//$end = strtotime($end);
	
	$c_start = new c_date();
	$c_end = new c_date();
	
	$c_start->setUnix($start);
	$c_end->setUnix($end);
	
	$start = $c_start->getValue();
	$length = $c_end->getValue() - $c_start->getValue() + 1;
	
	if ($length <= 0)
	{
		$ans = array("error" => true, "msg" => "Das Enddatum darf nicht vor dem Startdatum liegen!");
		echo json_encode($ans);
		die();
	}
	else if ($length > 40)
	{
		$ans = array("error" => true, "msg" => "Die maximale Länge eines Lagerabschnitts beträgt 40 Tage. Verwende bitte mehrere Lagerabschnitt für überlange Lager!");
		echo json_encode($ans);
		die();
	}
	
	// Überschneidungen prüfen
	$query = "SELECT * FROM `subcamp` WHERE camp_id=".$_camp->id." AND (`start` BETWEEN -10000 AND ".$c_end->getValue().") AND ((`start`+`length`-1) BETWEEN ".$c_start->getValue()." AND 32000)";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	if (mysqli_num_rows($result) >= 1)
	{
		$ans = array("error" => true, "msg" => "Der ausgewählte Zeitabschnitt überschneidet sich mit einem anderen Lagerabschnitt. Wähle einen freien Lagerabschnitt aus!");
		echo json_encode($ans);
		die();
	}
	
	$query = "INSERT INTO subcamp 	( camp_id, start, length)
				VALUES 				( '$_camp->id', '$start', '$length')";
	mysqli_query($GLOBALS["___mysqli_ston"], $query);
	$last_subcamp_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);

	// day: Datensätze einfügen
	for ($i = 0; $i < $length; $i++)
	{
		$query = "INSERT INTO day 	    ( subcamp_id, day_offset)
				 VALUES 				( '$last_subcamp_id', '$i')";
		mysqli_query($GLOBALS["___mysqli_ston"], $query);
	}

/*	$query = "SELECT LAST_INSERT_ID() FROM subcamp";
	$result = mysql_query($query);
	$last_subcamp_id = implode(mysql_fetch_assoc($result));*/
	
//	$start 	= date("d.m.Y",	$c_start->getUnix());
//	$end	= date("d.m.Y", $c_end ->getUnix());
	
	$ans = array("error" => false);
	echo json_encode($ans);
	die();
