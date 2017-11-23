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

	//print_r( getimagesize('http://images.apple.com/aperture/tutorials/images/qt_endstate.jpg') );
	
	//die();
	
	include("fpdf/fpdf.php");
	include("fpdf/fpdf_addons.php");
	
	$pdf = new FPDF_ADDONS();
	
	$pdf->Open(); 
	
	// Erste Seite erstellen 
	$pdf->AddPage(); 
	
	// Bild einfügen (Position x = 0 / y = 0) 
	$pdf->Image('http://map.search.ch/chmap.jpg?layer=sym,fg,copy&zd=2&w=1000&h=700&poi=verkehr,polizei,spital,apotheke,post,shop&base=Udligenswil', 30, 25, 150, 0, 'jpeg' ); 
	
	$pdf->Output();
