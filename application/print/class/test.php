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

	// DO NOT INSERT THIS PART!!!
	//*******************************************************
	$GLOBALS['en_to_de'] = array(
		"Monday" 	=> "Montag",
		"Tuesday"	=> "Dienstag",
		"Wednesday"	=> "Mittwoch",
		"Thursday"	=> "Donnerstag",
		"Friday"	=> "Freitag",
		"Saturday"	=> "Samstag",
		"Sunday"	=> "Sonntag",
		
		"Mon"		=> "Mo",
		"Tue"		=> "Di",
		"Wed"		=> "Mi",
		"Thu"		=> "Do",
		"Fri"		=> "Fr",
		"Sat"		=> "Sa",
		"Sun"		=> "So",
		
		"January"	=> "Januar",
		"February"	=> "Februar",
		"March"		=> "März",
		"April"		=> "April",
		"May"		=> "Mai",
		"June"		=> "Juni",
		"July"		=> "Juli",
		"August"	=> "August",
		"September"	=> "September",
		"November"	=> "November",
		"December"	=> "Dezember"
	);
	
	require_once( '../../../lib/functions/date.php' );
	
	$GLOBALS['time_shift'] = 300;
	
	//*******************************************************
	mysql_connect( 'localhost' , 'root', '') or die(mysql_error());
	mysql_select_db( 'ecamp' ) or die(mysql_error());
	
	mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER SET 'utf8'");

	require_once( 'data.php' );
	require_once( 'build.php' );

	require_once( '../tcpdf/tcpdf.php' );
	require_once( '../tcpdf/tcpdf_addons.php' );

	$print_data = new print_data_class( 14 );	
	$print_build = new print_build_class( $print_data );

	//$pdf = new FPDF_ADDONS();
	$pdf = new TCPDF_ADDONS('P', 'mm', 'A4', true, 'UTF-8', false);
	$pdf->SetAutoPageBreak(true);

	$pdf->SetAuthor( 'ecamp2.pfadiluzern.ch' );
	$pdf->SetSubject( 'J&S - Programm' );
	$pdf->SetTitle( 'J&S - Programm' );

	$pdf->SetFont('helvetica','',12); 

	//$print_build->cover->build( $pdf );
	$print_build->picasso->build( $pdf );
	
	//$print_build->daylist->build( $pdf );
	/*
	$pdf->Bookmark( 'Tagesübersicht', 0, 0 );
	
	foreach( $print_build->data->get_sorted_day() as $day )
	{
		$pdf->SetY( $print_build->day->build( $pdf, $day ) );
		
		foreach( $day->get_sorted_event_instance() as $event_instance )
		{	$print_build->event->build( $pdf, $event_instance );	}
	}
	
	$print_build->toc->build( $pdf );
	*/
	
	
	/*
	$pdf->addPage();
	
	$pdf->writeHTMLCell( 100, 0 , 55, 50, 
					'asöldkjöalks jölkasjölkj <u>aölksjölkajö lkjöalksjdf</u> öl', 1, 1 );
					
	$pdf->write( 10, '----' );
	*/
	
	$pdf->output();
