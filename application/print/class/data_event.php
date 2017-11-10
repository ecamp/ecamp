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

	
	class print_data_event_class
	{
		
		public $pid;
		public $id;
		public $camp_id;
		public $category_id;
		public $category;
		public $name;
		public $place;
		public $story;
		public $aim;
		public $method;
		public $topics;
		public $notes;
		public $seco;
		public $progress;
		
		public $event_detail = array();
		public $event_instance = array();
		public $event_responsible = array();
		public $mat_article = array();
		public $mat_available = array();
		public $mat_organize = array();
		public $event_checklist = array();
		public $event_aim = array();

		
		function print_data_event_class( $data, $pid )
		{
			$this->pid			= $pid;
			$this->id 			= $data['id'];
			$this->camp_id 		= $data['camp_id'];
			$this->category_id 	= $data['category_id'];
			$this->name 		= $data['name'];
			$this->place 		= $data['place'];
			$this->story 		= $data['story'];
			$this->aim 			= $data['aim'];
			$this->method 		= $data['method'];
			$this->topics 		= $data['topics'];
			$this->notes 		= $data['notes'];
			$this->seco 		= $data['seco'];
			$this->progress 	= $data['progress'];
			
			$this->category 	= $pid->category[ $this->category_id ];
			
			
		}
		
		function add_event_detail( $event_detail )
		{	$this->event_detail[ $event_detail->id ] = $event_detail;	}
		
		function add_event_instance( $event_instance )
		{	$this->event_instance[ $event_instance->id ] = $event_instance;	}
		
		function add_event_responsible( $event_responsible )
		{	$this->event_responsible[ $event_responsible->id ] = $event_responsible;	}
		
		function add_mat_available( $mat )
		{	$this->mat_available[ $mat->id ] = $mat;	}
		
		function add_mat_organize( $mat )
		{	$this->mat_organize[ $mat->id ] = $mat;		}
		
		function add_event_checklist( $checklist )
		{	$this->event_checklist[ $checklist->id ] = $checklist;	}
		
		function add_event_aim( $aim )
		{	$this->event_aim[ $aim->id ] = $aim;	}
	}
	
?>