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

	// Daten auslesen
	$pid  = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['pid']);
	$text = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['text']);
	$text_js = htmlentities_utf8($_REQUEST['text']);
	
	$id   = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['id']);
	
	$del   = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['del']);
	$new  = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['new']);
	$edit  = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['edit']);

	// Neues Ziel
	if( $new == 1  )
	{
		if( $pid == "" ) $pid = "NULL";
		
		$query = "INSERT INTO `course_aim` (`id` ,`pid` ,`camp_id` ,`aim` )
					VALUES (NULL , $pid , $_camp->id, '$text' );";
		mysqli_query($GLOBALS["___mysqli_ston"], $query);
		$id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
	}
	
	// Ziel löschen
	else if( $del == 1 )
	{
		$_camp->course_aim( $id ) || die( "error" );
		
		$query = "DELETE FROM course_aim WHERE id='$id' AND camp_id='$_camp->id' LIMIT 1;";
		mysqli_query($GLOBALS["___mysqli_ston"], $query);
	}
	
	// Ziel ändern
	else if( $edit == 1 )
	{
		$_camp->course_aim( $id ) || die( "error" );
		
		$query = "UPDATE course_aim SET aim='$text' WHERE id='$id' AND camp_id='$_camp->id' LIMIT 1;";
		mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	}
	
	// Fehler
	else
	{
		$error = true;
	}
	
	$ans = array( "error" => $error, "text" => $text_js, "pid" => $pid, "new" => $new, "id" => $id );
	echo json_encode($ans);
	die();
