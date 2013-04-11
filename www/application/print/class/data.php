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

	require_once( 'data_user.php' );
	require_once( 'data_category.php' );
	require_once( 'data_camp.php' );
	require_once( 'data_subcamp.php' );
	require_once( 'data_day.php' );
	require_once( 'data_event.php' );
	require_once( 'data_event_instance.php' );
	require_once( 'data_event_detail.php' );
	require_once( 'data_event_aim.php' );
	require_once( 'data_event_checklist.php' );
	require_once( 'data_mat_list.php' );
	require_once( 'data_mat_event.php' );
	
	
	class print_data_class
	{
		public $camp_id;
		
		public $user = array();
		public $category = array();
		public $camp;
		public $subcamp = array();
		public $day = array();
		public $event = array();
		public $event_instance = array();
		
		public $mat_list = array();
		public $mat_event = array();
		/*
		public $mat_article_event = array();
		public $mat_stuff = array();
		*/
		
		function print_data_class( $camp_id )
		{
			$this->camp_id = $camp_id;
			$this->load_content();
		}
		
		
		function load_content()
		{
			$query = "SELECT user.* FROM user, user_camp WHERE user.id = user_camp.user_id AND user_camp.camp_id = " . $this->camp_id;
			$result = mysql_query( $query );
			while( $user = mysql_fetch_assoc( $result ) ){	$this->user[ $user['id'] ] = new print_data_user_class( $user, $this );	}
			
			$query = "SELECT * FROM category WHERE camp_id = " . $this->camp_id;
			$result = mysql_query( $query );
			while( $category = mysql_fetch_assoc( $result ) ){	$this->category[ $category['id'] ] = new print_data_category_class( $category, $this );	}
			
			$query = "SELECT *, MIN( subcamp.start ) as first_day, MAX( subcamp.start + subcamp.length - 1 ) as last_day, job.job_name FROM camp, subcamp, job WHERE camp.id = subcamp.camp_id AND camp.id = " . $this->camp_id . " AND job.camp_id = camp.id AND job.show_gp = 1 GROUP BY camp.id";
			$result = mysql_query( $query );
			$this->camp = new print_data_camp_class( mysql_fetch_assoc( $result ), $this );
			
			$query = "SELECT * FROM subcamp WHERE camp_id = " . $this->camp_id . " ORDER BY subcamp.start";
			$result = mysql_query( $query );
			while( $subcamp = mysql_fetch_assoc( $result ) ){	$this->subcamp[ $subcamp['id'] ] = new print_data_subcamp_class( $subcamp, $this ); }
			
			$query = "	SELECT
							day.*, 
							(
								SELECT
									IFNULL( sum( s.length ), 0 )
								FROM
									subcamp s
								WHERE
									s.camp_id = subcamp.camp_id AND
									s.start < subcamp.start
							) + day.day_offset + 1 as day_nr,
							(subcamp.start + day.day_offset) as date,
							job_day.user_id
						FROM 
							subcamp,
							day
						LEFT JOIN
							(
								SELECT
									user_camp.user_id,
									job_day.job_id,
									job_day.day_id
								FROM
									user_camp,
									job_day,
									job
								WHERE
									job_day.job_id = job.id AND
									job.show_gp = 1 AND
									job_day.user_camp_id = user_camp.id
							) as job_day 
						ON
							job_day.day_id = day.id
						WHERE 
							day.subcamp_id = subcamp.id AND 
							subcamp.camp_id = " . $this->camp_id;
			$result = mysql_query( $query );
			while( $day = mysql_fetch_assoc( $result ) ){	$this->day[ $day['id'] ] = new print_data_day_class( $day, $this );	}
			
			$query = "SELECT event.* FROM event WHERE camp_id = " . $this->camp_id;
			$result = mysql_query( $query );
			while( $event = mysql_fetch_assoc( $result ) ){	$this->event[ $event['id'] ] = new print_data_event_class( $event, $this );	}
			
			$query = "SELECT event_detail.* FROM event, event_detail WHERE event.id = event_detail.event_id AND event.camp_id = " . $this->camp_id . " ORDER BY sorting ASC";
			$result = mysql_query( $query );
			while( $event_detail = mysql_fetch_assoc( $result ) ){	$this->event_detail[ $event_detail['id'] ] = new print_data_event_detail_class( $event_detail, $this );	}
			
			
			
			$query = "SELECT event_instance.* FROM event, event_instance WHERE event.id = event_instance.event_id AND event.camp_id = " . $this->camp_id;
			$result = mysql_query( $query );
			while( $event_instance = mysql_fetch_assoc( $result ) ){	$this->event_instance[ $event_instance['id'] ] = new print_data_event_instance_class( $event_instance, $this );	}
			
			$query = "SELECT event_responsible.* FROM event, event_responsible WHERE event.id = event_responsible.event_id AND event.camp_id = " . $this->camp_id;
			$result = mysql_query( $query );
			while( $event_responsible = mysql_fetch_assoc( $result ) ){	$this->event[ $event_responsible[ 'event_id' ] ]->add_event_responsible( $this->user[ $event_responsible[ 'user_id' ] ] );	}
			
			
			$query = "SELECT event.id as event_id, course_aim.* FROM event_aim, course_aim, event WHERE event_aim.event_id = event.id AND event_aim.aim_id = course_aim.id AND event.camp_id = " . $this->camp_id;
			$result = mysql_query( $query );
			while( $course_aim = mysql_fetch_assoc( $result ) ){	$this->event_aim[ $course_aim[ 'id' ] ] = new print_data_event_aim_class( $course_aim, $this );	}
			
			$query = "SELECT event.id as event_id, course_checklist.* FROM event_checklist, course_checklist, event WHERE event_checklist.event_id = event.id AND event_checklist.checklist_id = course_checklist.id AND event.camp_id = " . $this->camp_id;
			$result = mysql_query( $query );
			while( $course_checklist = mysql_fetch_assoc( $result ) ){	$this->event_checklist[ $course_checklist[ 'id' ] ] = new print_data_event_checklist_class( $course_checklist, $this );	}
			
			
			$query = "SELECT mat_list.* FROM mat_list WHERE mat_list.camp_id = " . $this->camp_id;
			$result = mysql_query( $query );
			while( $mat_list = mysql_fetch_assoc( $result ) ){	$this->mat_list[ $mat_list[ 'id' ] ] = new print_data_mat_list( $mat_list, $this );	}
			
			$query = "SELECT user_camp.user_id, mat_event.* FROM event, mat_event LEFT JOIN user_camp ON user_camp.id = mat_event.user_camp_id WHERE mat_event.event_id = event.id AND event.camp_id = " . $this->camp_id;
			$result = mysql_query( $query );
			while( $mat_event = mysql_fetch_assoc( $result ) ){	$this->mat_event[ $mat_event[ 'id' ] ] = new print_data_mat_event( $mat_event, $this );	}
			
			$query = "
				SELECT 
					day.id as day_id,  
					job.id as job_id, 
					job.job_name, 
					user_camp.user_id
				FROM 
					
					(
						(
							(
								subcamp JOIN job ON job.camp_id = subcamp.camp_id
							) 
							JOIN day ON day.subcamp_id = subcamp.id
						)
						LEFT JOIN job_day ON job.id = job_day.job_id  AND day.id = job_day.day_id
					)
					LEFT JOIN user_camp ON user_camp.id=job_day.user_camp_id
					
				WHERE
					subcamp.camp_id = " . $this->camp_id;
					
			$result = mysql_query( $query );
			while( $job_day = mysql_fetch_assoc( $result ) ){	$this->day[ $job_day[ 'day_id' ] ]->add_job( $job_day );	}
		}
		
		
		function sort_day( $day1, $day2 )
		{
			if( $day1->subcamp->start + $day1->day_nr > $day2->subcamp->start + $day2->day_nr )	{	return 1;	}
			else																				{	return -1;	}
		}
		
		
		function get_sorted_day()
		{
			uasort( $this->day, array( "print_data_class", "sort_day" ) );
			return $this->day;
		}
		
	}	
	
?>