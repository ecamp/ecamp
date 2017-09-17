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

	
	if( !isset( $_REQUEST['item'] ) )
	{	header( "location: index.php?app=print" );	die();	}
	else
	{
		$items = $_REQUEST['item'];
		$conf  = $_REQUEST['conf'];
	}
	
	ini_set("memory_limit","64M");
	
	require_once( 'class/data.php' );
	require_once( 'class/build.php' );

	
	require_once( 'tcpdf/tcpdf.php' );
	require_once( 'tcpdf/tcpdf_addons.php' );
	require_once( 'FPDI/fpdi.php' );
	
	
	$print_data = new print_data_class( $_camp->id );	
	$print_build = new print_build_class( $print_data );
	
	
	
	$pdf = new FPDI('P', 'mm', 'A4', true, 'UTF-8', false);
	$pdf->SetAutoPageBreak(true);
	
	$pdf->SetAuthor( 'ecamp2.pfadiluzern.ch' );
	$pdf->SetSubject( 'J&S - Programm' );
	$pdf->SetTitle( 'J&S - Programm' );
	
	
	
	foreach( $items as $nr => $item )
	{
		if( $item == "title" )
		{	$print_build->cover->build( $pdf );	}
		
		if( $item == "picasso" )
		{
			$print_build->picasso->set_orientation( $conf[$nr] );
			$print_build->picasso->build( $pdf );
		}
		
		if( $item == "allevents" )
		{
			if( $conf[$nr] == "true" )
			{	$print_build->daylist->build( $pdf );	}
			
			foreach( $print_build->data->get_sorted_day() as $day )
			{
				$pdf->SetY( $print_build->day->build( $pdf, $day ) );
				
				foreach( $day->get_sorted_event_instance() as $event_instance )
				{	$print_build->event->build( $pdf, $event_instance );	}
			}
		}
		
		if( $item == "event" )
		{
			$event_instance_id = $conf[$nr]['event_instance'];
			
			$_camp->event_instance( $event_instance_id ) || die( "error" );
			
			
			if( $conf[$nr]['dayoverview'] == "true" )
			{	$print_build->day->build( $pdf, $print_build->data->event_instance[ $event_instance_id ]->day );	}
			else
			{	$pdf->addPage('P', 'A4');	}
			
			
			$print_build->data->event_instance[ $event_instance_id ]->day->gen_event_nr();
			$print_build->event->build( $pdf, $print_build->data->event_instance[ $event_instance_id ] );
		}
		
		if( $item == "toc" )
		{	$print_build->toc->addTOC( $pdf );	}
		
		if( $item == "pdf" )
		{
			$file = $_FILES[$conf[$nr]];
			
			$page_nr = $pdf->setSourceFile( $file['tmp_name'] );
			
			for( $i = 1; $i <= $page_nr; $i++ )
			{
				$tplidx = $pdf->ImportPage( $i );
				$s = $pdf->getTemplatesize($tplidx); 
				
				$pdf->AddPage( 'P', array($s['w'], $s['h']) );
				$pdf->useTemplate( $tplidx );
			}
			//$pdf->setPageFormat( 'A4', 'P' );
		}
	}
	
	
	$print_build->toc->build( $pdf );
	
	
	
	$pdf->output( $_camp->short_name . ".pdf", 'I' );

	
	die();
	
	
	
?>