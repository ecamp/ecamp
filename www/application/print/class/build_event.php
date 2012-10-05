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

	
	class print_build_event_class
	{
		public $data;
		public $y;
		
		function print_build_event_class( $data )
		{
			$this->data = $data;
		}
		
		
		
		function build_h( $pdf, $event_instance )
		{
			$return = 0;
			
			$return += $this->title_h( $pdf, $event_instance );
			
			if( $event_instance->event->category->form_type == 1 )	{	$return += $this->ls_header_h( $pdf, $event_instance);	}
			if( $event_instance->event->category->form_type == 2 )	{	$return += $this->la_header_h( $pdf, $event_instance);	}
			if( $event_instance->event->category->form_type == 3 )	{	$return += $this->lp_header_h( $pdf, $event_instance);	}
			if( $event_instance->event->category->form_type == 4 )	{	$return += $this->ka_header_h( $pdf, $event_instance);	}
			
			$return += $this->ablauf_h( $pdf, $event_instance );
			$return += $this->material_h( $pdf, $event_instance );
			
			$return += $this->siko_h( $pdf, $event_instance );
			$return += $this->notes_h( $pdf, $event_instance );
			
			return $return;
		}
		
		function build( $pdf, $event_instance )
		{
			$pdf->SetAutoPageBreak(false);

			if( ! $event_instance->event->category->form_type )	{	return;	}
			
			
			$this->y = $pdf->getY();
			
			if( $this->build_h( $pdf, $event_instance ) > ( 310 - $this->y ) && $this->y > 150 )
			{	$pdf->addPage('P', 'A4');	$this->y = 15;	}
			else
			{	$this->y += 10;	}
			
			
			
			$this->build_assi( $pdf, $event_instance, 'title', 'title_h' );
			
			
			if( $event_instance->event->category->form_type == 1 )	{	$this->build_assi( $pdf, $event_instance, 'ls_header', 'ls_header_h');	}
			if( $event_instance->event->category->form_type == 2 )	{	$this->build_assi( $pdf, $event_instance, 'la_header', 'la_header_h');	}
			if( $event_instance->event->category->form_type == 3 )	{	$this->build_assi( $pdf, $event_instance, 'lp_header', 'lp_header_h');	}
			if( $event_instance->event->category->form_type == 4 )	{	$this->build_assi( $pdf, $event_instance, 'ka_header', 'ka_header_h');	}
			
			
			$this->build_assi( $pdf, $event_instance, 'ablauf', 'ablauf_h' );
			$this->build_assi( $pdf, $event_instance, 'material', 'material_h' );
			
			
			$this->build_assi( $pdf, $event_instance, 'siko', 'siko_h' );
			$this->build_assi( $pdf, $event_instance, 'notes', 'notes_h' );
			
			$this->marker( $pdf, $event_instance );
			
			$pdf->SetAutoPageBreak(true);

			
			$pdf->setY( $this->y );
			return $this->y;
		}
		
		function build_assi( $pdf, $event_instance, $build_func, $h_func )
		{
			
			if( $this->y + $this->$h_func( $pdf, $event_instance ) < 282 )
			{	$this->$build_func( $pdf, $event_instance );	}
			else
			{
				$pdf->addPage('P', 'A4');
				$this->y = 15;
				$this->$build_func( $pdf, $event_instance );
			}
		}
		
		function title_h( $pdf, $event_instance )
		{	return 17;	}
		
		function title( $pdf, $event_instance )
		{
			$pdf->SetLink( $event_instance->get_linker( $pdf ), $this->y );
			$color = $this->color( $event_instance->event->category->color );
			
			
			$pdf->SetLineWidth( 0.5 );
			$pdf->SetFillColor( $color['r'], $color['g'], $color['b'] );
			$pdf->RoundedRect( 10, $this->y, 190, 17, 5, '1001', 'DF' );
			$pdf->SetLineWidth( 0.2 );
			
			
			$pdf->SetXY( 15, $this->y + 1 );
			$pdf->SetFont( '', 'B', 30 );
			
			$name = "(" . $event_instance->day->day_nr . "." . $event_instance->event_nr . ") ";
			$name.= $event_instance->event->category->short_name . ": ";
			$name.= $event_instance->event->name;
			
			$name_width = $pdf->GetStringWidth( $name );
			if( $name_width > 120 )
			{
				$name_font_size = max( 15, 30 * 120 / $name_width );
				$pdf->SetFont( '', 'B', $name_font_size );
				
				//$name_dy = ( 30 - $name_font_size ) / 4;
				//$pdf->SetXY( 15, $this->y + $name_dy );
			}
			$pdf->MultiCell( 130, 30, $name, '', 'L' );
			
			
			$pdf->SetFont( '', 'B', 10 );
			
			
			$date = new c_date();
			$date->SetDay2000( $event_instance->day->subcamp->start + $event_instance->day->day_nr - 1 );
			
			$timestart = new c_time();
			$timestart->SetValue( $event_instance->starttime );
			$timeend = new c_time();
			$timeend->SetValue( $event_instance->endtime );
			
			
			$pdf->SetXY( 155, $this->y + 1 );
			$pdf->drawTextBox( 'Datum:', 15, 5, 'L', 'M', 0 );
			$pdf->SetXY( 170, $this->y + 1 );
			$pdf->drawTextBox( strtr( $date->getString( 'D d.m.Y' ), $GLOBALS[en_to_de] ), 30, 5, 'L', 'M', 0 );
			$pdf->Link( 170, $this->y + 1, 30, 5, $event_instance->day->get_linker( $pdf ) );
			
			
			$pdf->SetXY( 155, $this->y + 6 );
			$pdf->drawTextBox( 'Zeit:', 15, 5, 'L', 'M', 0 );
			$pdf->SetXY( 170, $this->y + 6 );
			$pdf->drawTextBox( $timestart->getString( 'H:i' ) . " - ". $timeend->getString( 'H:i' ), 30, 5, 'L', 'M', 0 );
			
			
			$pdf->SetXY( 155, $this->y + 11 );
			$pdf->drawTextBox( 'Ort:', 15, 5, 'L', 'M', 0 );
			$pdf->SetXY( 170, $this->y + 11 );
			$pdf->drawTextBox( $event_instance->event->place, 30, 5, 'L', 'M', 0 );
			
			
			$pdf->Bookmark( $name, 2, $this->y );
			
			//$this->y += 22;
			$this->y += 17;
			
		}
		
		
		function ls_header_h( $pdf, $event_instance )
		{
			$wl = 120;
			$wr = 70;
			
			$num_line_story = $pdf->getNumLines( $event_instance->event->story, $wl );
			$num_line_aim	= $pdf->getNumLines( $event_instance->event->aim, $wl );
			$num_line_resp	= $pdf->getNumLines( $resp, $wr );
			
			$lh = 2 + ( 2 + $num_line_story + $num_line_aim ) * 5;
			$rh = 1 + ( 1 + $num_line_resp ) * 5;
			$h = max( $lh, $rh );
			
			return $h;
		}
		
		function ls_header( $pdf, $event_instance )
		{
			$wl = 120;
			$wr = 70;
			
			foreach( $event_instance->event->event_responsible as $event_responsible )
			{
				if( is_object( $event_responsible ) )
				{	$resp .= $event_responsible->get_name() . ", ";	}
			}
			$resp = substr( $resp, 0, -2 );
			
			
			$num_line_story = $pdf->getNumLines( $event_instance->event->story, $wl );
			$num_line_aim	= $pdf->getNumLines( $event_instance->event->aim, $wl );
			$num_line_resp	= $pdf->getNumLines( $resp, $wr );
			
			
			$lh = 2 + ( 2 + $num_line_story + $num_line_aim ) * 5;
			$rh = 1 + ( 1 + $num_line_resp ) * 5;
			$h = max( $lh, $rh );
			
			$h_story	= ( $num_line_story / ( $num_line_story + $num_line_aim ) ) * ( $h - 10 );
			$h_aim		= ( $num_line_aim / ( $num_line_story + $num_line_aim ) ) * ( $h - 10 );
			$h_resp		= $h - 5;
			
			
			
			$pdf->SetFillColor( 200, 200, 200 );
			
			$pdf->RoundedRect( 10, $this->y, $wl, 5, 2, '0000', 'DF' );
			$pdf->RoundedRect( 10 + $wl, $this->y, $wr, 5, 2, '0000', 'DF' );
			$pdf->RoundedRect( 10, $this->y + 5 + $h_story, $wl, 5, 2, '0000', 'DF' );
			
			$pdf->RoundedRect( 10, $this->y + 5, $wl, $h_story, 2, '0000', 'D' );
			$pdf->RoundedRect( 10, $this->y + 10 + $h_story, $wl, $h_aim, 2, '0000', 'D' );
			$pdf->RoundedRect( 10 + $wl, $this->y + 5, $wr, $h_resp, 2, '0000', 'D' );
			
			$pdf->SetLineWidth( 0.5 );
			$pdf->RoundedRect( 10, $this->y, $wl + $wr, 5 + $h_resp, 2, '0000', 'D' );
			$pdf->SetLineWidth( 0.2 );
			
			$pdf->SetFont( '', 'B', 10 );
			
			$pdf->SetXY( 10, $this->y );
			$pdf->drawTextBox( 'Roter Faden: ', $wl, 5, 'L', 'M', 0 );
			
			$pdf->SetXY( 10, $this->y + 5 + $h_story );
			$pdf->drawTextBox( 'Ziele: ' , $wl, 5, 'L', 'M', 0 );
			
			$pdf->SetXY( 10 + $wl, $this->y );
			$pdf->drawTextBox( 'Verantwortliche/r: ', $wr, 5, 'L', 'M', 0 );
			
			
			
			$pdf->SetFont( '', '', 10 );
			
			$pdf->SetXY( 10, $this->y + 5 );
			$pdf->MultiCell( $wl, $h_story, $event_instance->event->story, '', 'L' );
			
			$pdf->SetXY( 10, $this->y + 10 + $h_story );
			$pdf->MultiCell( $wl, $h_aim, $event_instance->event->aim, '', 'L' );
			
			$pdf->SetXY( 10 + $wl, $this->y + 5 );
			$pdf->MultiCell( $wr, $h_resp, $resp, '', 'L' );
			
			
			
			$this->y += $h;
		}
		
		
		function la_header_h( $pdf, $event_instnace )
		{
			$wl = 120;
			$wr = 70;
			
			$num_line_story = $pdf->getNumLines( $event_instance->event->story, $wl );
			$num_line_aim	= $pdf->getNumLines( $event_instance->event->aim, $wl );
			$num_line_resp	= $pdf->getNumLines( $resp, $wr );
			$num_line_method= $pdf->getNumLines( $event_instance->event->method, $wr );
			
			
			$lh = 2 + ( 2 + $num_line_story + $num_line_aim ) * 5;
			$rh = 2 + ( 2 + $num_line_resp + $num_line_method ) * 5;
			$h = max( $lh, $rh );
			
			return $h;
		}
		
		function la_header( $pdf, $event_instance )
		{
			$wl = 120;
			$wr = 70;
			
			foreach( $event_instance->event->event_responsible as $event_responsible )
			{
				if( is_object( $event_responsible ) )
				{	$resp .= $event_responsible->get_name() . ", ";	}
			}
			$resp = substr( $resp, 0, -2 );
			
			
			$num_line_story = $pdf->getNumLines( $event_instance->event->story, $wl );
			$num_line_aim	= $pdf->getNumLines( $event_instance->event->aim, $wl );
			$num_line_resp	= $pdf->getNumLines( $resp, $wr );
			$num_line_method= $pdf->getNumLines( $event_instance->event->method, $wr );
			
			
			$lh = 2 + ( 2 + $num_line_story + $num_line_aim ) * 5;
			$rh = 2 + ( 2 + $num_line_resp + $num_line_method ) * 5;
			$h = max( $lh, $rh );
			
			$h_story	= ( $num_line_story / ( $num_line_story + $num_line_aim ) ) * ( $h - 10 );
			$h_aim		= ( $num_line_aim / ( $num_line_story + $num_line_aim ) ) * ( $h - 10 );
			$h_resp		= ( $num_line_resp / ( $num_line_resp + $num_line_method ) ) * ( $h - 10 );
			$h_method	= ( $num_line_method / ( $num_line_resp + $num_line_method ) ) * ( $h - 10 );
			
			
			
			$pdf->SetFillColor( 200, 200, 200 );
			
			$pdf->RoundedRect( 10, $this->y, $wl, 5, 2, '0000', 'DF' );
			$pdf->RoundedRect( 10 + $wl, $this->y, $wr, 5, 2, '0000', 'DF' );
			$pdf->RoundedRect( 10, $this->y + 5 + $h_story, $wl, 5, 2, '0000', 'DF' );
			$pdf->RoundedRect( 10 + $wl, $this->y + 5 + $h_resp, $wr, 5, 2, '0000', 'DF' );
			
			$pdf->RoundedRect( 10, $this->y + 5, $wl, $h_story, 2, '0000', 'D' );
			$pdf->RoundedRect( 10 + $wl, $this->y + 5, $wr, $h_resp, 2, '0000', 'D' );
			$pdf->RoundedRect( 10, $this->y + 10 + $h_story, $wl, $h_aim, 2, '0000', 'D' );
			$pdf->RoundedRect( 10 + $wl, $this->y + 10 + $h_resp, $wr, $h_method, 2, '0000', 'D' );
			
			
			$pdf->SetLineWidth( 0.5 );
			$pdf->RoundedRect( 10, $this->y, $wl + $wr, $h, 2, '0000', 'D' );
			$pdf->SetLineWidth( 0.2 );
			
			
			$pdf->SetFont( '', 'B', 10 );
			
			$pdf->SetXY( 10, $this->y );
			$pdf->drawTextBox( 'Roter Faden: ', $wl, 5, 'L', 'M', 0 );
			
			$pdf->SetXY( 10, $this->y + 5 + $h_story );
			$pdf->drawTextBox( 'Ziele: ' , $wl, 5, 'L', 'M', 0 );
			
			$pdf->SetXY( 10 + $wl, $this->y );
			$pdf->drawTextBox( 'Verantwortliche/r: ', $wr, 5, 'L', 'M', 0 );
			
			$pdf->SetXY( 10 + $wl, $this->y + 5 + $h_resp );
			$pdf->drawTextBox( 'Methode:', $wr, 5, 'L', 'M', 0 );
			
			
			
			$pdf->SetFont( '', '', 10 );
			
			$pdf->SetXY( 10, $this->y + 5 );
			$pdf->MultiCell( $wl, $h_story, $event_instance->event->story, '', 'L' );
			
			$pdf->SetXY( 10, $this->y + 10 + $h_story );
			$pdf->MultiCell( $wl, $h_aim, $event_instance->event->aim, '', 'L' );
			
			$pdf->SetXY( 10 + $wl, $this->y + 5 );
			$pdf->MultiCell( $wr, $h_resp, $resp, '', 'L' );
			
			$pdf->SetXY( 10 + $wl, $this->y + 10 + $h_resp );
			$pdf->MultiCell( $wr, $h_method, $event_instance->event->method, '', 'L' );
			
			
			
			$this->y += $h;
		}
		
		
		function lp_header_h( $pdf, $event_instance )
		{	return $this->ls_header_h( $pdf, $event_instance );	}
		
		function lp_header( $pdf, $event_instance )
		{
			$this->ls_header( $pdf, $event_instance );
		}
		
		
		function ka_header_h( $pdf, $event_instance )
		{
			$wl = 120;
			$wr = 70;
			
			$num_line_topics = $pdf->getNumLines( $event_instance->event->topics, $wl );
			$num_line_aim	 = $pdf->getNumLines( $event_instance->event->aim, $wl );
			$num_line_resp	 = $pdf->getNumLines( $resp, $wr );
			
			$num_line_event_aim 		= 0;
			$num_line_event_checklist 	= 0;
			
			foreach( $event_instance->event->event_aim as $aim )
			{	$num_line_event_aim += $pdf->getNumLines( $aim->aim, 95 );	}
			
			foreach( $event_instance->event->event_checklist as $checklist )
			{	$num_line_event_checklist += $pdf->getNumLines( $checklist->name, 95 );	}
			
			
			$lh = 2 + ( 2 + $num_line_topics + $num_line_aim ) * 5;
			$rh = 1 + ( 1 + $num_line_resp ) * 5;
			$h = max( $lh, $rh );
			
			$h += 5 * max( $num_line_event_aim, $num_line_event_checklist ) + 5;
			
			return $h;
		}
		
		function ka_header( $pdf, $event_instance )
		{
			$wl = 120;
			$wr = 70;
			
			foreach( $event_instance->event->event_responsible as $event_responsible )
			{	$resp .= $event_responsible->get_name() . ", ";	}
			$resp = substr( $resp, 0, -2 );
			
			
			$num_line_aim	 = $pdf->getNumLines( $event_instance->event->aim, $wl );
			$num_line_topics = $pdf->getNumLines( $event_instance->event->topics, $wl );
			$num_line_resp	 = $pdf->getNumLines( $resp, $wr );
			
			foreach( $event_instance->event->event_aim as $aim )
			{	$num_line_event_aim += $pdf->getNumLines( $aim->aim, 95 );	}
			
			foreach( $event_instance->event->event_checklist as $checklist )
			{	$num_line_event_checklist += $pdf->getNumLines( $checklist->name, 95 );	}
			
			
			
			$lh = 2 + ( 2 + $num_line_topics + $num_line_aim ) * 5;
			$rh = 1 + ( 1 + $num_line_resp ) * 5;
			$h = max( $lh, $rh );
			
			
			$h_topics	= ( $num_line_topics / ( $num_line_topics + $num_line_aim ) ) * ( $h - 10 );
			$h_aim		= ( $num_line_aim / ( $num_line_topics + $num_line_aim ) ) * ( $h - 10 );
			$h_resp		= $h - 5;
			
			$h_event_aim 		= max( 10, 5 * ( 1 + $num_line_event_aim ) );
			$h_event_checklist 	= max( 10, 5 * ( 1 + $num_line_event_checklist ) );
			
			$h_list = max( $h_event_aim, $h_event_checklist );
			$h += $h_list;
			
			
			$pdf->SetFillColor( 200, 200, 200 );
			
			$pdf->RoundedRect( 10, $this->y, $wl, 5, 2, '0000', 'DF' );
			$pdf->RoundedRect( 10 + $wl, $this->y, $wr, 5, 2, '0000', 'DF' );
			$pdf->RoundedRect( 10, $this->y + 5 + $h_aim, $wl, 5, 2, '0000', 'DF' );
			
			$pdf->RoundedRect( 10, $this->y + 5 + $h_resp, 95, 5, 2, '0000', 'DF' );
			$pdf->RoundedRect( 105, $this->y + 5 + $h_resp, 95, 5, 2, '0000', 'DF' );
			
			
			$pdf->RoundedRect( 10, $this->y + 5, $wl, $h_aim, 2, '0000', 'D' );
			$pdf->RoundedRect( 10, $this->y + 10 + $h_aim, $wl, $h_topics, 2, '0000', 'D' );
			$pdf->RoundedRect( 10 + $wl, $this->y + 5, $wr, $h_resp, 2, '0000', 'D' );
			
			$pdf->RoundedRect( 10, $this->y + 10 + $h_resp, 95, $h_list, 2, '0000', 'D' );
			$pdf->RoundedRect( 105, $this->y + 10 + $h_resp, 95, $h_list, 2, '0000', 'D' );
			
			
			$pdf->SetLineWidth( 0.5 );
			$pdf->RoundedRect( 10, $this->y, $wl + $wr, $h, 2, '0000', 'D' );
			$pdf->SetLineWidth( 0.2 );
			
			$pdf->SetFont( '', 'B', 10 );
			
			$pdf->SetXY( 10, $this->y );
			$pdf->drawTextBox( 'Blockziele: ', $wl, 5, 'L', 'M', 0 );
			
			$pdf->SetXY( 10, $this->y + 5 + $h_aim );
			$pdf->drawTextBox( 'Blockinhalte: ' , $wl, 5, 'L', 'M', 0 );
			
			$pdf->SetXY( 10 + $wl, $this->y );
			$pdf->drawTextBox( 'Verantwortliche/r: ', $wr, 5, 'L', 'M', 0 );
			
			$pdf->SetXY( 10, $this->y + 5 + $h_resp );
			$pdf->drawTextBox( 'Ausbildungsziele: ', $wr, 5, 'L', 'M', 0 );
			
			$pdf->SetXY( 105, $this->y + 5 + $h_resp );
			$pdf->drawTextBox( 'Checkliste J+S/PBS: ', $wr, 5, 'L', 'M', 0 );
			
			
			
			$aim_text = "";
			$checklist_text = "";
			
			foreach( $event_instance->event->event_aim as $aim )
			{	$aim_text .= "=> " . $aim->aim . "\r\n";	}
			
			foreach( $event_instance->event->event_checklist as $checklist )
			{	$checklist_text .= $checklist->short . ": " . $checklist->name . "\r\n";	}
			
			
			$pdf->SetFont( '', '', 10 );
			
			$pdf->SetXY( 10, $this->y + 5 );
			$pdf->MultiCell( $wl, $h_aim, $event_instance->event->aim, '', 'L' );
			
			$pdf->SetXY( 10, $this->y + 10 + $h_aim );
			$pdf->MultiCell( $wl, $h_topics, $event_instance->event->topics, '', 'L' );
			
			$pdf->SetXY( 10 + $wl, $this->y + 5 );
			$pdf->MultiCell( $wr, $h_resp, $resp, '', 'L' );
			
			$pdf->SetXY( 10, $this->y + 10 + $h_resp );
			$pdf->MultiCell( 95, $h_list, $aim_text, '', 'L' );
			
			$pdf->SetXY( 105, $this->y + 10 + $h_resp );
			$pdf->MultiCell( 95, $h_list, $checklist_text, '', 'L' );
			
			
			$this->y += $h;
		}
		
		
		function ablauf_h( $pdf, $event_instance )
		{
			$return = 0;
			
			/*
			foreach( $event_instance->event->event_detail as $event_detail )
			{
				$num_line_time 		= $pdf->getNumLines( $event_detail->time, 20 );
				$num_line_content	= $pdf->getNumLines( $event_detail->content, 130 );
				$num_line_resp		= $pdf->getNumLines( $event_detail->resp, 40 );
				
				$return += 2 + max( $num_line_time, $num_line_content, $num_line_resp, 1 ) * 5;
			}
			$return = max( $return, 5 );
			*/
			
			$event_detail = reset( $event_instance->event->event_detail );
			
			$num_line_time 		= $pdf->getNumLines( $event_detail->time, 20 );
			$num_line_content	= $pdf->getNumLines( $event_detail->content, 130 );
			$num_line_resp		= $pdf->getNumLines( $event_detail->resp, 40 );
			
			$return = 7 + max( $num_line_time, $num_line_content, $num_line_resp, 1 ) * 5;
			return $return;
		}
		
		function ablauf( $pdf, $event_instance )
		{
			$pdf->SetFillColor( 200, 200, 200 );
			$pdf->SetFont( '', 'B', 10 );
			
			$pdf->RoundedRect( 10, $this->y, 20, 5, 2, '0000', 'DF' );
			$pdf->RoundedRect( 30, $this->y, 130, 5, 2, '0000', 'DF' );
			$pdf->RoundedRect( 160, $this->y, 40, 5, 2, '0000', 'DF' );
			
			$pdf->SetXY( 10, $this->y );
			$pdf->drawTextBox( 'Zeit:', 20, 5, 'L', 'M', 0 );
			
			$pdf->SetXY( 30, $this->y );
			//$pdf->writeHTMLCell( 130, 0, 30, $this->y, 'Ablauf', 0, 1, 0, true, 'L' );
			$pdf->drawTextBox( 'Ablauf:', 130, 5, 'L', 'M', 0 );
			
			$pdf->SetXY( 160, $this->y );
			$pdf->drawTextBox( 'Verantwortlich: ', 40, 5, 'L', 'M', 0 );
			
			$this->y += 5;
			
				
			$pdf->SetFont( '', '', 10 );
			$start_y = $this->y;
			$start_b = $start_y - 5;
			$border_h = 5;
			
			foreach( $event_instance->event->event_detail as $event_detail )
			{
				$num_line_time 		= $pdf->getNumLines( $event_detail->time, 20 );
				$num_line_content	= $pdf->getNumLines( $event_detail->content, 130 );
				$num_line_resp		= $pdf->getNumLines( $event_detail->resp, 40 );
				
				$h = max( $num_line_time, $num_line_content, $num_line_resp, 1 ) * 5;
				
				if( $h + $this->y > 282 )
				{
					$hh = max( $this->y - $start_y, 5 );
					$pdf->RoundedRect( 10, $start_y, 20, $hh, 2, '0000', 'D' );
					$pdf->RoundedRect( 30, $start_y, 130, $hh, 2, '0000', 'D' );
					$pdf->RoundedRect( 160, $start_y, 40, $hh, 2, '0000', 'D' );
					
					$pdf->SetLineWidth( 0.5 );
					$pdf->RoundedRect( 10, $start_b, 190, $hh + $border_h, 2, '0000', 'D' );
					$pdf->SetLineWidth( 0.2 );
					
					$pdf->addPage();
					$this->y = 15;
					$start_y = 15;
					$start_b = 15;
					$border_h = 0;
				}
				
				$pdf->SetXY( 10, $this->y );
				$pdf->MultiCell( 20, $num_line_time * 5, $event_detail->time, '', 'L' );
				$time_h = $pdf->GetY() - $this->y;
				
				
				$pdf->SetXY( 30, $this->y );
				$pdf->MultiCell( 130, $h, $event_detail->content, '', 'L' );
				//$pdf->writeHTMLCell( 130, 0, 30, $this->y, trim( $event_detail->content ), 0, 1, 0, true, 'L' );
				$content_h = $pdf->GetY() - $this->y;
				
				
				$pdf->SetXY( 160, $this->y );
				$pdf->MultiCell( 40, $num_line_resp * 5, $event_detail->resp, '', 'L' );
				$resp_h = $pdf->GetY() - $this->y;
				
				$this->y += max( $time_h, $content_h, $resp_h ) + 2;
			}
			
			$hh = max( $this->y - $start_y, 5 );
			
			$pdf->RoundedRect( 10, $start_y, 20, $hh, 2, '0000', 'D' );
			$pdf->RoundedRect( 30, $start_y, 130, $hh, 2, '0000', 'D' );
			$pdf->RoundedRect( 160, $start_y, 40, $hh, 2, '0000', 'D' );
			
			
			$pdf->SetLineWidth( 0.5 );
			$pdf->RoundedRect( 10, $start_b, 190, $hh + $border_h, 2, '0000', 'D' );
			$pdf->SetLineWidth( 0.2 );
			
			
			$this->y = $start_y + $hh;
		}
		
		
		
		function material_h( $pdf, $event_instance )
		{
			$lines1 = 0;
			
			foreach( $event_instance->event->mat_available as $mat_available )
			{
				$a = $pdf->getNumLines( $mat_available->quantity, 15);
				$b = $pdf->getNumLines( $mat_available->article_name, 59);
			
				$lines1 += max($a,$b);
			}
				
				
			$lines2 = 0;
			foreach( $event_instance->event->mat_organize as $mat_organize )
			{
				$a = $pdf->getNumLines( $mat_organize->quantity, 15);
				$b = $pdf->getNumLines( $mat_organize->article_name, 60);
					
				if( $mat_organize->resp == "user" )
				{
					$c = $pdf->getNumLines( $mat_organize->user->get_name(), 39);
				}
				if( $mat_organize->resp == "mat_list" )
				{
					$c = $pdf->getNumLines( $mat_organize->mat_list->name, 39);
				}
				
				$lines2 += max($a,$b,$c);
			}
			
			$lines = max( $lines1, $lines2, 1);
			
			return $lines * 5 + 7;
		}
		
		function material( $pdf, $event_instance )
		{
			$max_h = 5;
			
			$pdf->SetFillColor( 200, 200, 200 );
			$pdf->SetFont( '', 'B', 10 );
			
			$w1 = 75;
			$w2 = 115; 
			
			$pdf->RoundedRect( 10, $this->y, $w1, 5, 2, '0000', 'DF' );
			$pdf->RoundedRect( 10 + $w1, $this->y, $w2, 5, 2, '0000', 'DF' );
			
			$pdf->SetXY( 10, $this->y );
			$pdf->drawTextBox( 'Vorhandenes Material:', $w1, 5, 'L', 'M', 0 );
			
			$pdf->SetXY( 10 + $w1, $this->y );
			$pdf->drawTextBox( 'Zu organisierendes Material:', $w2, 5, 'L', 'M', 0 );
			
			$this->y += 5;
			
			$pdf->SetFont( '', '', 10 );
			
			
			
			$h = 0;
			foreach( $event_instance->event->mat_available as $mat_available )
			{
				$pdf->SetXY( 11, $this->y + $h );
				$pdf->MultiCell( 15, 4, $mat_available->quantity, 0, 'L' );
				$quantity_h = $pdf->GetY() - $this->y - $h;
				
				$pdf->SetXY( 26, $this->y + $h );
				$pdf->MultiCell( 59, 4, $mat_available->article_name, 0, 'L' );
				$article_h = $pdf->GetY() - $this->y - $h;
				
				$h += max(5,$quantity_h, $article_h);
			}
			$max_h = max( $max_h, $h );
			
			
			$h = 0;
			foreach( $event_instance->event->mat_organize as $mat_organize )
			{
				$pdf->SetXY( 11 + $w1, $this->y + $h );
				$pdf->MultiCell( 15, 4, $mat_organize->quantity, 0, 'L' );
				$quantity_h = $pdf->GetY() - $this->y - $h;
				
				$pdf->SetXY( 26 + $w1, $this->y + $h );
				$pdf->MultiCell( 60, 4, $mat_organize->article_name, 0, 'L' );
				$article_h = $pdf->GetY() - $this->y - $h;
				
				$pdf->SetXY( 86 + $w1, $this->y + $h );
				
				if( $mat_organize->resp == "user" )
				{  $pdf->MultiCell( 39, 4, $mat_organize->user->get_name(), 0, 'L' ); }
				if( $mat_organize->resp == "mat_list" )
				{ $pdf->MultiCell( 39, 4, $mat_organize->mat_list->name, 0, 'L' ); }
				$resp_h = $pdf->GetY() - $this->y - $h;
				
				$h += max(5,$quantity_h, $article_h,$resp_h);
			}
			$max_h = max( $max_h, $h );
			
			
			$pdf->RoundedRect( 10, $this->y, $w1, $max_h, 2, '0000', 'D' );
			$pdf->RoundedRect( 10 + $w1, $this->y, $w2, $max_h, 2, '0000', 'D' );
			
			
			
			$pdf->SetLineWidth( 0.5 );
			$pdf->RoundedRect( 10, $this->y - 5, 190, $max_h + 5, 2, '0000', 'D' );
			$pdf->SetLineWidth( 0.2 );
			
			$this->y += $max_h;
		}
		
		
		function siko_h( $pdf, $event_instance )
		{
			return 5 * max( 1, $pdf->getNumLines( $event_instance->event->seco, 190 ) ) + 5;
		}
		
		function siko( $pdf, $event_instance )
		{
			$pdf->SetFont( '', 'B', 10 );
			
			$pdf->RoundedRect( 10, $this->y, 190, 5, 2, '0000', 'DF' );
			$pdf->SetXY( 10, $this->y );
			$pdf->drawTextBox( "SiKo:", 190, 5, 'L', 'M', 0 );
			
			$this->y += 5;
			
			$pdf->SetFont( '', '', 10 );
			$h = max( 5, 5 * $pdf->getNumLines( $event_instance->event->seco, 190 ) );
			
			$pdf->RoundedRect( 10, $this->y, 190, $h, 2, '0000', 'D' );
			$pdf->SetXY( 10, $this->y );
			$pdf->MultiCell( 190, $h, $event_instance->event->seco, '', 'L' );
			
			
			
			$pdf->SetLineWidth( 0.5 );
			$pdf->RoundedRect( 10, $this->y - 5, 190, $h + 5, 2, '0000', 'D' );
			$pdf->SetLineWidth( 0.2 );
			
			
			$this->y += $h;
			
		}
		
		
		
		
		function notes_h( $pdf, $event_instance )
		{
			return 5 * max( 1, $pdf->getNumLines( $event_instance->event->notes, 190 ) ) + 5;
		}
		
		function notes( $pdf, $event_instance )
		{
			$pdf->SetFont( '', 'B', 10 );
			
			$pdf->RoundedRect( 10, $this->y, 190, 5, 2, '0000', 'DF' );
			$pdf->SetXY( 10, $this->y );
			$pdf->drawTextBox( "Notizen:", 190, 5, 'L', 'M', 0 );
			
			$this->y += 5;
			
			$pdf->SetFont( '', '', 10 );
			$h = max( 5, 5 * $pdf->getNumLines( $event_instance->event->notes, 190 ) );
			
			$pdf->RoundedRect( 10, $this->y, 190, $h, 2, '0110', 'D' );
			$pdf->SetXY( 10, $this->y );
			$pdf->MultiCell( 190, $h, $event_instance->event->notes, '', 'L' );
			
			
			
			$pdf->SetLineWidth( 0.5 );
			$pdf->RoundedRect( 10, $this->y - 5, 190, $h + 5, 2, '0110', 'D' );
			$pdf->SetLineWidth( 0.2 );
			
			
			$this->y += $h + 5;
		}
		
		
		function color( $color )
		{
			return array(
							"r" => hexdec( substr( $color, 0, 2 ) ),
							"g" => hexdec( substr( $color, 2, 2 ) ),
							"b" => hexdec( substr( $color, 4, 2 ) ),
						);
		}
		
		function marker( $pdf, $event_instance )
		{
			$c_date = new c_date();
			
			$day = $event_instance->day;
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