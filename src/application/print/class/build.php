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

	require_once( 'build_cover.php' );
	require_once( 'build_picasso.php' );
	require_once( 'build_daylist.php' );
	require_once( 'build_day.php' );
	require_once( 'build_event.php' );
	require_once( 'build_toc.php' );
	require_once( 'build_notes.php' );

	class print_build_class
	{
		public $data;
		
		public $cover;
		public $picasso;
		public $day_list;
		public $day;
		public $event;
		public $toc;
		public $notes;
		
		function __construct( $data )
		{
			$this->data 	= $data;
			
			$this->cover 	= new print_build_cover_class( $this->data );
			$this->picasso	= new print_build_picasso_class( $this->data );
			$this->daylist	= new print_build_daylist_class( $this->data );
			$this->day		= new print_build_day_class( $this->data );
			$this->event	= new print_build_event_class( $this->data );
			$this->toc		= new print_build_toc();
			$this->notes    = new print_build_notes();
		}
	}
	
?>