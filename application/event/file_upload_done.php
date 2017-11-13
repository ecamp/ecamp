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

	$file_type['image/jpeg'] = 'icon_img.png';
	$file_type['image/gif'] = 'icon_img.png';
	
	$file_type['application/pdf'] = 'icon_pdf.png';
	$file_type['application/msword'] = 'icon_doc.png';
	$file_type['application/vnd.ms-excel'] = 'icon_xls.png';

	$_page->html = new PHPTAL('template/application/event/file_upload_done.tpl');

	$event_id = mysql_real_escape_string( $_REQUEST['event_id'] );
	$file_id = mysql_real_escape_string( $_REQUEST['file_id'] );
	
	$_camp->event( $event_id ) || die( "error" );

	$query = "	SELECT 
					*
				FROM
					event_document
				WHERE
					event_document.id = " . $file_id;
	$result = mysql_query( $query );
	$file = mysql_fetch_assoc( $result );
	
	if( $file_type[$file['type']] )
	{	$file['type_img_src'] = "public/global/img/" . $file_type[$file['type']];	}
	else
	{	$file['type_img_src'] = "public/global/img/icon_unknown.png";	}
	
	$file['download_link'] = "index.php?app=event&cmd=file_download&file_id=" . $file['id'];

	$_page->html->set(	'file', $file );
	$_page->html->set(	'event_id',  $event_id );
	
	$_js_env->add(	'file', 	$file );
	//$_js_env->add(	'file_id', 	$file_id );
	$_js_env->add(	'event_id', $event_id );
?>