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

	
	class print_build_toc
	{
		public $page = array();
		public $countoffset = 1;
		
		function print_build_toc()
		{}
		
		function addTOC( $pdf )
		{
			$this->page[] = $pdf->PageNo();
		}
		
		function build( $pdf )
		{
			if( count( $this->page ) )
			{
				foreach( $this->page as $nr )
				{
					$tocsnr = $pdf->PageNo();
					
					$pdf->addPage( 'P', 'A4');
					$pdf->setXY( 10, 20 );
					$pdf->addToc( $nr + $this->countoffset );
					
					$tocenr = $pdf->PageNO();
					
					$this->countoffset += ( $tocenr - $tocsnr );
				}
			}
		}
	}
	
?>