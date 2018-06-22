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

	$event_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['event_id']);
	$aim = $_REQUEST['aim'];
	
	$_camp->event($event_id) || die("error");

	foreach ($aim as $aim_id => $checked)
	{
		$aim_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $aim_id);
		
		if ($checked == "true")
		{
			$query = " 	SELECT * FROM event_aim WHERE event_id = $event_id AND aim_id = $aim_id";
			$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
			
			if (!mysqli_num_rows($result))
			{
				$query = "	INSERT INTO event_aim ( `event_id`, `aim_id` ) VALUES ( '$event_id', '$aim_id' )";
				mysqli_query($GLOBALS["___mysqli_ston"], $query);
			}
		} else
		{
			$query = "	DELETE FROM event_aim WHERE event_id = $event_id AND aim_id = $aim_id";
			mysqli_query($GLOBALS["___mysqli_ston"], $query);
		}
	}
	
	echo json_encode(array("error" => false));
	
	die();
