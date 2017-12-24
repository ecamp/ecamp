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

	$group_id		= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['groups']);
	$name 			= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['camp_name']);
	$short_name		= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['camp_short_name']);
	$group_name		= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['scout']);
	$function		= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['function_id']);
	$jstype			= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['jstype']);
	$is_course		= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['is_course']);
	$camp_type		= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['camp_type']);
	$course_type	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['course_type']);
	$course_type_text = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['course_type_text']);
	
	$start		= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['camp_start']);
	$end		= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['camp_end']);
	
	$start = ereg("([0-9]{1,2})[\/\. -]+([0-9]{1,2})[\/\. -]+([0-9]{1,4})", $start, $regs);
	$start = gmmktime(0, 0, 0, $regs[2], $regs[1], $regs[3]);
	
	$end = ereg("([0-9]{1,2})[\/\. -]+([0-9]{1,2})[\/\. -]+([0-9]{1,4})", $end, $regs);
	$end = gmmktime(0, 0, 0, $regs[2], $regs[1], $regs[3]);
	
	$c_start = new c_date;
	$c_end = new c_date;
	
	$c_start->setUnix($start);
	$c_end->setUnix($end);

	$length = $c_end->getValue() - $c_start->getValue() + 1;
	$start = $c_start->getValue();
	$ende = $c_end->getValue();

	$is_course = (boolean) $is_course;
	if( !$is_course )	{	$type = 0;	}
	else				{	$type = $course_type;	}

	if($length <= 0 )
	{
		echo "Das Enddatum darf nicht vor dem Startdatum liegen!";
		echo "<br /><a href='javascript:history.back()'>Zur&uuml;ck</a>";
		die();
	}
	else if( $length > 40 )
	{
		echo "Die maximale L&auml;nge eines Lagers betr&auml;gt 40 Tage.";
		echo "<br /><a href='javascript:history.back()'>Zur&uuml;ck</a>";
		die();
	}

	// Lager hinzufügen
	$query = "INSERT INTO camp (group_id, name ,group_name, short_name, is_course, jstype, type, type_text, creator_user_id, t_created )
						VALUES ('$group_id', '$name', '$group_name', '$short_name', '$is_course', '$jstype', '$type', '$course_type_text', '$_user->id', " . time() . ")";
	mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	$last_camp_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
	
	// Kateogiren hinzufügen
	if( $is_course )
	{
		$query = "INSERT INTO category (camp_id, name, short_name, color, form_type)
					VALUES 
						('$last_camp_id', 'Ausbildung', 'A', '548dd4' , 4), 
						('$last_camp_id', 'Pfadi erleben', 'P', 'ffa200' , 4), 
						('$last_camp_id', 'Roter Faden', 'RF', '14dd33' , 4),
						('$last_camp_id', 'Gruppestunde', 'GS', '99ccff' , 4),
						('$last_camp_id', 'Essen', '', 'bbbbbb' , 0),
						('$last_camp_id', 'Sonstiges', '', 'FFFFFF' , 0)";
	}else{
		$query = "INSERT INTO category (camp_id, name, short_name, color, form_type)
					VALUES 
						('$last_camp_id', 'Essen', 'ES', 'bbbbbb' , 0),
						('$last_camp_id', 'Lagerprogramm', 'LP', '99ccff' , 3), 
						('$last_camp_id', 'Lageraktivität', 'LA', 'ffa200' , 2), 
						('$last_camp_id', 'Lagersport', 'LS', '14dd33' , 1)";
	}
	mysqli_query($GLOBALS["___mysqli_ston"], $query);

	// ToDo std. einfüllen
	if( $is_course)
	{
		$query = "INSERT INTO todo (camp_id, title, short, date)
					VALUES
						('$last_camp_id', 'Kursanmeldung',  					'Anmeldung an LKB (Picasso, Blockübersicht, Checklisten)', " . ( $start - 8 * 7 ) . "),
						('$last_camp_id', 'Detailprogramm einreichen', 			'Definitives Detailprogramm an LKB.', " . ( $start - 2 * 7 ) . "),
						('$last_camp_id', 'Kursabschluss', 						'TN-Liste, Kursbericht', " . ( $ende + 3 * 7 ) . "),
						('$last_camp_id', 'J+S-Material/Landeskarten', 			'J+S-Material und Landeskarten bestellen.', " . ( $start - 6 * 7 ) . ")";

	}else{
		$query = "INSERT INTO todo (camp_id, title, short, date)
					VALUES
						('$last_camp_id', 'Lagerhaus/Lagerplatz reservieren', 	'Das Lagerhaus/Lagerplatz definitiv reservieren.', " . ( $start - 8 * 30 ) . "),
						('$last_camp_id', 'Küchenteam suchen', 					'Das Küchenteam zusammenstellen.', " . ( $start - 6 * 30 ) . "),
						('$last_camp_id', 'Picasso zusammenstellen', 			'Ersten Entwurf des Picassos zusammenstellen.', " . ( $start - 6 * 30 ) . "),
						('$last_camp_id', 'PBS - Lageranmeldung', 				'PBS - Lageranmeldung ausfüllen und an Coach schicken.', " . ( $start - 3 * 30 ) . "),
						('$last_camp_id', 'J&S - Materialbestellung', 			'J&S - Materialbestellung ausfüllen und an Coach schicken', " . ( $start - 3 * 30 ) . "),
						('$last_camp_id', 'Landeskartenbestellung', 			'Landeskartenbestellung ausfüllen und an Coach schicken', " . ( $start - 3 * 30 ) . "),
						('$last_camp_id', 'J&S - Lageranmeldung', 				'Sicherstellen, dass Coach das Lager unter J&S anmeldet (online).', " . ( $start - 2 * 30 ) . "),
						('$last_camp_id', 'Spendenaufrufe verschicken', 		'Spendenaufrufe an regionale Firmen verschicken.', " . ( $start - 2 * 30 ) . "),
						('$last_camp_id', 'Lageranmeldung verschicken', 		'Lageranmeldung an alle TN verschicken.', " . ( $start - 2 * 30 ) . "),
						('$last_camp_id', 'Programmabgabe', 					'Fertiges Programm an Coach abgeben.', " . ( $start - 6 * 7 ) . "),
						('$last_camp_id', 'Siebdruck anfertigen', 				'Siebdruck / Lagerdruck anfertigen.', " . ( $start - 4 * 7 ) . "),
						('$last_camp_id', 'Regaversicherung', 					'Für alle TN eine gratis - Regaversicherung abschliessen.', " . ( $start - 2 * 7 ) . "),
						('$last_camp_id', 'Letzte Infos verschicken', 			'Letzte Infos für TNs verschicken', " . ( $start - 2 * 7 ) . ")";
	}
	mysqli_query($GLOBALS["___mysqli_ston"],  $query );

	// Tages-chef hinzufügen
	$query = "INSERT INTO job (camp_id, job_name, show_gp)
							VALUES ('$last_camp_id', 'Tageschef', '1')";
	mysqli_query($GLOBALS["___mysqli_ston"], $query);

	//Einkaufslisten hinzufügen:
	$query = "INSERT INTO mat_list ( camp_id, name )
							VALUES( '$last_camp_id', 'Lebensmittel' )";
	mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	$query = "INSERT INTO mat_list ( camp_id, name )
							VALUES( '$last_camp_id', 'Baumarkt' )";
	mysqli_query($GLOBALS["___mysqli_ston"],  $query );

	// Eigenen User hinzufügen
	$query = "INSERT INTO user_camp (user_id, camp_id, function_id, active)
							VALUES	($_user->id, $last_camp_id, $function, '1')";
	mysqli_query($GLOBALS["___mysqli_ston"], $query);

	// Subcamp hinzufügen
	$query = "INSERT INTO subcamp 	(camp_id, start, length)
						VALUES	($last_camp_id, $start, $length)";
	mysqli_query($GLOBALS["___mysqli_ston"], $query);
	$last_subcamp_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
	
	// Days hinzufügen
	$days = array();
	
	for($i=0; $i < $length; $i++)
	{	$days[] = "('$last_subcamp_id', '$i')";	}
	
	$query = "INSERT INTO day (subcamp_id, day_offset) VALUES ";
	$query .= implode( ", ", $days );
	
	mysqli_query($GLOBALS["___mysqli_ston"], $query);

	$result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id FROM user_camp WHERE user_id='$_user->id' AND camp_id='$last_camp_id'");
	if( mysqli_num_rows($result) == 0 )
	{
		$_SESSION['camp_id'] = 0;
		header("Location: index.php?app=home");
		die();
	}

	$_SESSION['camp_id'] = $last_camp_id;
	
	$query = "UPDATE user SET last_camp = '$last_camp_id' WHERE id = '" . $_user->id . "'";
	mysqli_query($GLOBALS["___mysqli_ston"], $query);

	header("Location: index.php?app=camp&cmd=home&show=firsttime");
	die();
