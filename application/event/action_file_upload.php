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

	$event_id = mysql_real_escape_string( $_REQUEST['event_id'] );
	$upload = $_FILES['upload'];
	
	$_camp->event( $event_id ) || die( "error" );

	$save_path = 'userfiles/event/' . $_user->id . '_' . md5( microtime(true) );
	$file_name = $upload['name'];
	
	if( $upload['error'] != 0 )
	{
		header( "location: index.php?app=event&cmd=file_upload_form&event_id=" . $event_id );
		die();
	}
	else
	{
		move_uploaded_file( $upload['tmp_name'], $save_path );
		
		$query = "	INSERT INTO
						event_document
					(
						`event_id`,
						`user_id`,
						`name`,
						`filename`,
						`type`,
						`size`,
						`time`
					)
					VALUES
					(
						'$event_id',
						'$_user->id',
						'$save_path',
						'$file_name',
						'" . $upload['type'] . "',
						'" . $upload['size'] . "',
						'" . time() . "'
					)";

		mysql_query( $query );
		$file_id = mysql_insert_id();
		
		header( "location: index.php?app=event&cmd=file_upload_done&event_id=" . $event_id ."&file_id=" . $file_id );
		die();
	}
