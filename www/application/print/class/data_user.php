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

	
	class print_data_user_class
	{
		
		public $pid;
		public $id;
		public $scoutname;
		public $firstname;
		public $surname;
		public $street;
		public $zipcode;
		public $city;
		public $homenr;
		public $mobilnr;
		public $birthday;
		public $ahv;
		public $sex;
		public $jspersnr;
		public $jsedu;
		public $pbsedu;
		public $image;
		
		
		function print_data_user_class( $data, $pid )
		{
			$this->pid			= $pid;
			$this->id			= $data['id'];
			$this->scoutname 	= $data['scoutname'];
			$this->firstname 	= $data['firstname'];
			$this->surname 		= $data['surname'];
			$this->street 		= $data['street'];
			$this->zipcode 		= $data['zipcode'];
			$this->city 		= $data['city'];
			$this->homenr 		= $data['homenr'];
			$this->mobilnr 		= $data['mobilnr'];
			$this->birthday 	= $data['birthday'];
			$this->ahv 			= $data['ahv'];
			$this->sex 			= $data['sex'];
			$this->jspersnr 	= $data['jspersnr'];
			$this->jsedu 		= $data['jsedu'];
			$this->pbsedu 		= $data['pbsedu'];
			$this->image 		= $data['image'];
		}
		
		function get_name()
		{
			if( $this->scoutname )	{	return $this->scoutname;	}
			else					{	return $this->firstname . " " . $this->surname;	}
		}
		
	}
	
?>