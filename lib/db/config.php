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

	$config = array(
		"camp" => array(
			"group_id" => "group",
			"creator_user_id" => "user"
		),
		
		"category" => array(
			"camp_id" => "camp"
		),
		
		"comment" => array(
			"event_id" => "event",
			"user_id" => "user"
		),
		
		"course_aim" => array(),
		
		"course_checklist" => array(),
		
		"course_type" => array(),
		
		"day" => array(
			"subcamp_id" => "subcamp"
		),
		
		"dropdown" => array(),
		
		"event" => array(
			"camp_id" => "camp",
			"category_id" => "category"
		),
		
		"event_aim" => array(
			"aim_id" => "course_aim",
			"event_id" => "event"
		),
		
		"event_checklist" => array(
			"checklist_id" => "course_checklist",
			"event_id" => "event"
		),
		
		"event_detail" => array(
			"event_id" => "event",
			"prev_id" => "event_detail"
		),
		
		"event_document" => array(
			"event_id" => "event",
			"user_id" => "user"
		),
		
		"event_instance" => array(
			"event_id" => "event",
			"day_id" => "day"
		),
		
		"event_responsible" => array(
			"event_id" => "event",
			"user_id" => "user"
		),
		
		"feedback" => array(),
		
		"groups" => array(
			"pid" => "groups"
		),
		
		"job" => array(
			"camp_id" => "camp"
		),
		
		"job_day" => array(
			"job_id" => "job",
			"day_id" => "day",
			"user_camp_id" => "user_camp"
		),
		
		"mat_article" => array(),
		
		"mat_article_alias" => array(
			"mat_article_id" => "mat_article"
		),
		
		"mat_available" => array(
			"event_id" => "event"
		),
		
		"mat_list" => array(
			"camp_id" => "camp"
		),
		
		"mat_organize" => array(
			"event_id" => "event",
			"user_id" => "user",
			"mat_buy_list_id" => "mat_buy_list",
			"mat_article_id" => "mat_article"
		),
		
		"subcamp" => array(
			"camp_id" => "camp"
		),
		
		"todo" => array(
			"camp_id" => "camp"
		),
		
		"todo_user_camp" => array(
			"todo_id" => "todo",
			"user_camp_id" => "user_camp"
		),
		
		"user" => array(),
		
		"user_camp" => array(
			"user_id" => "user",
			"camp_id" => "camp",
			"invitation_id" => "user"
		)
		
	);

	print_r( $config );
?>