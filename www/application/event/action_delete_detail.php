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

	$event_detail_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['detail_id']);
	
	$_camp->event_detail($event_detail_id) || die("error");

	$query = "SELECT event_id, event_detail.sorting FROM event_detail WHERE event_detail.id = $event_detail_id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	$sorting = mysqli_result($result, 0, 'sorting');
	$event_id = mysqli_result($result, 0, 'event_id');
	
	$query = "
				DELETE FROM
					event_detail
				WHERE
					event_detail.id = $event_detail_id";
	mysqli_query($GLOBALS["___mysqli_ston"], $query);

	if (mysqli_affected_rows($GLOBALS["___mysqli_ston"]))
	{
		$query = "UPDATE event_detail SET sorting = sorting - 1 WHERE event_id = $event_id AND sorting > $sorting";
		mysqli_query($GLOBALS["___mysqli_ston"], $query);
		$ans = array("error" 	=> false);
	}
	else
	{	$ans = array("error" => true, "error_msg" => "Detail konnte nicht gelöscht werden"); }
	
	
	echo json_encode($ans);
	die();
