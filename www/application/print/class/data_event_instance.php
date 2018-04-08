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

	
	class print_data_event_instance_class
	{
		
		public $pid;
		public $id;
		public $event_id;
		public $event;
		public $day_id;
		public $day;
		public $starttime;
		public $length;
		public $dleft;
		public $width;
		
		public $event_nr;
		
		public $linker;
		
		function print_data_event_instance_class( $data, $pid )
		{
			$this->pid			= $pid;
			$this->id 			= $data['id'];
			$this->event_id 	= $data['event_id'];
			$this->day_id 		= $data['day_id'];
			$this->length 		= $data['length'];
			$this->dleft 		= $data['dleft'];
			$this->width 		= $data['width'];
			
			$this->starttime 	= ( ( $data['starttime'] + 24*60 - $GLOBALS['time_shift'] ) % ( 24*60 ) ) + $GLOBALS['time_shift'];
			$this->length 		= min( $this->length, 24*60 + $GLOBALS['time_shift'] - $this->starttime );
			
			
			$this->event 		= $pid->event[ $this->event_id ];
			$this->day			= $pid->day[ $this->day_id ];
			
			# somewhere we have a bug that allows event_instances that link to events and days of different camps
			# this next line at least avoids crashing of the print functionality
			if( !is_null($this->day) && !is_null($this->event) ){
				$this->event->add_event_instance( $this );
				$this->day->add_event_instance( $this );
			}
			
			
		}
		
		function get_linker( $pdf )
		{
			if( ! $this->linker )
			{	$this->linker = $pdf->AddLink();	}
			
			return $this->linker;
		}
		
	}
	
?>