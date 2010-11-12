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

	
	require_once $GLOBALS[pear_dir]."Spreadsheet/Excel/Writer.php";
	
	
	/* load mat_list */
	$list_id = $_REQUEST['list'];
	
	$list_entries = array();
	
	if( $_REQUEST['listtype'] == "user" )
	{
		$query = "	SELECT mat_event.*, event.name as event_name
					FROM mat_event, event
					WHERE
						event.camp_id = $_camp->id AND
						event.id = mat_event.event_id AND
						mat_event.user_camp_id = $list_id
					ORDER BY
						mat_event.event_id";
		
		$result = mysql_query( $query );
		
		while( $list_entry = mysql_fetch_assoc( $result ) )
		{	$list_entries[] = $list_entry;	}
		
		/* load list title */
		$query = "SELECT user.scoutname FROM user_camp, user WHERE user.id=user_camp.user_id AND user_camp.id=".$list_id;
		$res = mysql_query($query);
		$res = mysql_fetch_assoc($res);
		$title = "Materialliste für ".$res[scoutname];
	}
	elseif( $_REQUEST['listtype'] == "mat_list" )
	{
		$_camp->mat_list( $list_id ) || die( "error" );
		
		$query = "	SELECT 
						mat_event.*, 
						event.name as event_name
		
					FROM mat_event, event
					WHERE
						event.camp_id = $_camp->id AND
						event.id = mat_event.event_id AND
						mat_event.mat_list_id = $list_id";
		$result = mysql_query( $query );
		
		while( $list_entry = mysql_fetch_assoc( $result ) )
		{	$list_entries[] = $list_entry;	}
		
		/* load list title */
		$query = "SELECT name FROM mat_list WHERE id=".$list_id;
		$res = mysql_query($query);
		$res = mysql_fetch_assoc($res);
		$title = "Einkaufsliste ".$res[name];
	}
	
	
	
	
	// Creating a workbook
	$workbook = new Spreadsheet_Excel_Writer();
	
	// sending HTTP headers
	$workbook->send('Materialliste.xls');
	
	// Creating a worksheet
	$worksheet =& $workbook->addWorksheet(utf8_decode("Materialliste"));
	
	$format_content = & $workbook->addFormat(array( "Size" => 8,
													"Align" => "left",
													"Border" => 1,
													"vAlign" => "top"));
	
	$format_content_unboxed = & $workbook->addFormat(array( "Size" => 8,
													"Align" => "left",
													"Border" => 0,
													"vAlign" => "top"));
	
	$format_header  = & $workbook->addFormat(array( "Size" => 10,
													"Bold" => 1,
													"Align" => "left",
													"Border" => 1,
													"vAlign" => "top"));
	
	$format_title  = & $workbook->addFormat(array( "Size" => 16,
													"Bold" => 1,
													"vAlign" => "top"));
	
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
	$worksheet->setInputEncoding ("UTF-8");
	
	$worksheet->setHeader("&L&8".$_camp->short_name." &C &R&8 ".$course_type[entry],"0.4"); 
	$worksheet->setFooter("&C&8&P/&N","0.4"); 

	// Column width
	$worksheet->setColumn(0,0,16);
	$worksheet->setColumn(1,1,32);
	$worksheet->setColumn(2,4,32);
	
	// title
	$worksheet->write(0, 0, utf8_decode($title),$format_title);
	
	// Header
	$row = 2; $row++;
	
	$worksheet->write($row, 0, "Erledigt", $format_header);
	$worksheet->write($row, 1, "Menge", $format_header);
	$worksheet->write($row, 2, "Material", $format_header);
	$worksheet->write($row, 3, utf8_decode("für Block"), $format_header);
	
	foreach( $list_entries as $item  )
	{
		$row++;
		
		$worksheet->write($row, 0,utf8_decode($item[organized] ? "ok" : "" ), $format_content);
		$worksheet->write($row, 1,utf8_decode($item[quantity]), $format_content);
		$worksheet->write($row, 2,utf8_decode($item[article_name]), $format_content);
		$worksheet->write($row, 3,utf8_decode($item[event_name]), $format_content);
		
	}
		
	// Let's send the file
	$workbook->close();
	die();
?>