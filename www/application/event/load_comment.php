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

	$query = "	SELECT 
					user.scoutname,
					user.firstname,
					user.surname,
					event_comment.id,
					event_comment.t_created,
					event_comment.text
				FROM
					event_comment,
					user
				WHERE
					event_comment.user_id = user.id AND
					event_comment.event_id = $event_id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	$comments = array();
	
	while ($comment = mysqli_fetch_assoc($result))
	{
		if ($comment['scoutname'] == "")
		{	$comment['display_name'] = $comment['firstname']." ".$comment['surname']; }
		else
		{	$comment['display_name'] = $comment['scoutname']; }
		
		$comment['string_created'] = date('d.m.Y H:i', $comment['t_created']);
		
		$comments[] = $comment;
	}

	$_page->html->set('comments', $comments);
