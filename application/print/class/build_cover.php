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

	class print_build_cover_class
	{
		public $data;
		
		function print_build_cover_class( $data )
		{	$this->data = $data;	}
		
		function build( $pdf )
		{
			$pdf->AddPage('P', 'A4');
			
			$pdf->SetXY( 20, 30 );
			$pdf->SetFont('','B',20);
			$pdf->Cell( 170, 20, $this->data->camp->group_name, 0, 1, 'C' );
			
			$pdf->SetXY( 20, 40 );
			$pdf->SetFont('','B',30);
			$pdf->Cell( 170, 40, $this->data->camp->name, 0, 1, 'C' );
			
			$pdf->SetXY( 20, 65 );
			$pdf->SetFont('','B',40);
			$pdf->Cell( 170, 40, $this->data->camp->slogan, 0, 1, 'C' );

			//$url = 'http://map.search.ch/chmap.jpg?layer=sym,fg,copy&zd=2&w=1000&h=700&poi=verkehr,polizei,spital,apotheke,post,shop&base=';
			//$url .= strtr( $this->data->camp->ca_coor, array( "." => "", "/" => "," ) );
			
			//$pdf->Image( $url, 20, 130, 170, 0, 'jpeg' );	
			
			$pdf->Bookmark( 'Titelblatt', 0, 0 );
		}
	}
?>