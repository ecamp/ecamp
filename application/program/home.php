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


		
	$_page->html->set('main_macro', $GLOBALS[tpl_dir].'/global/content_box_full.tpl/predefine');
	$_page->html->set('box_content', $GLOBALS[tpl_dir].'/application/program/home.tpl/home');
	$_page->html->set('box_title', 'Grobprogramm');
	
	
	$_page->html->set( 'show_info_box', true );
	$_page->html->set( 'info_box', $GLOBALS[tpl_dir].'/module/info/info_box.tpl/info_box' );
	

	# Lagerstart, Lagerende und Lagerdauer
	##############################################
	
	$all_days_query = " SELECT day.id, day.day_offset, subcamp.start
						FROM day, subcamp
						WHERE 	day.subcamp_id = subcamp.id AND
								subcamp.camp_id = $_camp->id
						ORDER BY start ASC, day_offset ASC";
	
	$all_days_result = mysql_query($all_days_query);
		
	$events = "";
	$days = array();
	$day_nr = 0;
	
	while($day = mysql_fetch_assoc($all_days_result))
	{
		$leader_query = "	SELECT
								user_camp.user_id
							FROM
								job,
								job_day,
								user_camp
							WHERE
								job.show_gp = 1 AND
								job_day.day_id = " . $day[id] . " AND
								job_day.user_camp_id = user_camp.id AND
								job_day.job_id = job.id";
		$leader_result = mysql_query( $leader_query );
		
		if( mysql_num_rows( $leader_result ) )
		{	$leader = mysql_result( $leader_result, 'user_id', 0 );	}
		else
		{	$leader = "0";	}
		
		
		
		
		$day_nr++;
		
		$date = new c_date;
		$date->setDay2000($day[start] + $day[day_offset]);
		
		$days[] = array(
						"day_id" => $day[id],
						"day_id_string" => "day_id_" . $day[id],
						"style" => "left:" . $day_width*($day_nr - 1) . "px; width:" . $day_width . "px",
						"date" => strtr( $date->getString( 'D d.m.Y' ), $GLOBALS[en_to_de] ),
						"link" => "index.php?app=day&cmd=home&day_id=" . $day[id],
						"leader" => $leader,
						"class" => (($day_nr % 2) ? "bg1" : "bg2"),
						"body_class" => (($day_nr % 2) ? "bg1" : "bg2") . " day_body"
					);
	}
	
	$leaders = array();
	$all_leader_query = "	SELECT
								user.id,
								user.scoutname,
								user.firstname,
								user.surname
							FROM
								user,
								user_camp,
								dropdown
							WHERE
								user_camp.function_id = dropdown.id AND
								dropdown.entry != 'Support' AND
								user.id = user_camp.user_id AND
								user_camp.camp_id = $_camp->id";
	$all_leader_result = mysql_query( $all_leader_query );
	
	while( $leader = mysql_fetch_assoc( $all_leader_result ) )
	{
		$leaders[$leader['id']] = array(
											"value" => $leader['id'],
											"content" => $leader['scoutname'],
											"selected" => 0
										);
	}
	
	
		
	$query = "	SELECT job_name
				FROM job
				WHERE
					job.camp_id = $_camp->id AND
					job.show_gp = 1";
	$result = mysql_query( $query );
	
	if( mysql_num_rows( $result ) )
	{
		$main_job = mysql_result( $result, 'job_name', 0 );
		$_js_env->add( 'EnableMainJobResp', true );
	}
	else
	{
		$main_job = "Undefiniert";
		$_js_env->add( 'EnableMainJobResp', false );
	}

	
	
	$program = array(
						"days"			=>	$days,
						"show_width"	=>	"width:" . $day_width * $day_nr . "px",
						"day_width"		=>	$day_width,
						"leaders"		=> 	$leaders,
						"main_job"		=>	$main_job
					);
	$_page->html->set( "program", $program );
	
	include("module/info/category.php");
	

?>