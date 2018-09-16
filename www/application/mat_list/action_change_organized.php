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

	$mat_event_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['mat_event_id']);
	$organized = ($_REQUEST['organized'] == "true");

	$query = "UPDATE mat_event SET organized = ".($organized ? 1 : 0).
			 " WHERE  mat_event.id = ".$mat_event_id;
	mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	echo $query;
	
	$ans = array("error" => false);
	echo json_encode($ans);
	die();
