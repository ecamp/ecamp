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

	require_once $GLOBALS['pear_dir']."Spreadsheet/Excel/Writer.php";
	
	// load data
	$query = "SELECT CONCAT('(',v.day_nr,'.' ,v.event_nr,') ', e.name) AS name, 
				e.id AS id,
				e.aim,
				e.topics,
				i.starttime AS start,
				i.starttime + i.length AS end,
				s.start + d.day_offset AS day
			FROM
				event e, 
				event_instance i, 
				category c,
				(".getQueryEventNr($_camp->id).") v, 
				day d, 
				subcamp s 
			WHERE   
				e.id = i.event_id
				AND e.category_id = c.id
				AND c.form_type > 0
				AND v.event_instance_id = i.id
				AND i.day_id = d.id
				AND d.subcamp_id = s.id
				AND s.camp_id = $_camp->id
			ORDER BY v.day_nr, v.event_nr";
			//echo $query;
			//die( $query );
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	//
	$query = "SELECT d.entry FROM camp, dropdown d
				WHERE 
					camp.type = d.value 
					AND camp.id = $_camp->id
					AND d.list='coursetype'";
	$result2 = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	$course_type = mysqli_fetch_assoc($result2);
	
	// Creating a workbook
	$workbook = new Spreadsheet_Excel_Writer();
  $workbook->setVersion(8); 
	
	// sending HTTP headers
	$workbook->send('Blockuebersicht.xls');
	
	// Creating a worksheet
	$worksheet =& $workbook->addWorksheet(utf8_decode("Blockuebersicht"));
  $worksheet->setInputEncoding ("UTF-8");
	
  $format_content = & $workbook->addFormat(
  	    array( "Size" => 8,
	        "Align" => "left",
	        "Border" => 1,
	        "vAlign" => "top"
        )
  );
	
	$format_content_unboxed = & $workbook->addFormat(
		array(
			"Size" => 8,
			"Align" => "left",
			"Border" => 0,
			"vAlign" => "top"
		)
	);
	
	$format_header  = & $workbook->addFormat(
		array(
			"Size" => 10,
			"Bold" => 1,
			"Align" => "left",
			"Border" => 1,
			"vAlign" => "top"
		)
	);
	
	$format_title  = & $workbook->addFormat(
		array(
			"Size" => 16,
			"Bold" => 1,
			"vAlign" => "top"
		)
	);
	
	$format_title->setFontFamily("Arial");
	
	$format_content->setFontFamily("Arial");
	$format_content->setTextWrap();
	
	$format_content_unboxed->setFontFamily("Arial");
		
	$format_header->setFontFamily("Arial");
	$format_header->setTextWrap();
	
	//
	$worksheet->setLandscape();
	$worksheet->setMargins(0.5);
	$worksheet->setMargins_TB (1);
	
	$worksheet->hideGridlines();
	
	$worksheet->setHeader("&L&8".$_camp->short_name." &C &R&8 ".$course_type['entry'],"0.4");
	$worksheet->setFooter("&C&8&P/&N","0.4"); 

	// Column width
	$worksheet->setColumn(0,0,22);
	$worksheet->setColumn(1,1,16);
	$worksheet->setColumn(2,4,32);
	
	// title
	$worksheet->write(0, 0, "Blockübersicht",$format_title);
	
	// Header
	$row = 2;
	$worksheet->write($row, 0,"Die folgende Tabelle gibt eine Übersicht über die Ausbildungsblöcke. Dieses Dokument kann für die Kursanmeldung bei PBS verwendet werden.",$format_content_unboxed);
	
	$row++;$row++;
	$worksheet->write($row, 0, "Bezeichnung\n(PBS-/J+S-Checkliste in [])",$format_header);
	$worksheet->write($row, 1, "Datum und Zeit",$format_header);
	$worksheet->write($row, 2, "behandelte Ausbildungsziele",$format_header);
	$worksheet->write($row, 3, "Blockziele",$format_header);
	$worksheet->write($row, 4, "Inhalte",$format_header);
	
	while( $this_event = mysqli_fetch_assoc($result) )
	{
		$row++;
		
		///////////////////////
		// load additional data
		///////////////////////
		// Checkliste
		$query = "SELECT 
		  cc.short
		FROM event_checklist ec, course_checklist cc
		WHERE
		  cc.id = ec.checklist_id
		  AND ec.event_id=$this_event[id]
		ORDER BY cc.short_1, cc.short_2";
		//echo $query;
		$result2 = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		
		$checklist_str = "";
		while( $this_checklist_item = mysqli_fetch_assoc($result2) )
		{
			$checklist_str = $checklist_str . $this_checklist_item['short'] . ", ";
		}
		$checklist_str = "[".substr($checklist_str,0,strlen($checklist_str)-2)."]";

		// Ausbildungsziele
		$query = "SELECT 
		  ca.aim
		FROM event_aim ea, course_aim ca
		WHERE
		  ca.id = ea.aim_id
		  AND ea.event_id=$this_event[id]
		ORDER BY ea.id";
		//echo $query;
		$result2 = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		
		$aim_str = "";
		while( $this_aim = mysqli_fetch_assoc($result2) )
		{
			$aim_str = $aim_str . "- ".$this_aim['aim'] . "\n";
		}
		
		///////////////////////
		// format output
		///////////////////////
		// name
		$worksheet->write($row, 0, $this_event['name']." ".$checklist_str, $format_content);
		//echo $this_event[name]." ".$checklist_str."   ";
		
		// date
		$start = new c_time();
		$start->setValue($this_event['start']);
		
		$end = new c_time();
		$end->setValue($this_event['end']);
		
		$date = new c_date();
		$date->setDay2000($this_event['day']);
		
		$this_date = $GLOBALS['en_to_de'][$date->getString("D")].", ".$date->getString("j.n.").", ".$start->getString("G:i")."-".$end->getString("G:i");//"Fr, 5.10., 17:15-18:00";
		$worksheet->write($row, 1, $this_date, $format_content);
		//echo $this_date."   ";	
		
		// aim
		$worksheet->write($row, 2, $aim_str, $format_content);
		//echo $aim_str."   ";
		
		// event-aim
		$worksheet->write($row, 3, $this_event['aim'], $format_content);
		//echo $this_event[aim]."   ";
		
		// topics
		$worksheet->write($row, 4, $this_event['topics'], $format_content);
		//echo $this_event[topics]."   ";
		//echo "\n";
	}
		
	// Let's send the file
	$workbook->close();
	die();
