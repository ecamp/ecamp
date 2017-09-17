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

	
	class print_build_day_class
	{
		public $data;
		public $y;
		
		
		function __construct($data )
		{
			$this->data = $data;
		}
		
		function build( $pdf, $day )
		{
			$pdf->AddPage( 'P', 'A4' );
			
			$this->title( $pdf, $day );
			$this->joblist( $pdf, $day );
			$this->event_list( $pdf, $day );
			$this->story( $pdf, $day );
			$this->notes( $pdf, $day );
			$this->marker( $pdf, $day );
			
			return $this->y + 5;
		}
		
		function title( $pdf, $day )
		{
			$pdf->SetLink( $day->get_linker( $pdf ) );
			$date = new c_date();		$date->setDay2000( $day->date );
			
			$pdf->SetFillColor( 200, 200, 200 );
			$pdf->SetDrawColor( 0, 0, 0 );
			
			$pdf->RoundedRect( 10, 15, 190, 30, 5, '1111', 'DF' );
			
			$pdf->SetXY( 10, 15 );
			$pdf->SetFont( '', 'B', 30 );
			
			
			$pdf->drawTextBox( strtr( $date->getString( 'D, d.m.Y' ), $GLOBALS[en_to_de] ), 190, 15, 'C', 'M', 0 );
			
			$pdf->SetFont( '', 'B', 20 );
			$pdf->drawTextBox( 'Tagesübersicht:', 190, 10, 'C', 'M', 0 );
			
			
			$pdf->Bookmark( strtr( $date->getString( 'D, d.m.Y' ), $GLOBALS[en_to_de] ), 1, 0 );
		}
		
		function joblist( $pdf, $day )
		{
			$this->y = 55;

			$job_num = count( $day->job );
			$row_num = ceil( $job_num / 4 );
			
			$row = 1;
			$col = 1;
			
			foreach( $day->job as $job )
			{
				
				$col_num = floor( $job_num / $row_num );
				if( $job_num % $row_num != 0 && $job_num % $row_num >= $row ){	$col_num++;	}
				
				//
				$w = ( 191 - $col_num ) / $col_num;
				$x = 10 + ( 1 + $w ) * ( $col - 1 );
				$y = $this->y + 9 * ( $row - 1 );
				
				//print_r( $job );
				
				//
				$pdf->RoundedRect( $x, $y, $w, 4, 2, '1001', 'DF' );
				$pdf->RoundedRect( $x, $y+4, $w, 4, 2, '0110', 'D' );
				
				$pdf->SetFont( '', 'B', 8 );
				$pdf->SetXY( $x, $y );
				$pdf->drawTextBox( $job['job_name'], $w, 4, 'C', 'M', 0 );
				
				if( $job['user'] )
				{
					$pdf->SetFont( '', '', 8 );
					$pdf->SetXY( $x, $y + 4 );
					$pdf->drawTextBox( $job['user']->get_name(), $w, 4, 'C', 'M', 0 );
				}
				
				$col++;
				if( $col > $col_num ){	$col = 1; $row++;	}
				
			}
			
			
			$this->y += $row_num * 9 + 10;
			
			//$this->y = 70;
		}
		
		function event_list( $pdf, $day )
		{
			//	Tabellenkopf:
			// ===============
			
			$pdf->SetFont( '', 'B', 8 );
			
			$pdf->SetXY( 12, $this->y );
			$pdf->drawTextBox( 'Zeit:', 38, 4, 'L', 'T', 0 );
			
			$pdf->SetXY( 52, $this->y );
			$pdf->drawTextBox( 'Blockbezeichnung:', 68, 4, 'L', 'T', 0 );
			
			$pdf->SetXY( 132, $this->y );
			$pdf->drawTextBox( 'Verantwortliche/r', 68, 4, 'L', 'T', 0 );
			
			$this->y += 4;
			$pdf->Line( 10, $this->y, 190, $this->y );
			
			$this->y += 2;
			
			
			
			//	Tablleninhalt:
			// ================
			
			$s_time = new c_time();
			$e_time = new c_time();
			
			$day->gen_event_nr();
			
			foreach( $day->get_sorted_event_instance() as $event_instance )
			{
				if( $event_instance->event->category->form_type )	{	$pdf->SetFont( '', 'B', 8 );	}
				else												{	$pdf->SetFont( '', '', 8 );		}
				
				$s_time->setValue( $event_instance->starttime );
				$e_time->setValue( $event_instance->starttime + $event_instance->length );
				
				$time  = $s_time->getString( 'H:i' ) . " - " . $e_time->getString( 'H:i' );
				
				
				$name = "";
				if( $event_instance->event->category->form_type )
				{	$name .= "(" . $day->day_nr . "." . $event_instance->event_nr . ") ";	}
				
				if( $event_instance->event->category->short_name != "" )
				{	$name .= $event_instance->event->category->short_name . ": ";	}
				
				$name .= $event_instance->event->name;
				
				
				$resp = "";
				foreach( $event_instance->event->event_responsible as $event_responsible )
				{	$resp .= $event_responsible->scoutname . ", ";	}
				$resp = substr( $resp, 0, -2 );
				
				$pdf->SetXY( 12, $this->y );
				$pdf->Cell( 38, 4, $time, 0, 0, 'L', 0, $event_instance->get_linker( $pdf ) );
				//$pdf->drawTextBox( $time, 38, 4, 'L', 'T', 0 );
				
				$pdf->SetXY( 52, $this->y );
				$pdf->Cell( 68, 4, $name, 0, 0, 'L', 0, $event_instance->get_linker( $pdf ) );
				//$pdf->drawTextBox( $name, 68, 4, 'L', 'T', 0 );
				
				$pdf->SetXY( 132, $this->y );
				$pdf->Cell( 68, 4, $resp, 0, 0, 'L', 0, $event_instance->get_linker( $pdf ) );
				//$pdf->drawTextBox( $resp, 68, 4, 'L', 'T', 0 );
				
				$this->y += 4;
				
			}
			
			$this->y += 10;
		}
		
		function story( $pdf, $day )
		{
			$pdf->SetFont( '', 'B', 8 );
			
			$pdf->RoundedRect( 10, $this->y, 190, 4, 2, '1001', 'DF' );
			$pdf->SetXY( 10, $this->y );
			$pdf->drawTextBox( 'Roter Faden:', 190, 4, 'L', 'M', 0 );
			
			$this->y += 4;
			
			$pdf->SetFont( '', '', 8 );
			$pdf->SetXY( 10, $this->y );
			$pdf->MultiCell( 190, 4, $day->story, 0, 'L', 0, 1 );
			
			$ey = $pdf->GetY();
			$pdf->RoundedRect( 10, $this->y, 190, $ey - $this->y, 2, '0110', 'D' );
			
			$this->y = $ey + 3;
		}
		
		function notes( $pdf, $day )
		{
			$pdf->SetFont( '', 'B', 8 );
			
			$pdf->RoundedRect( 10, $this->y, 190, 4, 2, '1001', 'DF' );
			$pdf->SetXY( 10, $this->y );
			$pdf->drawTextBox( 'Notizen:', 190, 4, 'L', 'M', 0 );
			
			$this->y += 4;
			
			$pdf->SetFont( '', '', 8 );
			$pdf->SetXY( 10, $this->y );
			$pdf->MultiCell( 190, 4, $day->notes, 0, 'L', 0, 1 );
			
			$ey = $pdf->GetY();
			$pdf->RoundedRect( 10, $this->y, 190, $ey - $this->y, 2, '0110', 'D' );
			
			$this->y = $ey + 3;
		}
		
		function marker( $pdf, $day )
		{
			$c_date = new c_date();
			
			if( !$day->marker ){	return; }
			
			$pdf->SetFillColor( 0, 0, 0 );
					
			$pdf->RoundedRect( 0,   $day->marker + 0.3, 6, 7.4, 0, '0000', 'F' );
			$pdf->RoundedRect( 204, $day->marker + 0.3, 6, 7.4, 0, '0000', 'F' );
			
			$pdf->Link( 0,   $day->marker + 0.3, 6, 7.4, $day->linker );
			$pdf->Link( 204, $day->marker + 0.3, 6, 7.4, $day->linker );
			
			$pdf->SetFont( '', 'B', 8 );
			$pdf->SetTextColor( 255, 255, 255 );
			$day_str = strtr( $c_date->setDay2000( $day->date )->getString('D'), $GLOBALS[en_to_de] );
			$pdf->SetXY( 0, $day->marker );
			$pdf->drawTextBox( $day_str, 6, 8, 'C', 'M', 0 );
			$pdf->SetXY( 204, $day->marker );
			$pdf->drawTextBox( $day_str, 6, 8, 'C', 'M', 0 );
			
			
			$pdf->SetTextColor( 0, 0, 0 );			
		}
	}
	
?>