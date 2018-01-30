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

	
	class print_build_picasso_class
	{
		public $data;
		public $orientation;
		
		public $ph;
		public $pw;
		
		function print_build_picasso_class( $data )
		{
			$this->data = $data;
			$this->orientation = 'L';
		}
		
		function set_orientation( $orientation = 'L' )
		{	$this->orientation = $orientation;	}
		
		function build( $pdf )
		{
			if( $this->orientation == 'L' )
			{	$this->ph = 210; 	$this->pw = 300;	}
			else
			{	$this->ph = 300;	$this->pw = 210;	}
			
			
			foreach( $this->data->subcamp as $subcamp )
			{
				
				$start_row 	= 1;
				$end_row	= $this->get_number_of_rows( $subcamp, 1 );
				
				for( $page = 1; $page <= $this->get_number_of_page( $subcamp ); $page++ )
				{
					$pdf->AddPage( $this->orientation, 'A4' );
					
					( $top_level_picasso != "printed" && $top_level_picasso = "printed" ) && $pdf->Bookmark( 'Picasso', 0, 0 );
										
					$this->title( $pdf );
					$this->background( $pdf );
					$this->category_list( $pdf );
					$this->page_content( $pdf, $subcamp, $start_row, $end_row );
					
					$start_row = $end_row + 1;
					$end_row += $this->get_number_of_rows( $subcamp, $page + 1 );
				}
				
			}
			
		}
		
		function get_number_of_page( $subcamp )
		{
			if( $this->orientation == 'L' )
			{	return ceil( count( $subcamp->day ) / 8 );	}
			else
			{	return ceil( count( $subcamp->day ) / 4 );	}
		}
		
		
		function get_number_of_rows( $subcamp, $page )
		{
			$rows = floor( count( $subcamp->day ) / $this->get_number_of_page( $subcamp ) );
			if( $page <= ( count( $subcamp->day ) % $this->get_number_of_page( $subcamp ) ) ){	$rows++;	}
			return $rows;
		}
		
		
		function title( $pdf )
		{
			$title = "Picasso - " . $this->data->camp->name;
			
			$pdf->SetFont('','B', 20); 
			$pdf->SetXY( 20, 12 );
			$pdf->drawTextBox( $title, $this->pw - 40, 10, 'C', 'M', 0 );
		}
		
		
		function category_list( $pdf )
		{
			$cat_num = count( $this->data->category );
			$rows = ( $cat_num > 5 ) ? 2 : 1;
			
			$row_num = floor( $cat_num / $rows ) + ( $cat_num % $rows );
			$row = 1;
			
			foreach( array_chunk( $this->data->category, $row_num, true ) as $row_cats )
			{
				$row_width = ( ($this->pw - 20) - ( count( $row_cats ) - 1 ) ) / count( $row_cats );
				$col = 1;
				
				foreach( $row_cats as $cat )
				{
					$x = 10 + ( $col - 1 ) * ( $row_width + 1 );
					$y = $this->ph - 19 + ( $row - 1 ) * 6;
					
					$color = $this->color( $cat->color );
					$pdf->SetFillColor( $color['r'], $color['g'], $color['b'] );
					
					$pdf->setAlpha( 0.75 );
					$pdf->RoundedRect( $x, $y, $row_width, 4, 2, '1111', 'FD' );
					$pdf->setAlpha( 1 );
					
					$pdf->SetXY( $x, $y );
					$pdf->drawTextBox( $cat->short_name . ": " . $cat->name, $row_width, 4, 'C', 'M', 0 );
					//$pdf->MultiCell( $row_width, 4, $cat->short_name . ": " . $cat->name, 0, 'C' );
					
					$col++;
				}
				
				$row++;
			}
		}
		
		
		function background( $pdf )
		{
			$pdf->SetFillColor( 200, 200, 200 );
			$pdf->SetFont('','', 8); 
			
			$baseh = ( $this->ph - 50 ) / 40;
			$yy = 30;
			
			for( $h = 0; $h < 24; $h+=2 )
			{
				if( $h < 2 )			{	$pdf->Rect( 10, $yy, $this->pw - 20, $baseh, 'F' );		$yy += 2 * $baseh;	}
				if( $h >= 2 && $h < 18 ){	$pdf->Rect( 10, $yy, $this->pw - 20, 2 * $baseh, 'F' );	$yy += 4 * $baseh;	}
				if( $h >= 18 )			{	$pdf->Rect( 10, $yy, $this->pw - 20, $baseh, 'F' );		$yy += 2 * $baseh;	}
			}
			
			for( $h = 0; $h < 40; $h++ )
			{
				if( $h < 2 )			{	$time = gmdate( 'H:i', ($h+5)*3600 ) . " - " . gmdate( 'H:i', ($h+5+1)*3600 );	}
				if( $h >= 2 && $h < 34 ){	$time = gmdate( 'H:i', ($h/2+1+5)*3600 ) . " - " . gmdate( 'H:i', ($h/2+1.5+5)*3600 );	}
				if( $h >= 34 )			{	$time = gmdate( 'H:i', ($h+8+5)*3600 ) . " - " . gmdate( 'H:i', ($h+9+5)*3600 );	}
				
				$pdf->SetXY( 10, 				30 + $h * $baseh );	$pdf->drawTextBox( $time, 20, $baseh, 'C', 'M', 0 );
				$pdf->SetXY( $this->pw - 30, 	30 + $h * $baseh );	$pdf->drawTextBox( $time, 20, $baseh, 'C', 'M', 0 );
			}

			
			$pdf->RoundedRect(  10, 			22, 20, 4, 2, '1001', '' );
			$pdf->RoundedRect( $this->pw - 30,	22, 20, 4, 2, '1001', '' );
			$pdf->RoundedRect(  10, 			26, 20, 4, 2, '0000', '' );
			$pdf->RoundedRect( $this->pw - 30,	26, 20, 4, 2, '0000', '' );
			
			$pdf->RoundedRect( 10,				30, 20, 			$this->ph - 50, 2, '0010', '' );
			$pdf->RoundedRect( $this->pw - 30,	30, 20, 			$this->ph - 50, 2, '0100', '' );
			$pdf->RoundedRect( 30, 				30, $this->pw - 60, $this->ph - 50, 2, '0000', '' );
			
			$pdf->SetXY(  10, 22 );				$pdf->drawTextBox( 'Zeit', 20, 4, 'C', 'M', 0 );
			$pdf->SetXY(  $this->pw - 30, 22 );	$pdf->drawTextBox( 'Zeit', 20, 4, 'C', 'M', 0 );
			
			$pdf->SetXY(  10, 26 );				$pdf->drawTextBox( $this->data->camp->job_name, 20, 4, 'C', 'M', 0 );
			$pdf->SetXY(  $this->pw - 30, 26 );	$pdf->drawTextBox( $this->data->camp->job_name, 20, 4, 'C', 'M', 0 );
		}
		
		
		function page_content( $pdf, $subcamp, $start_row, $end_row )
		{
			$date = new c_date();

			$num_row = $end_row - $start_row + 1;
			$row_width = ( $this->pw- 60 ) / $num_row;
			
			for( $row = $start_row; $row <= $end_row; $row++ )
			{
				$day = $subcamp->get_day_by_nr( $row );
				$day->gen_event_nr();
				
				$base_left = 30 + ( $row - $start_row ) * $row_width;
				$base_top = 30;
				
				$pdf->RoundedRect( $base_left, 22, $row_width, 4, 2, '1001', '' );
				$pdf->RoundedRect( $base_left, 26, $row_width, 4, 2, '0000', '' );
				
				$pdf->Link( $base_left, 22, $row_width, 4, $day->get_linker( $pdf ) );
				
				$date->setDay2000( $day->subcamp->start + $day->day_offset );
				$pdf->SetXY( $base_left, 22 );
				$pdf->SetFontSize( 8 );
				$pdf->drawTextBox( strtr( $date->getString( 'D, d.m.Y' ), $GLOBALS[en_to_de] ), $row_width, 4, 'C', 'M', 0 );
				
				if( $row % 2 )
				{
					$pdf->SetFillColor( 0, 0, 0 );
					$pdf->SetAlpha( 0.1 );
					
					$pdf->RoundedRect( $base_left, 30, $row_width, $this->ph - 50, 0, '0000', 'F' );
					
					$pdf->SetAlpha( 1 );
				}
				
				//	MAIN DAY-JOB
				if( $day->user )
				{
					$pdf->SetXY( $base_left, 26 );
					$pdf->SetFontSize( 8 );
					$pdf->drawTextBox( $day->user->get_name(), $row_width, 4, 'C', 'M', 0 );
				}
				
				foreach( $day->event_instance as $event_instance )
				{
					$m = 0.3;
					$p = 0.5;
					
					$s = $this->time_mm( $event_instance->starttime );
					$e = $this->time_mm( $event_instance->starttime + $event_instance->length );
					
					$x = $base_left + $row_width * $event_instance->dleft + $m;
					$y = $base_top + $s + $m;
					$w = $row_width * $event_instance->width - 2 * $m;
					$h = $e - $s - 2 * $m;
					
					$color = $this->color( $event_instance->event->category->color );
					$pdf->SetFillColor( $color['r'], $color['g'], $color['b'] );
					
					
					$pdf->SetAlpha( 0.85 );
					$pdf->RoundedRect( $x, $y, $w, $h, 1.5, '1111', 'FD' );
					$pdf->Link( $x, $y, $w, $h, $event_instance->get_linker( $pdf ) );
					$pdf->SetAlpha( 1 );
					
					
					$pdf->SetFontSize( 6 );
					$pdf->SetXY( $x + $p , $y + $p );
					
					if( $event_instance->event->category->form_type )
					{	$name = "(" . $day->day_nr . "." . $event_instance->event_nr . ") ";	}
					else	{	$name = "";	}
					
					if( $event_instance->event->category->short_name != "" )	
					{	$name .= $event_instance->event->category->short_name . ": ";	}
					
					$name .= $event_instance->event->name . "\n";
					
					if( $this->data->camp->is_course )
					{
						// ChkLst:
						$chklst = array();
						foreach( $event_instance->event->event_checklist as $chkpnt )
						{	$chklst[] = $chkpnt->short;	}
						
						if( count( $chklst ) )
						{	$name .= "[" . implode( "; ", $chklst ) . "]\n";	}
					}
					
					if( count( $event_instance->event->event_responsible ) )
					{
						$name .= "[";
						
						foreach( $event_instance->event->event_responsible as $user )
						{	$name .= $user->scoutname . "; ";	}
						$name = substr( $name, 0, -2 );
						
						$name .= "]";
					}
					
					$pdf->MultiCell( $w - 2 * $p, $h - 2 * $p, $name, 0, 'C' );
					
					$pdf->SetTextColor( 0, 0, 0 );
				}
			}
		}
		
		
		function time_mm( $time )
		{
			$time = $time - 300;
			if( $time < 0 ){	$time += 24*60;	}
			
			$baseh = ( $this->ph - 50 ) / 40;
			
			
			if( $time <= 120 )					{	return $time / 60 * $baseh;		}
			if( $time > 120 && $time < 1080 )	{	return ( $time / 30 - 2  ) * $baseh;	}
			if( $time >= 1080 )					{	return ( $time / 60 + 16 ) * $baseh;	}
			
		}
		
		
		function color( $color )
		{
			return array(
							"r" => hexdec( substr( $color, 0, 2 ) ),
							"g" => hexdec( substr( $color, 2, 2 ) ),
							"b" => hexdec( substr( $color, 4, 2 ) ),
						);
		}
		
		
	}
	
?>
