<?php
/*
 * Copyright (C) 2013 Urban Suppiger, Pirmin Mattmann
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


  function getQueryEventNr($camp_id)
  {
	$query = "

	select 
		`event`.`id` AS `event_id`,
		`event_instance`.`id` AS `event_instance_id`,
		(
			(
				(
					select 
						ifnull(sum(`sub_subcamp`.`length`),0) AS `IFNULL( sum( sub_subcamp.length ), 0)` 
						from `subcamp` `sub_subcamp` 
						where 
						(
							(`subcamp`.`camp_id` = `sub_subcamp`.`camp_id`) 
							and 
							(`subcamp`.`start` > `sub_subcamp`.`start`)
						)
				) + `day`.`day_offset`
			) + 1
		) AS `day_nr`,
				
		(
			select 
				count(`event_instance_down`.`id`) AS `count(event_instance_down.id)` 
			from (((`event_instance` `event_instance_up` join `event_instance` `event_instance_down`) join `event`) join `category`) 
			where (
				(`event_instance_up`.`id` = `event_instance`.`id`) 
				and (`event_instance_up`.`day_id` = `event_instance_down`.`day_id`) 
				and (`event_instance_down`.`event_id` = `event`.`id`) 
				and (`event`.`category_id` = `category`.`id`) 
				and (`category`.`form_type` > 0) 
				and (
						(`event_instance_down`.`starttime` < `event_instance_up`.`starttime`) or 
						(
							(`event_instance_down`.`starttime` = `event_instance_up`.`starttime`) and 
							(
								(`event_instance_down`.`dleft` < `event_instance_up`.`dleft`) or 
								(
									(`event_instance_down`.`dleft` = `event_instance_up`.`dleft`) and 
									(`event_instance_down`.`id` <= `event_instance_up`.`id`)
								)
							)
						)
					)
			)
		) AS `event_nr`
		
	from (
	((`event_instance` join `event`) join `day`) join `subcamp`) 

	where (
		(`event`.`id` = `event_instance`.`event_id`) 
		and (`event_instance`.`day_id` = `day`.`id`) 
		and (`day`.`subcamp_id` = `subcamp`.`id`)
		and subcamp.camp_id=$camp_id
	)
	";
  	return $query;
  }


?>