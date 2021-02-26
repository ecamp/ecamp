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

	class print_data_subcamp_class
	{
		public $pid;
		public $id;
		public $camp_id;
		public $start;
		public $length;
		
		public $ustart;
		public $uend;
		
		public $day = array();
		
		
		function __construct($data, $pid)
		{
			$this->pid 			= $pid;
			$this->id 			= $data['id'];
			$this->camp_id		= $data['camp_id'];
			$this->start		= $data['start'];
			$this->length		= $data['length'];
			
			$c_date = new c_date();
			
			$this->ustart 	= $c_date->setDay2000( $this->start )->getUnix();
			$this->uend		= $c_date->setDay2000( $this->start + $this->length )->getUnix();
		}
		
		
		function add_day( $day )
		{	$this->day[ $day->id ] = $day;	}
		
		
		function get_day_by_nr( $day_nr )
		{
			foreach( $this->day as $day )
			{
				if( $day->day_offset + 1 == $day_nr )
				{	return $day;	}
			}
		}
		
		
		function sort_day( $day1, $day2 )
		{
			if( $day1->day_nr > $day2->day_nr )	{	return 1;	}
			else								{	return -1;	}
			
			return 0;
		}
		
		
		function get_sorted_day()
		{
			uasort( $this->day, array( "print_data_subcamp_class", "sort_day" ) );
			return $this->day;
		}
		
	}

?>