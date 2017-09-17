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

	
	class print_data_mat_list
	{
		
		public $pid;
		public $id;
		public $camp_id;
		public $camp;
		public $name;
		
		
		function __construct($data,$pid )
		{
			$this->pid			= $pid;
			$this->id			= $data['id'];
			$this->camp_id 		= $data['camp_id'];
			$this->name			= $data['name'];
			
			$this->camp = $pid->camp;
		}
		
	}
	
?>