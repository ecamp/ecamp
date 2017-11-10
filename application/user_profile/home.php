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
	$_page->html->set('box_content', $GLOBALS['tpl_dir'].'/application/user_profile/home.tpl/home');
	$_page->html->set('box_title', 'Mein Profil');
	
	
	
	//  Geschlecht
	// ============
	$sex_content = array();
	$sex_selected = "false";
	$isset = 0;
	$query = "	SELECT 
					dropdown.*, 
					(
						SELECT 
							count(*) 
						FROM 
							user 
						WHERE 
							user.sex = dropdown.item_nr AND 
							user.id = '$_user->id'
					) as selected 
				FROM 
					dropdown, 
					user 
				WHERE 
					list = 'sex' AND 
					user.id = '$_user->id'";
	$result = mysql_query($query);
	while($row = mysql_fetch_assoc($result))
	{
		$sex_content[] = array
		(
			"value" 		=> $row['item_nr'],
			"content"		=> $row['entry'],
			"selected"		=> $row['selected']
		);
		
		if( $row['selected'] ){	$sex_selected = $row['item_nr'];	}
	}

	//  JS-Ausbildung
	// ===============
	$jsedu_content = array();
	$jsedu_selected = "false";
	$query = "	SELECT 
					dropdown.*, 
					(
						SELECT 
							count(*) 
						FROM 
							user 
						WHERE 
							user.jsedu = dropdown.item_nr AND 
							user.id = '$_user->id'
					) as selected 
				FROM 
					dropdown, 
					user 
				WHERE 
					list = 'jsedu' AND 
					user.id = '$_user->id'";
	$result = mysql_query($query);
	while($row = mysql_fetch_assoc($result))
	{	
		$jsedu_content[] = array
		(
			"value"		=> $row['item_nr'],
			"content"	=> $row['entry'],
			"selected"	=> $row['selected']
		);
		
		if( $row['selected'] )	{	$jsedu_selected = $row['item_nr'];	}
	}

	//  PBS-Ausbildung
	// ================
	$pbsedu_content = array();
	$pbsedu_selected = "false";
	$query = "SELECT * FROM dropdown WHERE list = 'pbsedu'";
	$query = "	SELECT 
					dropdown.*, 
					(
						SELECT 
							count(*) 
						FROM 
							user 
						WHERE 
							user.pbsedu = dropdown.item_nr AND 
							user.id = '$_user->id'
					) as selected 
				FROM 
					dropdown, 
					user 
				WHERE 
					list = 'pbsedu' AND 
					user.id = '$_user->id'";
	$result = mysql_query($query);
	while($row = mysql_fetch_assoc($result))
	{	
		$pbsedu_content[] = array
		(
			"value"		=> $row['item_nr'],
			"content"	=> $row['entry'],
			"selected"	=> $row['selected']
		);
		
		if( $row['selected'] )	{	$pbsedu_selected = $row['item_nr'];	}
	}

	$query = "SELECT * FROM user WHERE id = '$_user->id'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	
	$birthday = new c_date;
	$birthday->setDay2000($row['birthday']);

	$profile = array(
		"img_src" 	=> "index.php?app=user_profile&cmd=show_avatar&show_user_id=" . $_user->id,
		"scoutname" => array(	"name" => "scoutname", 	"value" => $row['scoutname']),
		"firstname" => array(	"name" => "firstname", 	"value" => $row['firstname']),
		"surname" 	=> array(	"name" => "surname", 	"value" => $row['surname']),
		"street" 	=> array(	"name" => "street", 	"value" => $row['street']),
		"zipcode" 	=> array(	"name" => "zipcode", 	"value" => $row['zipcode']),
		"city" 		=> array(	"name" => "city", 		"value" => $row['city']),
		"homenr" 	=> array(	"name" => "homenr", 	"value" => $row['homenr']),
		"mobilnr" 	=> array(	"name" => "mobilnr", 	"value" => $row['mobilnr']),
		"birthday" 	=> array(	"name" => "birthday", 	"value" => $birthday->getString("d.m.Y")),
		"ahv" 		=> array(	"name" => "ahv", 		"value" => $row['ahv']),
		"jspersnr"	=> array(	"name" => "jspersnr",	"value" => $row['jspersnr']),
		"sex"		=> array(	"name" => "sex",		"value"	=> $sex_content, 	"selected" => $sex_selected),
		"jsedu"		=> array(	"name" => "jsedu",		"value" => $jsedu_content,	"selected" => $jsedu_selected),
		"pbsedu"	=> array(	"name" => "pbsedu",		"value" => $pbsedu_content,	"selected" => $pbsedu_selected),
		"pw_change"	=> "",
		"avatar"	=> ""
	);

	$_page->html->set( 'profile', $profile );
	
	//print_r($profile);
?>