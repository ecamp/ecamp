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

	class PRINT_CLASS
	{
		var $pdf;
		var $R;
		var $y, $x;
		var $PrintHeader;
		
    	function PRINT_CLASS(  )
		{	
			$this->pdf = new FPDF_ADDONS();
			$this->pdf->SetFont('arial', '', 10);
			$this->pdf->SetAutoPageBreak(false, 20);
			$this->R = '1';
			$this->PrintHeader = true;
		}
		
		function SetPrintHeader( $set )
		{	$this->PrintHeader = $set;	}

		function SetPrintFooter( $set )
		{	$this->PrintFooter = $set;	}
		
		function SetXY( $x = false, $y = false )
		{	
			if( $x )	{	$this->x = $x;	}
			if( $y )	{	$this->y = $y;	}
			$this->pdf->SetXY($this->x, $this->y);
			
			return $this;
		}
		
		function GetX()	{	return $this->pdf->GetX();	}
		function GetY()	{	return $this->pdf->GetY();	}
		
		function Space(	$space = 3 )
		{	$this->SetXY( $this->x, $this->y + $space );	}
		
		function AddPage( $orientation = '' )
		{
			$this->pdf->AddPage($orientation);
			
			if(!$this->PrintHeader)	{	return;	}
			if(!$this->PrintFooter)	{	return;	}

			$fsize 	= $this->pdf->GetFontSize();
			$fstyel	= $this->pdf->GetFontStyle();
			$this->pdf->SetFontSize( '8' );
			$this->pdf->SetFontStyle( '' );
			
			//	Header:
			// =========
			$this->pdf->Line(10, 18, 200, 18);
			
			//	Footer:
			// =========
			$this->pdf->Line(10, 280, 200, 280);
			
			
			$this->pdf->SetFontSize( $fsize );
			$this->pdf->SetFontStyle( $fstyle );
			$this->SetXY( 10, 20 );
		}
		
		function Cell ( $w, $minh, $text, $cbgc, $cs, $ca, $corner )
		{
			$this->pdf->SetFontStyle($cs);
			$cl = $this->pdf->WordWrap( $text, $w - 2 );
			$lh = $this->pdf->GetFontSize() / 2;
			$ch = $lh * $cl;
			$cbh = max( $ch, $minh, $lh );
			
			if( $cbgc )	
			{
				$temp = split("/", $cbgc);
				$this->pdf->SetFillColor( $temp[0], $temp[1], $temp[2] );
				$cf = 'DF';
			}
			else
			{	$cf = 'D';	}
			
			$this->pdf->SetFontStyle($cs);
			$this->pdf->RoundedRect( $this->x, $this->y, $w, $cbh, $this->R, $cf, $corner );
			$this->pdf->MultiCell( $w, $lh, $text, 0, $ca, 0 );
			
			$this->pdf->SetXY( $this->x, $this->y + $ch );
			return $cbh;
		}
		
		function LabeldCell( $w, $minh = 0, $label, $lbgc, $ls, $la, $text, $tbgc, $ts, $ta, $corner )
		{
			$lc = "";	$tc = "";
			if( strpos($corner, '1') !== false )	{	$lc .= '1';	}
			if( strpos($corner, '2') !== false )	{	$lc .= '2';	}
			if( strpos($corner, '3') !== false )	{	$tc .= '3';	}
			if( strpos($corner, '4') !== false )	{	$tc .= '4';	}
			
			$lh = $this->Cell( $w, 0, $label, $lbgc, $ls, $la, $lc ); 
			$this->SetXY( $this->x, $this->y + $lh );
			
			$minh = max( 0, $minh - $lh );
			
			$th = $this->Cell( $w, $minh, $text, $tbgc, $ts, $ta, $tc );
			$this->SetXY( $this->x, $this->y + $th );
			
			return $lh + $th;
		}
		
		function LabeldTable( $w, $content )
		{
			$x = $this->x;	$y = $this->y;	$save_x = $x;
			
			$fsize = $this->pdf->GetFontSize();
			
			foreach( $content as &$row )
			{	$row['dh'] = 0;
				foreach( $row as &$col )
				{	if( is_array( $col ) )
					{
						$col_label	= $col['label'];
						$col_text	= $col['text'];
						$lh = $this->pdf->WordWrap( $col_label, $w * $col['width'] );
						$th = $this->pdf->WordWrap( $col_text, $w * $col['width'] );
						$col['th'] = ( max(1, $lh) + max(1, $th) ) * $fsize / 2;
						
						if( $col['rowspan'] == 1 )
						{	$row['dh'] = max( $row['dh'], $col['th'] );	}
					}
				}
			}
			unset($row);	unset($col);
			
			foreach( $content as $rnr => &$row )
			{	foreach( $row as $cnr => &$col )
				{	if( is_array( $col ) && $col['rowspan'] != 1 )
					{
						$ph = 0;
						$row_without_h = array();
						for( $n = $rnr; $n < $rnr + $col['rowspan']; $n++)
						{
							if($content[$n]['dh'] == 0)	{	array_push($row_without_h, $n);	}
							else						{	$ph += $content[$n]['dh'];	}
						}
						
						if( $ph < $col['th'] )
						{	if( count( $row_without_h ) == 0 )
							{
								$supersize = ( $col['th'] - $ph ) / $col['rowspan'];
								for( $n = $rnr; $n < $rnr + $col['rowspan']; $n++ )
								{	$content[$n]['dh'] += $supersize;	}
							}
							else
							{
								$dh = ( $col['th'] - $ph ) / count( $row_without_h );
								foreach( $row_without_h as $n )	{	$content[$n]['dh'] = $dh;	}
							}
						}
					}
				}
			}
			unset($row);	unset($col);
			
			$tableh = $y;
			foreach( $content as $rnr => &$row )
			{	foreach( $row as $cnr => &$col )
				{	if( is_array( $col ) )
					{
						$dh = 0;
						for( $n = $rnr; $n < $rnr + $col['rowspan']; $n++ )
						{	$dh += $content[$n]['dh'];	}
						$col['dh'] = $dh;
						
						if( $rnr == 1 && $col['left'] == 0 )													{	$col['corner'] .= "1";	}
						if( $rnr == 1 && $col['left'] + $col['width'] == 1 )									{	$col['corner'] .= "2";	}
						if( $rnr + $col['rowspan'] - 1 == count( $content ) && $col['left'] == 0 )				{	$col['corner'] .= "4";	}
						if( $rnr + $col['rowspan'] - 1 == count( $content ) && $col['left'] + $col['width'] == 1 ){	$col['corner'] .= "3";	}
					}
				}
				$tableh += $row['dh'];
			}
			unset($row);	unset($col);
			
			
			if( $tableh > $this->pdf->GetPaperSize('h') - $this->pdf->GetMargin('b') )
			{	$this->addPage();	}
			
			$y_t = $this->y;
			foreach( $content as $row )
			{	foreach( $row as $cnr => $col )
				{	if( is_array( $col ) )
					{
						$x_t = $x + $w * $col['left'];	$w_t = $w * $col['width'];
						$this->SetXY($x_t, $y_t)->LabeldCell( $w_t, $col['dh'], $col['label'], $col['lbgc'], $col['lstyle'], $col['lalign'], $col['text'], $col['tbgc'], $col['tstyle'], $col['talign'], $col['corner'] );
					}
				}
				$y_t += $row['dh'];
			}
			
			$this->SetXY( $save_x, false);
			return $y_t - $this->y;
		}
		
		
		function LabeldCols( $w, $content )
		{
			$lh = $this->LabeldColsLabel( $w, $content['label'] );
			$fsize = $this->pdf->GetFontSize() / 2;
			$xb = $this->GetX();	$yb = $this->GetY();
			
			$left = array();	$width = array();
			foreach( $content['label'] as $nr => $label )
			{	$left[$nr] = $label['left'];	$width[$nr] = $label['width'];	}
			
			
			foreach( $content['content'] as $row )
			{
				if( $this->LabeldColsRow( $w, $row, $left, $width ) === false )
				{
					foreach ( $left as $nr => $l )
					{	$this->pdf->RoundedRect( $xb + $w * $l, $yb, $w * $width[$nr], $this->GetY() - $yb, $this->R, 'D', '' );	}
					
					$x = $this->GetX();
					$this->AddPage();
					$this->SetXY( $x, false );
					$this->LabeldColsLabel( $w, $content['label'], false );
					
					$xb = $this->GetX();	$yb = $this->GetY();
					$this->LabeldColsRow( $w, $row, $left, $width );
				}
				else
				{	$this->Space(2);	}
			}
			
			foreach ( $left as $nr => $l )
			{
				$corner = "";
				if( $nr == 1 )				{	$corner .= "4";	}
				if( $nr == count($left) )	{	$corner .= "3";	}
				$this->pdf->RoundedRect( $xb + $w * $l, $yb, $w * $width[$nr], $this->GetY() - $yb, $this->R, 'D', $corner );
			}
			
			return $this->GetY() - $yc + $lh;
		}
		
		function LabeldColsRow( $w, $row_array, $left, $width )
		{
			$xs = $this->GetX();	$ys = $this->GetY();	$ch = 0;
			$fsize = $this->pdf->GetFontSize() / 2;
			
			foreach( $row_array as $nr => $col )
			{
				$this->pdf->SetFontStyle( $col['style'] );
				$h = $this->pdf->WordWrap( $col['text'], $w * $width[$nr] - $col['offset'] - 2 );
				$ch = max( $ch, $h * $fsize );
			}
			
			if( $this->pdf->GetPaperSize( h ) - $this->pdf->GetMargin("bottom") < $this->GetY() + $ch )
			{	return false;	}
			
			foreach( $row_array as $nr => $col )
			{
				if( $col['bgc'] )
				{
					$color = split( "/", $col['bgc'] );	$this->pdf->SetFillColor( $color[0], $color[1], $color[2] );
					$color = 1;
				}
				else	{	$color = 0;	}
				
				$this->pdf->SetFontStyle( $col['style'] );
				$this->SetXY( $xs + $w * $left[$nr] + $col['offset'], $ys );
				$this->pdf->MultiCell( $w * $width[$nr] - $col['offset'], $fsize, $col['text'], 0, $col['align'], $color );
			}
			
			$this->SetXY( $xs, $ys + $ch );
			return $ch;
		}
		
		function LabeldColsLabel( $w, $label_array, $print_corner = 'true' )
		{
			$xs = $this->GetX();	$ys = $this->GetY();
			$fsize = $this->pdf->GetFontSize() / 2;
			
			$lh = 0;
			foreach( $label_array as $label )
			{
				$this->pdf->SetFontStyle( $label['style'] );
				$h = $this->pdf->WordWrap( $label['text'], $w * $label['width'] - $label['offset'] - 2 );
				$lh = max( $h * $fsize, $lh );
			}
			
			if( $this->pdf->GetPaperSize( h ) - $this->pdf->GetMargin("bottom") < $this->GetY() + $lh )
			{	$this->AddPage();	$xs = $this->GetX();	$ys = $this->GetY();	}
				
			
			foreach( $label_array as $nr => $label )
			{
				$corner = "";
				if( $print_corner && $nr == 1 )						{	$corner .= "1";	}
				if( $print_corner && $nr == count( $label_array ) )	{	$corner .= "2";	}
				
				$this->SetXY( $xs + $w * $label['left'], $ys );
				$this->Cell( $w * $label['width'], $lh, $label['text'], $label['bgc'], $label['style'], $label['align'], $corner );
			}
			
			$this->SetXY( $xs, $ys + $lh );
			
			return $lh;
		}
		
		
		function Table(	$w, $content )
		{
			$ty = $this->GetY();
			$tx = $this->GetX();
			$cl = array();
			$cw = array();
			foreach( $content as $row )
			{
				$rh = 0;
				$ry = $this->GetY();
				foreach( $row as $nr => $col )
				{
					if($col['left'])	{	$cl[$nr] = $col['left'];	}
					if($col['width'])	{	$cw[$nr] = $col['width'];	}
					$this->SetXY( $tx + $w * $cl[$nr], $ry );
					$ch = $this->TableRow( $w * $cw[$nr], $col['text'], $col['style'], $col['align'], $col['offset'] );
					
					$rh = max( $rh, $ch );
				}
				
				$this->SetXY( $tx, $ry + $rh );
			}
			
			return $this->GetY() - $ty;
		}
		
		function TableRow( $w, $text, $style = "", $align = "L", $offset = 0 )
		{
			$s = $this->pdf->GetFontStyle();
			
			$this->pdf->SetFontStyle( $style );
			$this->SetXY( $this->x + $offset, false );
			
			$th = $this->pdf->WordWrap( $text, $w - 2 ) * $this->pdf->GetFontSize() / 2;
			$this->pdf->MultiCell( $w, $this->pdf->GetFontSize() / 2, $text, 0, $align, 0 );
			
			$this->pdf->SetFontStyle( $s );
			
			$this->SetXY( $this->x - $offset, $this->y + $th );
			return $th;
		}
		
		function Day( $day_id )
		{
			$Data = DayData( $day_id );
			
			
			$this->AddPage();
			$this->pdf->SetFillColor( 200, 200, 200 );
			$this->pdf->RoundedRect( 10, 20, 190, 25, $this->R, 'DF', '1234' );
			
			$this->pdf->SetFontSize(25);	$this->pdf->SetFontStyle('B');	$this->SetXY( 10, 24 );
			$this->pdf->Cell( 190, 10, strtr( date("l, d.m.Y", $Data['date']), $GLOBALS['en_to_de'] ), 0, 1, 'C', 0 );
			
			$this->pdf->SetFontSize(16);	$this->SetXY( 10, 35 );
			$this->pdf->Cell( 190, 10, "Tagesübersicht:", 0, 1, 'C', 0 ); 
			
			
			
			$this->pdf->SetFontSize(10);
			$this->SetXY( 10, 50 )->LabeldTable( 190, $Data['jobs'] );
			$this->Space(10);
			
			$this->SetXY( 15, false );
			$this->pdf->Line( 10, $this->GetY() + 5, 200, $this->GetY() + 5 );
			$this->Table( 180, $Data['events'] );
			$this->Space(10);
			
			$this->SetXY( 10, false );
			$this->LabeldCell( 190, 0, "Roter Faden:", "200/200/200", "B", "L", $Data['story'], false, "", "L", '1234' );
			$this->Space();
			
			$this->LabeldCell( 190, 0, "Notizen:", "200/200/200", "B", "L", $Data['notes'], false, "", "L", '1234' );
			
		}
		
		function EventInstance( $event_instance_id )
		{
			$Data = EventInstanceData( $event_instance_id );
			
			// Reicht der Platz aus, um den Block zu drucken...
			
			
			$y = $this->GetY();	$head = $Data['head'];
			$this->pdf->SetFillColor( hexdec( substr($head['color'], 0, 2) ), hexdec( substr($head['color'], 2, 2) ), hexdec( substr($head['color'], 4, 2) ) );
			$this->pdf->RoundedRect( 10, $y, 190, 18, $this->R, 'DF', '1234' );
			
			$display = "(" . $head['day_nr'] . "." . $head['event_nr'] . ") " . $head['short_name'] . ": " . $head['name'];
			$this->pdf->setFontSize( 20 );	$this->pdf->SetFontStyle('B');	$this->SetXY( 15, $y );
			$this->pdf->Cell( 120, 18, $display, 0, 1, 'L', 0 );
			
			$this->pdf->setFontSize( 10 );	$this->pdf->SetFontStyle('B');
			$this->SetXY( 140, $y + 1	);	$this->pdf->Write( 5, "Datum:"	);
			$this->SetXY( 140, $y + 6.5	); 	$this->pdf->Write( 5, "Zeit:"	);
			$this->SetXY( 140, $y + 12	);	$this->pdf->Write( 5, "Ort:"	);
			
			$start_date = new c_date();	$start_date->setDay2000( $head['start'] );
			$this->SetXY( 160, $y + 1 );	$this->pdf->Write( 5, strtr( $start_date->getString( "D d.m.Y" ), $GLOBALS['en_to_de'] ) );
			
			$start_time = new c_time();	$start_time->setValue( $head['starttime'] );
			$end_time = new c_time();	$end_time->setValue( $head['starttime'] + $head['length'] );
			$this->SetXY( 160, $y + 6.5 );	$this->pdf->Write( 5, $start_time->getString("H:i") . " - " . $end_time->getString("H:i") );
			
			$this->SetXY( 160, $y + 12 );	$this->pdf->Write( 5, $head['place'] );
			
			$this->SetXY( 10, $y + 18 );
			$this->Space( 4 );
			
			
			$this->LabeldTable( 190, $Data['info'] );
			$this->Space( 4 );
			$this->LabeldCols( 190, $Data['detail'] );
		}
		
		
	}
?>