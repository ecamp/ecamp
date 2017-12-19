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

	class print_data_category_class
	{
		public $pid;
		public $id;
		public $camp_id;
		public $name;
		public $short_name;
		public $color;
		public $form_type;
		
		function print_data_category_class( $data, $pid )
		{
			$this->pid			= $pid;
			$this->id 			= $data['id'];
			$this->camp_id 		= $data['camp_id'];
			$this->name 		= $data['name'];
			$this->short_name 	= $data['short_name'];
			$this->color 		= $data['color'];
			$this->form_type 	= $data['form_type'];
		}
	}
