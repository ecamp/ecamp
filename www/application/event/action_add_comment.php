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

	$text = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['text']);
	$text_js = htmlentities_utf8($_REQUEST['text']);
	$text_js = preg_replace("/\n/", "<br/>", $text_js);
	
	$event_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['event_id']);
	
	$_camp->event($event_id) || die("error");

	if ($text == "")
	{	$ans = array("error" => true, "error_msg" => "Bitte zuerst ein Kommentar eingeben!"); }
	else
	{
		$query = "	INSERT INTO event_comment ( `event_id`, `user_id`, `t_created`, `text` )
					VALUES ( $event_id, $_user->id, ".time().", '$text' )";
		mysqli_query($GLOBALS["___mysqli_ston"], $query);
		
		$comment_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
		
		if (mysqli_error($GLOBALS["___mysqli_ston"]))
		{	$ans = array("error" => true, "error_msg" => "Kommentar konnte nicht hinzugefügt werden"); }
		else
		{
			$query = "	SELECT event_responsible.user_id, event.name
						FROM event_responsible, event
						WHERE event_id = event.id AND event.id = $event_id";
			$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
			
			while ($comment = mysqli_fetch_assoc($result))
			{
				$_news->add2user( 
					"Neuer Kommentar:",
					"Zu einem Block, für welchen du verantwortlich bist, wurde ein Kommentar abgegeben.<br /><br />
							Lager: $_camp->short_prefix $_camp->short_name <br />
							Block: ".$comment['name']."<br /><br />
							Kommentar: <br /><i>" . $text_js."</i>",
							time(),
							$comment['user_id']
				);
			}
			
			$ans = array("error" => false, "id" => $comment_id, "user" => htmlentities_utf8($_user->display_name), "date" => date("d.m.Y H:i"), "text" => $text_js);
		}
	}
	
	echo json_encode($ans);
	die();
