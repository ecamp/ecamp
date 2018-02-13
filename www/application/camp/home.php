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

	$_page->html->set('main_macro', $GLOBALS['tpl_dir'].'/global/content_box_fit.tpl/predefine');
	$_page->html->set('box_content', $GLOBALS['tpl_dir'].'/application/camp/home.tpl/home');
	
	$_page->html->set('box_title', 'Infos zum Lager/Kurs');

    // Authentifizierung überprüfen
	// read & write --> Ab Lagerleiter (level: 50)
	// read         --> Ab Coach       (level: 20)
	$camp_info = array();
	
	if( $_user_camp->auth_level >= 50 )
	{
		$camp_info['input'] = true;
		$camp_info['readonly'] = false;
	}
	elseif( $_user_camp->auth_level >= 11 )
	{
		$camp_info['input'] = false;
		$camp_info['readonly'] = true;
	}
	else
	{
		$_SESSION['camp_id'] = "";
		header( "Location: index.php" );
		die();
	}

	$start = new c_date;
	$end   = new c_date;
	
	$subcamps = array();
	$query = "SELECT * FROM subcamp WHERE camp_id = '$_camp->id' ORDER BY start ASC ";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	while($row = mysqli_fetch_assoc($result))
	{
		$start->m_days = $row['start'];
		$end->m_days = $row['start'] + $row['length'] - 1;
		
		$subcamps[] = array(
			"start" => gmdate("d.m.Y", $start->getUnix()),
			"end"	=>gmdate("d.m.Y", $end->getUnix()),
			"id"	=> $row['id']
		);
	}

    // �berpr�fen, ob ein Lager gew�hlt wurde und Lagerdaten einlesen
    $query = "	SELECT 
    				camp.*,
    				groups.name as groups_name,
    				groups.short_prefix as groups_short_prefix
    			FROM
    				camp
    			LEFT JOIN
    				groups
    			ON
    				camp.group_id = groups.id
    			WHERE
    				camp.id = '$_camp->id'";
    
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	if(mysqli_num_rows($result) == 0)	{	die("Kein Lager gew&auml;hlt");	}
	$camp_data = mysqli_fetch_assoc($result);
	
	
	// Lager-Detaildaten herausfiltern
	$num1 = strpos( $camp_data['ca_coor'], "." );
	$num2 = strpos( $camp_data['ca_coor'], "/" );
	$num3 = strrpos( $camp_data['ca_coor'], "." );
	if( $num1 != "" && $num2 != "" && $num3 != "" && $num1!=$num3 )
	{
		$camp_data['ca_coor1'] = substr( $camp_data['ca_coor'], 0, $num1 );
		$camp_data['ca_coor2'] = substr( $camp_data['ca_coor'], $num1+1, $num2-$num1-1 );
		$camp_data['ca_coor3'] = substr( $camp_data['ca_coor'], $num2+1, $num3-$num2-1 );
		$camp_data['ca_coor4'] = substr( $camp_data['ca_coor'], $num3+1, strlen($camp_data['ca_coor'])-$num3 );
		
		//echo $camp['ca_coor1']." ".$camp['ca_coor2']." ".$camp['ca_coor3']." ".$camp['ca_coor4'];
		
		$camp_data['ca_coor1'] = substr( "000" . $camp_data['ca_coor1'], -3 );
		$camp_data['ca_coor2'] = substr( "000" . $camp_data['ca_coor2'], -3 );
		$camp_data['ca_coor3'] = substr( "000" . $camp_data['ca_coor3'], -3 );
		$camp_data['ca_coor4'] = substr( "000" . $camp_data['ca_coor4'], -3 );
		
		$camp_data['ca_coor'] = $camp_data['ca_coor1'] . "." . $camp_data['ca_coor2'] . "/" . $camp_data['ca_coor3'] . "." . $camp_data['ca_coor4'];
	}
	else
	{	$camp_data['ca_coor1'] = "";
		$camp_data['ca_coor2'] = "";
		$camp_data['ca_coor3'] = "";
		$camp_data['ca_coor4'] = "";
	}

	$i = 0;

	$db = new midata;
	$data = $db->getGroups($camp_data['group_id']);

	foreach($data['linked']['groups']  as $groups){
		if($groups['group_type'] == 'Bund'){
			$full_group[1] = $groups['name'];
		}

		if($groups['group_type'] == 'Kantonalverband'){
			$full_group[2] = " :: ".$groups['name'];
		}

		if($groups['group_type'] == 'Region'){
			$full_group[3] = " :: ".$groups['name'];
		}

		if($groups['group_type'] == 'Abteilung'){
			$full_group[4] = " :: ".$groups['name'];
		}
	}

	// Inhalte f�llen & bei Bedarf zur Anzeige aufbereiten
	$camp_info['base']			= $full_group[1] . $full_group[2] . $full_group[3]. $full_group[4];
	$camp_info["group_name"] 	= array("name" => "group_name", "value" => $camp_data['group_name']);
	$camp_info["name"]  		= array("name" => "name",  		"value" => $camp_data['name']);
	$camp_info["slogan"]		= array("name" => "slogan", 	"value" => $camp_data['slogan']);
	$camp_info["short_name"] 	= array("name" => "short_name",	"value" => $camp_data['short_name']);
	
	$camp_info["ca_name"]		= array("name" => "ca_name", 	"value" => $camp_data['ca_name']);
	$camp_info["ca_street"]		= array("name" => "ca_street",	"value" => $camp_data['ca_street']);
	$camp_info["ca_zipcode"]	= array("name" => "ca_zipcode", "value" => $camp_data['ca_zipcode']);
	$camp_info["ca_city"]		= array("name" => "ca_city", 	"value" => $camp_data['ca_city']);
	$camp_info["ca_tel"]		= array("name" => "ca_tel", 	"value" => $camp_data['ca_tel']);
	$camp_info["ca_coor"]		= array("name" => "ca_coor", 	"value" => $camp_data['ca_coor'], 
																"value1" => $camp_data['ca_coor1'], 
																"value2" => $camp_data['ca_coor2'], 
																"value3" => $camp_data['ca_coor3'], 
																"value4" => $camp_data['ca_coor4']);
	$camp_info['is_course']		= $camp_data['is_course'];

	$camp_info["subcamps"]		= $subcamps;
	
	$camp_info['show_map_coor']	.= $camp_data['ca_coor1'] . $camp_data['ca_coor2'] . "," . $camp_data['ca_coor3'] . $camp_data['ca_coor4'];

	if( $_REQUEST['show'] == 'firsttime' )
	{	$camp_info['firsttime'] = true;		}
	else
	{	$camp_info['firsttime'] = false;	}
	
	if( $camp_data['is_course'] )
	{
		$query = "	SELECT dropdown.entry
					FROM dropdown 
					WHERE
						value = " . $camp_data['type'] . " AND
						list = 'coursetype'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		if( mysqli_error($GLOBALS["___mysqli_ston"]) || !mysqli_num_rows($result) )
		{	$camp_info['type'] = "asdf";	}
		else
		{	$camp_info['type'] = mysqli_result($result,  0,  'entry' );	}
	}
	
	$_page->html->set('camp_info', $camp_info);

	//#####################################################
	// Load Blocked Data:
	$cdate = new c_date;
	
	$blocked_days = array();
	
	$query = "	SELECT 
					(subcamp.start + day.day_offset) as day,
					subcamp.id
				FROM
					day,
					subcamp
				WHERE
					day.subcamp_id = subcamp.id AND
					subcamp.camp_id = " . $_camp->id;
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	while( $day = mysqli_fetch_assoc( $result ) )
	{
		if( !isset( $blocked_days[ $day['id'] ] ) )
		{	$blocked_days[ $day['id'] ] = array();	}
		
		$cdate->setDay2000( $day['day'] );
		array_push( $blocked_days[$day['id']], $cdate->getString( 'j n Y' ) );
	}
	
	$_js_env->add( 'blocked_days', $blocked_days );
