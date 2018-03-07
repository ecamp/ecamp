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


	class print_build_notes
	{
		function build( $pdf )
		{
			$pdf->AddPage('P', 'A4');
			$pdf->SetXY( 20, 12 );
			$pdf->SetFont('','B',20);
			$pdf->Cell( 170, 20, 'Notizen', 0, 1, 'C' );

			$pdf->SetLineWidth(0.75);
			$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'dash' => 3));

			// Linie zeichnen
			$pdf->Line(15, 50, 195, 50);
			$pdf->Line(15, 65, 195, 65);
			$pdf->Line(15, 80, 195, 80);
			$pdf->Line(15, 95, 195, 95);
			$pdf->Line(15, 110, 195, 110);
			$pdf->Line(15, 125, 195, 125);
			$pdf->Line(15, 140, 195, 140);
			$pdf->Line(15, 155, 195, 155);
			$pdf->Line(15, 170, 195, 170);
			$pdf->Line(15, 185, 195, 185);
			$pdf->Line(15, 200, 195, 200);
			$pdf->Line(15, 215, 195, 215);
			$pdf->Line(15, 230, 195, 230);
			$pdf->Line(15, 245, 195, 245);
			$pdf->Line(15, 260, 195, 260);

			$pdf->Bookmark( 'Notizen', 0, 0 );
		}
	}

?>