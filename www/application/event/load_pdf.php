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

	$query = "	SELECT
					*
				FROM
					event_document
				WHERE
					event_id = $event_id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	$documents = array();
	while ($document = mysqli_fetch_assoc($result))
	{
		if ($file_type[$document['type']])
		{	$document['type_img_src'] = "public/global/img/".$file_type[$document['type']]; }
		else
		{	$document['type_img_src'] = "public/global/img/icon_unknown.png"; }
		
		$document['download_link'] = "index.php?app=event&cmd=file_download&file_id=".$document['id'];
		
		$documents[] = $document;
	}

	$_page->html->set('documents', $documents);
	
	//print_r( $documents );
