<?php
	if (!class_exists('UFPDF_ADDONS'))
	{
		class FPDF_ADDONS extends UFPDF
		{
			
			function RoundedRect($x, $y, $w, $h, $r, $style = '', $angle = '1234')
			{
				$k = $this->k;
				$hp = $this->h;
				if($style=='F')
					$op='f';
				elseif($style=='FD' or $style=='DF')
					$op='B';
				else
					$op='S';
				$MyArc = 4/3 * (sqrt(2) - 1);
				$this->_out(sprintf('%.2f %.2f m', ($x+$r)*$k, ($hp-$y)*$k ));
		
				$xc = $x+$w-$r;
				$yc = $y+$r;
				$this->_out(sprintf('%.2f %.2f l', $xc*$k, ($hp-$y)*$k ));
				if (strpos($angle, '2')===false)
					$this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k, ($hp-$y)*$k ));
				else
					$this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
		
				$xc = $x+$w-$r;
				$yc = $y+$h-$r;
				$this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k, ($hp-$yc)*$k));
				if (strpos($angle, '3')===false)
					$this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k, ($hp-($y+$h))*$k));
				else
					$this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
		
				$xc = $x+$r;
				$yc = $y+$h-$r;
				$this->_out(sprintf('%.2f %.2f l', $xc*$k, ($hp-($y+$h))*$k));
				if (strpos($angle, '4')===false)
					$this->_out(sprintf('%.2f %.2f l', ($x)*$k, ($hp-($y+$h))*$k));
				else
					$this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
		
				$xc = $x+$r ;
				$yc = $y+$r;
				$this->_out(sprintf('%.2f %.2f l', ($x)*$k, ($hp-$yc)*$k ));
				if (strpos($angle, '1')===false)
				{
					$this->_out(sprintf('%.2f %.2f l', ($x)*$k, ($hp-$y)*$k ));
					$this->_out(sprintf('%.2f %.2f l', ($x+$r)*$k, ($hp-$y)*$k ));
				}
				else
					$this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
				$this->_out($op);
			}
		
			function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
			{
				$h = $this->h;
				$this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k, 
					$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
			}
		    
		    
		    
		    
		    
		    
		    
		    
		    
		    
		    
			function drawTextBox($strText, $w, $h, $align='L', $valign='T', $border=1)
			{
				$xi=$this->GetX();
				$yi=$this->GetY();
			    
				$hrow=$this->FontSize;
				$textrows=$this->drawRows($w, $hrow, $strText, 0, $align, 0, 0, 0);
				$maxrows=floor($h/$this->FontSize);
				$rows=min($textrows, $maxrows);
			
				$dy=0;
				if (strtoupper($valign)=='M')
					$dy=($h-$rows*$this->FontSize)/2;
				if (strtoupper($valign)=='B')
					$dy=$h-$rows*$this->FontSize;
			
				$this->SetY($yi+$dy);
				$this->SetX($xi);
			
				$this->drawRows($w, $hrow, $strText, 0, $align, 0, $rows, 1);
			
				if ($border==1)
					$this->Rect($xi, $yi, $w, $h);
			}
			
			function drawRows($w, $h, $txt, $border=0, $align='J', $fill=0, $maxline=0, $prn=0)
			{
				$cw=&$this->CurrentFont['cw'];
				if($w==0)
					$w=$this->w-$this->rMargin-$this->x;
				$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
				$s=str_replace("\r", '', $txt);
				$nb=strlen($s);
				if($nb>0 and $s[$nb-1]=="\n")
					$nb--;
				$b=0;
				if($border)
				{
					if($border==1)
					{
						$border='LTRB';
						$b='LRT';
						$b2='LR';
					}
					else
					{
						$b2='';
						if(is_int(strpos($border, 'L')))
							$b2.='L';
						if(is_int(strpos($border, 'R')))
							$b2.='R';
						$b=is_int(strpos($border, 'T')) ? $b2.'T' : $b2;
					}
				}
				$sep=-1;
				$i=0;
				$j=0;
				$l=0;
				$ns=0;
				$nl=1;
				while($i<$nb)
				{
					//Get next character
					$c=$s[$i];
					if($c=="\n")
					{
						//Explicit line break
						if($this->ws>0)
						{
							$this->ws=0;
							if ($prn==1) $this->_out('0 Tw');
						}
						if ($prn==1) {
							$this->Cell($w, $h, substr($s, $j, $i-$j), $b, 2, $align, $fill);
						}
						$i++;
						$sep=-1;
						$j=$i;
						$l=0;
						$ns=0;
						$nl++;
						if($border and $nl==2)
							$b=$b2;
						if ( $maxline && $nl > $maxline )
							return substr($s, $i);
						continue;
					}
					if($c==' ')
					{
						$sep=$i;
						$ls=$l;
						$ns++;
					}
					$l+=$cw[$c];
					if($l>$wmax)
					{
						//Automatic line break
						if($sep==-1)
						{
							if($i==$j)
								$i++;
							if($this->ws>0)
							{
								$this->ws=0;
								if ($prn==1) $this->_out('0 Tw');
							}
							if ($prn==1) {
								$this->Cell($w, $h, substr($s, $j, $i-$j), $b, 2, $align, $fill);
							}
						}
						else
						{
							if($align=='J')
							{
								$this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
								if ($prn==1) $this->_out(sprintf('%.3f Tw', $this->ws*$this->k));
							}
							if ($prn==1){
								$this->Cell($w, $h, substr($s, $j, $sep-$j), $b, 2, $align, $fill);
							}
							$i=$sep+1;
						}
						$sep=-1;
						$j=$i;
						$l=0;
						$ns=0;
						$nl++;
						if($border and $nl==2)
							$b=$b2;
						if ( $maxline && $nl > $maxline )
							return substr($s, $i);
					}
					else
						$i++;
				}
				//Last chunk
				if($this->ws>0)
				{
					$this->ws=0;
					if ($prn==1) $this->_out('0 Tw');
				}
				if($border and is_int(strpos($border, 'B')))
					$b.='B';
				if ($prn==1) {
					$this->Cell($w, $h, substr($s, $j, $i-$j), $b, 2, $align, $fill);
				}
				$this->x=$this->lMargin;
				return $nl;
			}
			
			
			
			
			
			
			
			
			
			
			
			
			var $extgstates = array();
			
			
			// alpha: real value from 0 (transparent) to 1 (opaque)
			// bm:    blend mode, one of the following:
			//          Normal, Multiply, Screen, Overlay, Darken, Lighten, ColorDodge, ColorBurn, 
			//          HardLight, SoftLight, Difference, Exclusion, Hue, Saturation, Color, Luminosity
			function SetAlpha($alpha, $bm='Normal')
			{
				// set alpha for stroking (CA) and non-stroking (ca) operations
				$gs = $this->AddExtGState(array('ca'=>$alpha, 'CA'=>$alpha, 'BM'=>'/'.$bm));
				$this->SetExtGState($gs);
			}
		
			function AddExtGState($parms)
			{
				$n = count($this->extgstates)+1;
				$this->extgstates[$n]['parms'] = $parms;
				return $n;
			}
		
			function SetExtGState($gs)
			{
				$this->_out(sprintf('/GS%d gs', $gs));
			}
		
			function _enddoc()
			{
				if(!empty($this->extgstates) && $this->PDFVersion<'1.4')
					$this->PDFVersion='1.4';
				parent::_enddoc();
			}
		
			function _putextgstates()
			{
				for ($i = 1; $i <= count($this->extgstates); $i++)
				{
					$this->_newobj();
					$this->extgstates[$i]['n'] = $this->n;
					$this->_out('<</Type /ExtGState');
					foreach ($this->extgstates[$i]['parms'] as $k=>$v)
						$this->_out('/'.$k.' '.$v);
					$this->_out('>>');
					$this->_out('endobj');
				}
			}
		
			function _putresourcedict()
			{
				parent::_putresourcedict();
				$this->_out('/ExtGState <<');
				foreach($this->extgstates as $k=>$extgstate)
					$this->_out('/GS'.$k.' '.$extgstate['n'].' 0 R');
				$this->_out('>>');
			}
		
			function _putresources()
			{
				$this->_putextgstates();
				parent::_putresources();
			}
			
		}
	}
?>