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
	
	class print_data_event_aim_class
	{
		public $pid;
		public $id;
		public $event_id;
		public $event;
		public $aim;

		function __construct( $data, $pid )
		{
			$this->pid			= $pid;
			$this->id 			= $data['id'];
			$this->event_id		= $data['event_id'];
			$this->aim 			= $data['aim'];
			
			$this->event 		= $pid->event[ $this->event_id ];
			
			$this->event->add_event_aim( $this );
		}
		
		
	}
	
?>