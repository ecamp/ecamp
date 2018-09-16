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

	
	class print_build_daylist_class
	{
		public $data;
		public $y;
		
		
		function print_build_daylist_class($data)
		{
			$this->data = $data;
		}
		
		function build($pdf)
		{
			$pdf->AddPage('P', 'A4');
			
			$pdf->Bookmark('Tagesübersicht', 0, 0);
			
			$this->title($pdf);
			$this->overview($pdf);
			
			return $this->y + 5;
		}
		
		function title($pdf)
		{
			$pdf->SetXY(10, 15);
			$pdf->SetFont('', 'B', 30);
			
			$pdf->drawTextBox("Lager - Übersicht:", 190, 15, 'C', 'M', 0);
			$this->y = 30;
		}
		
		function overview($pdf)
		{
			$row_num = count($data->subcamp) + count($data->day);
			
			foreach ($this->data->subcamp as $subcamp)
			{
				$this->y += 10;
				
				$subcamp_str = strtr(date('d.m.Y', $subcamp->ustart), $GLOBALS['en_to_de']);
				$subcamp_str .= " - ";
				$subcamp_str .= strtr(date('d.m.Y', $subcamp->uend), $GLOBALS['en_to_de']);
				
				$pdf->SetXY(10, $this->y);
				$pdf->SetFont('', 'B', 20);
				
				$pdf->drawTextBox($subcamp_str, 190, 10, 'L', 'M', 0);
				$this->y += 12;
				
				
				
				$pdf->SetFont('', 'B', 12);
				
				foreach ($subcamp->get_sorted_day() as $day)
				{
					$pdf->SetFillColor(0, 0, 0);
					
					$pdf->RoundedRect(0, $this->y + 0.3, 6, 7.4, 0, '0000', 'F');
					$pdf->RoundedRect(204, $this->y + 0.3, 6, 7.4, 0, '0000', 'F');
					$pdf->RoundedRect(6, $this->y, 198, 8, 0, '0000', 'D');
					
					$pdf->Link(6, $this->y, 198, 8, $day->get_linker($pdf));
					
					$day->set_marker($this->y);
					
					
					$c_date = new c_date();
					
					$pdf->SetFont('', 'B', 12);
					$pdf->SetTextColor(0, 0, 0);
					$day_str = strtr($c_date->setDay2000($day->date)->getString('d.m.Y - l'), $GLOBALS['en_to_de']);
					$pdf->SetXY(15, $this->y);
					$pdf->drawTextBox($day_str, 190, 8, 'L', 'M', 0);
					
					
					$pdf->SetFont('', 'B', 8);
					$pdf->SetTextColor(255, 255, 255);
					$day_str = strtr($c_date->setDay2000($day->date)->getString('D'), $GLOBALS['en_to_de']);
					$pdf->SetXY(0, $this->y);
					$pdf->drawTextBox($day_str, 6, 8, 'C', 'M', 0);
					$pdf->SetXY(204, $this->y);
					$pdf->drawTextBox($day_str, 6, 8, 'C', 'M', 0);
					
					$this->y += 8;
				}
				
				$pdf->SetTextColor(0, 0, 0);
				
			}
		}
		
	}

?>