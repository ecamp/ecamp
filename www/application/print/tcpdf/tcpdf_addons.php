<?php
	if(!class_exists('TCPDF_ADDONS'))
	{
		class TCPDF_ADDONS extends TCPDF
		{
			public function Header()
			{
				global $print_data;
				
				$name_and_short_name = $print_data->camp->name;
				if ($print_data->camp->is_course) {
					$name_and_short_name = implode(", ", array($print_data->camp->name, $print_data->camp->short_name));
				}

				$first_day = new c_date();		$first_day->setDay2000( $print_data->camp->first_day );
				$last_day = new c_date();		$last_day->setDay2000( $print_data->camp->last_day );
				
				$main_leader = "";
				$main_leaders = array();
				foreach($print_data->user as $leader) {
					if (($print_data->camp->is_course && $leader->funct == "Kursleiter") || (!$print_data->camp->is_course && $leader->funct == "Lagerleiter")) {
						$main_leaders[] = $leader->firstname . " " . $leader->surname;
					}
				}
				if (count($main_leaders) > 0) {
					$main_leaders = "Hauptleitung: " . implode(", ", $main_leaders);
				}
				
				$w = $this->getPageWidth();
				$fs = $this->getFontSize();
				$this->SetFontSize( 8 );
				
				$this->SetXY( 10, 4 );		$this->drawTextBox( $print_data->camp->slogan, $w - 20, 4, 'C', 'T', 0 );
				$this->SetXY( 10, 4 );		$this->drawTextBox( $print_data->camp->group_name, $w - 20, 4, 'L', 'T', 0 );
				$this->SetXY( 10, 4 );		$this->drawTextBox( $name_and_short_name, $w - 20, 4, 'R', 'T', 0 );
				$this->SetXY( 10, 7 );		$this->drawTextBox( $print_data->camp->ca_name . ", " . $print_data->camp->ca_zipcode . " " . $print_data->camp->ca_city, $w - 20, 4, 'C', 'T', 0 );
				$this->SetXY( 10, 7 );		$this->drawTextBox( $first_day->getString( 'd.m.Y' ) . " - " . $last_day->getString( 'd.m.Y' ), $w - 20, 4, 'L', 'T', 0 );
				$this->SetXY( 10, 7 );		$this->drawTextBox( $main_leader, $w - 20, 4, 'R', 'T', 0 );
				
				$this->Line( 10, 10.5, $w - 10, 10.5 );
				
				$this->SetFontSize( $fs );
				return;
			}
			
			public function Footer()
			{
				return;
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
			    
			    return $textrows;
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
			
		}
	}
?>
