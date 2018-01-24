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

	
	class print_data_camp_class
	{
		
		public $pid;
		public $id;
		public $name;
		public $short_name;
		public $group_name;
		public $slogan;
		public $type;
		public $is_course;
		public $ca_name;
		public $ca_street;
		public $ca_zipcode;
		public $ca_city;
		public $ca_tel;
		public $ca_coor;
		
		public $first_day;
		public $last_day;
		
		public $job_name;
		
		function print_data_camp_class( $data, $pid )
		{
			$this->pid 			= $pid;
			$this->id 			= $data['id'];
			$this->name 		= $data['name'];
			$this->short_name	= $data['short_name'];
			$this->group_name	= $data['group_name'];
			$this->slogan 		= $data['slogan'];
			$this->type 		= $data['type'];
			$this->is_course	= $data['is_course'];
			$this->ca_name 		= $data['ca_name'];
			$this->ca_street 	= $data['ca_street'];
			$this->ca_zipcode 	= $data['ca_zipcode'];
			$this->ca_city 		= $data['ca_city'];
			$this->ca_tel 		= $data['ca_tel'];
			$this->ca_coor 		= $data['ca_coor'];
			
			$this->first_day	= $data['first_day'];
			$this->last_day		= $data['last_day'];
			
			$this->job_name 	= $data['job_name'];
			
		}
	}
	
?>
