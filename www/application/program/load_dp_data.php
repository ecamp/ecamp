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

	$_page->html = new PHPTAL('template/application/program/dp_main.tpl');
	//$_page->html = new PHPTAL('template/global/main.tpl');
	
	$event_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['event_id']);
	$_page->html->set( 'event_id', $event_id );
	
	$_camp->event( $event_id ) || die( "error" );
	
//	NAME:
// =======
	$query = "	SELECT
					event.name,
					event.place,
					category.short_name
				FROM
					event,
					category
				WHERE
					event.id = $event_id AND
					event.category_id = category.id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	$row = mysqli_fetch_assoc($result);
	
	$_page->html->set( 'name', $row['short_name'] . ": " . $row['name'] );
	$event_place = $row['place'];
	
	//$data_left['name'] = gettemplate_app('dp_name', array(	"name" => $row['short_name'] . ": " . $row['name'] ) );
	
//	HEADER:
// =========
	$query = "	SELECT
					user.scoutname,
					user.firstname,
					user.surname
				FROM
					event_responsible,
					user
				WHERE
					event_responsible.event_id = $event_id AND
					event_responsible.user_id = user.id ";
	
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	$users = array();
	$dp_header = array( "users" => $users );
	
	while($row = mysqli_fetch_assoc($result))
	{
		if(!empty($row['scoutname']))
		{	array_push( $dp_header['users'], $row['scoutname'] );	}
		else
		{	array_push( $dp_header['users'], $row['firstname'] . " " . $row['surname'] );	}
	}
	
	$dp_header['place'] =  array(
		"value" 	=> $event_place,
		"event_id" 	=> $event_id,
		"script"	=> "action_change_place"
	);
	
	$query = "	SELECT
					event_instance.starttime,
					event_instance.length,
					day.day_offset + subcamp.start as startdate
				FROM
					event_instance,
					day,
					subcamp
				WHERE
					event_instance.event_id = $event_id AND
					event_instance.day_id = day.id AND
					day.subcamp_id = subcamp.id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	$date 	= new c_date;
	$start 	= new c_time;
	$end 	= new c_time;
	$dp_header['event_instance'] = array();
	while($row = mysqli_fetch_assoc( $result ) )
	{
		$date->setDay2000($row['startdate']);
		$start->setValue($row['starttime']);
		$end->setValue($row['starttime'] + $row['length']);
		
		$dp_header['event_instance'][] = array(
			'startdate' => date("d.m.Y", $date->getUnix()),
			'starttime' => $start->getString("H:i") . " - " . $end->getString("H:i")
		);
	}
	
	$_page->html->set( 'dp_header', $dp_header );
	
//	HEAD:
// =======
	$dp_head_show = array();
	$query = "	SELECT
					dropdown.value as form,
					(dropdown.value = category.form_type) as show_form
				FROM
					event,
					category,
					dropdown
				WHERE
					event.id = $event_id AND
					event.category_id = category.id AND
					dropdown.list = 'form'";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	while( $row = mysqli_fetch_assoc( $result ) )
	{	$dp_head_show[ $row['form'] ] = $row['show_form'];	}
	
	$_page->html->set( 'dp_head_show', $dp_head_show );
	
	$query = "	SELECT
					event.aim as aim,
					event.story as story,
					event.method as method,
					'true' as visible
				FROM
					event
				WHERE
					event.id = $event_id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	$replace = mysqli_fetch_assoc($result);
	
	$dp_head = array();
	
	$dp_head['aim'] = array(
		"value" => $replace['aim'],
		"script"	=> "action_save_change_aim",
		"event_id"	=> $event_id
	);
	$dp_head['story'] = array(
		"value" => $replace['story'],
		"script"	=> "action_save_change_story",
		"event_id"	=>	$event_id
	);
	$dp_head['method'] = array(
		"value" => $replace['method'],
		"script"	=> "action_save_change_method",
		"event_id"	=>	$event_id
	);
	$_page->html->set( 'dp_head', $dp_head );	
	
	echo $_page->html->execute();
	die();
	
//	Ablauf:
// =========
	$details = array();
	$query = "	SELECT
					time,
					content,
					resp,
					id
				FROM
					event_detail
				WHERE
					event_detail.event_id = $event_id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	while($row = mysqli_fetch_assoc($result))
	{
		foreach($row as $k => $v)
		{	$row[$k] = htmlentities($v);	}
		
		$row['time'] = gettemplate_app(
			'input_text', array(
				"value" => $row['time'],
			"cmd"	=> "action_save_change_detail_time",
			"event_id" => $row['id']
		));
		$row['content'] = gettemplate_app('input_textarea', array(
															"value" => $row['content'],
															"cmd"	=> "action_save_change_detail_content",
															"event_id" => $row['id']
														));
		$row['resp'] = gettemplate_app('input_text', array(
															"value" => $row['resp'],
															"cmd"	=> "action_save_change_detail_resp",
															"event_id" => $row['id']
														));
		
		array_push($details, gettemplate_app('dp_event_detail', $row));
	}
	
	$data_left['ablauf'] = gettemplate_app('dp_ablauf', array('ablauf' => implode("\n", $details)));
	
//	Material:
// ===========
		$mat_lists['buy'] = "";
		$mat_lists['stocked'] = "";
		$mat_lists['nonstocked'] = "";
		$leader_list = array();
		
		$query = "	SELECT
						user.id,
						user.scoutname,
						user.firstname,
						user.surname
					FROM
						user,
						user_camp
					WHERE
						user_camp.camp_id = $_camp->id AND
						user_camp.user_id = user.id";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
		
		while($row = mysqli_fetch_assoc($result))
		{
			if( !empty($row['scoutname']) )
			{	array_push($leader_list, "<option value='" . $row['id'] . "'>" . $row['scoutname'] . "</option>");	}
			else
			{	array_push($leader_list, "<option value='" . $row['id'] . "'>" . $row['firstname'] . " " . $row['surname'] . "</option>");	}
		}
		
	//	Buy:
	// ======
		$query = "	SELECT
						mat_article_event.quantity as quantity,
						mat_article_event.article_name as name,
						'' as who
					FROM
						mat_article_event
					WHERE
						mat_article_event.event_id = $event_id";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
		
		while($row = mysqli_fetch_assoc($result))
		{
			foreach($row as $k => $v)
			{	$row[$k] = htmlentities($v);	}
			
			$mat_lists['buy'] .= gettemplate_app('dp_mat_buy', $row);
		}
	
	//	Stocked:
	// ==========
		$query = "	SELECT
						mat_stuff.quantity as quantity,
						mat_stuff.name as name,
						mat_stuff.who as who
					FROM
						mat_stuff
					WHERE
						mat_stuff.event_id = $event_id AND
						mat_stuff.stocked = '1'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
		
		while($row = mysqli_fetch_assoc($result))
		{
			foreach($row as $k => $v)
			{	$row[$k] = htmlentities($v);	}
			
			$mat_lists['stocked'] .= gettemplate_app('dp_mat_stocked', $row);
		}
	
	//	NonStocked:
	// =============
		$query = "	SELECT
						mat_stuff.quantity as quantity,
						mat_stuff.name as name,
						mat_stuff.who as who
					FROM
						mat_stuff
					WHERE
						mat_stuff.event_id = $event_id AND
						mat_stuff.stocked = '0'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
		
		while($row = mysqli_fetch_assoc($result))
		{
			foreach($row as $k => $v)
			{	$row[$k] = htmlentities($v);	}
			
			$mat_lists['nonstocked'] .= gettemplate_app('dp_mat_nonstocked', $row);
		}
	
	$mat_lists['event_id'] = $event_id;
	$mat_lists['leader_list'] = implode( $leader_list );
	
	$data_right['mat'] = gettemplate_app('dp_mat_main', $mat_lists);
	
//	SiKo / Notice:
// ================
	$query = "	SELECT
					event.seco as siko_content,
					event.notes as notice,
					event.id
				FROM
					event
				WHERE
					event.id = $event_id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	$row = mysqli_fetch_assoc($result);
	
	$row['notice'] = gettemplate_app('input_textarea', array(
		"value" => $row['notice'],
		"cmd"	=> "action_save_change_notes",
		"event_id" => $row['id']
	));
	$row['siko_content'] = gettemplate_app('input_textarea', array(
		"value" => $row['siko_content'],
		"cmd"	=> "action_save_change_siko",
		"event_id" => $row['id']
	));
	
	$data_right['siko'] = gettemplate_app('dp_siko', $row);
	
//	PDF:
// ======
	$file_list = array();
	$query = "	SELECT
					user.scoutname,
					user.firstname,
					user.surname,
					user.id as user_id,
					event_document.name,
					event_document.filename,
					event_document.time
				FROM
					event_document,
					user
				WHERE
					event_document.event_id = $event_id AND
					event_document.user_id = user.id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	while($row = mysqli_fetch_assoc($result))
	{
		$row['scoutname'] = htmlentities($row['scoutname']);
		$row['firstname'] = htmlentities($row['firstname']);
		$row['surname'] 	= htmlentities($row['surname']);
		$row['name'] 		= htmlentities($row['name']);
		
		if(!empty($row['scoutname']))	{	$row['user'] = $row['scoutname'];	}
		else						{	$row['user'] = $row['firstname'] . " " . $row['surname'];	}
		
		array_push($file_list, gettemplate_app('dp_pdf_file', $row));
	}
	
	$data_right['pdf'] = gettemplate_app('dp_pdf_main', array("pdf" => implode("\n", $file_list)));
	
//	Kommentare:
// =============
	$comment_list = array();
	$query = "	SELECT
					user.scoutname,
					user.firstname,
					user.surname,
					user.id as user_id,
					comment.t_created as time,
					comment.text
				FROM
					comment,
					user
				WHERE
					comment.event_id = $event_id AND
					comment.user_id = user.id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	while($row = mysqli_fetch_assoc($result))
	{
		foreach($row as $k => $v)
		{	$row[$k] = htmlentities($v);	}
		
		if(!empty($row['scoutname']))	{	$row['user'] = $row['scoutname'];	}
		else						{	$row['user'] = $row['firstname'] . " " . $row['surname'];	}
		
		array_push($comment_list, gettemplate_app('dp_comment_entry', $row));
	}
	
	$data_right['comment'] = gettemplate_app('dp_comment_main', array("comment" => implode("\n", $comment_list)));	
	
	//$replace = array('data' => "<html><![CDATA[" . implode($data) . "<br />]]></html>", 'error'=> '0');
	
	//$xml = gettemplate_main( "ajax_response", $replace ); 
	
	header("Content-type: application/html");
    //echo $xml;
	echo gettemplate_app('dp_main', array("left" => implode($data_left), "right" => implode($data_right) ) );
	
	die();
	