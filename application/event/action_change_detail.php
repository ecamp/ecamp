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

	//index.php?app=event&cmd=action_change_detail& time=time&content=content&resp=who&detail_id=2
	
	$event_detail_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['detail_id'] );
	
	$_camp->event_detail( $event_detail_id ) || die( "error" );
	
	$time = 	mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['time'] );
	$content = 	mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['content'] );
	$resp = 	mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['resp'] );
	
	$time_js = 	$_REQUEST['time'];
	$content_js = 	$_REQUEST['content'];
	$resp_js = 	$_REQUEST['resp'];
	
	$query = "
				UPDATE
					event_detail
				SET
					time 	= '$time',
					content = '$content',
					resp 	= '$resp'
				WHERE
					event_detail.id = $event_detail_id";
	mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	$ans = array( 
		"error" 	=> false,
		"time" 		=> $time_js,
		"content" 	=> $content_js,
		"resp" 		=> $resp_js
	);
	echo json_encode( $ans );
	die();
