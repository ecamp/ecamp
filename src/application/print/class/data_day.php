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

	class print_data_day_class
	{
		public $pid;
		public $id;
		public $subcamp_id;
		public $subcamp;
		public $day_nr;
		public $day_offset;
		public $date;
		public $story;
		public $notes;
		
		public $user_id;
		public $user;
		
		public $event_instance = array();
		public $job = array();
		
		public $linker;
		public $marker = 0;
		
		function __construct( $data, $pid )
		{
			$this->pid			= $pid;
			$this->id 			= $data['id'];
			$this->subcamp_id 	= $data['subcamp_id'];
			$this->day_nr	 	= $data['day_nr'];
			$this->day_offset	= $data['day_offset'];
			$this->date	 		= $data['date'];
			$this->story 		= $data['story'];
			$this->notes 		= $data['notes'];
			
			
			$this->user_id		= $data['user_id'];
			if( $this->user_id )
			{	$this->user = $pid->user[ $this->user_id ];	}
			
			$this->subcamp 		= $pid->subcamp[ $this->subcamp_id ];
			$this->subcamp->add_day( $this );
		}
		
		
		function add_event_instance( $event_instance )
		{	$this->event_instance[ $event_instance->id ] = $event_instance;	}
		
		
		function add_job( $job_day )
		{
			$job_day[ 'user' ] = $this->pid->user[ $job_day [ 'user_id' ] ];
			$this->job[ $job_day[ 'job_id' ] ] = $job_day;
		}
		
		
		function gen_event_nr()
		{
			$num = 1;
			
			foreach( $this->get_sorted_event_instance() as $event_instance )
			{
				if( $event_instance->event->category->form_type )
				{
					$event_instance->event_nr = $num;
					$num++;
				}
			}
		}
		
		
		function sort_event_nr( $event_instance1, $event_instance2 )
		{
			if( 	$event_instance1->starttime > $event_instance2->starttime )	{	return 1;	}
			elseif( $event_instance1->starttime < $event_instance2->starttime )	{	return -1;	}
			else
			{
				if( 	$event_instance1->dleft > $event_instance2->dleft )	{	return 1;	}
				elseif( $event_instance1->dleft < $event_instance2->dleft )	{	return -1;	}
				else
				{
					if(		$event_instance1->id > $event_instance2->id )	{	return 1;	}
					else													{	return -1;	}
				}
			}
		}
		
		
		function get_sorted_event_instance()
		{
			uasort( $this->event_instance, array( "print_data_day_class", "sort_event_nr" ) );
			return $this->event_instance;
		}
		
		
		function get_linker( $pdf )
		{
			if( ! $this->linker )
			{	$this->linker = $pdf->AddLink();	}
			
			return $this->linker;
		}
		
		function set_marker( $marker )
		{	$this->marker = $marker;	}
	}
	
?>