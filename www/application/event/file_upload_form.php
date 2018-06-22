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

	$_page->html = new PHPTAL('template/application/event/file_upload_form.tpl');
	
	$event_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['event_id']);
	
	$_camp->event($event_id) || die("error");
	
	$query = "	SELECT
					*
				FROM
					event
				WHERE
					event.id = $event_id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	$event = mysqli_fetch_assoc($result);
	
	$_page->html->set('event', $event);
	