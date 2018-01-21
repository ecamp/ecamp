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

	$event_id 	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['event_id'] );
	$comment_id	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST['comment_id'] );
	
	$_camp->event( $event_id ) || die( "error" );

	$query = "	DELETE FROM event_comment 
				WHERE id = $comment_id AND event_id = $event_id";
	mysqli_query($GLOBALS["___mysqli_ston"],  $query );

	if( mysqli_error($GLOBALS["___mysqli_ston"]) )
	{	$ans = array( "error" => true, "error_msg" => "Kommentar konnte nicht gelöscht weren." );	}
	else
	{	$ans = array( "error" => false );	}
	
	echo json_encode( $ans );
	die();
