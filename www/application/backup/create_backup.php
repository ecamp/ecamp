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

////////////////////////////////
	// Wandelt einen Binärstring in Hex um
	function string2hex($str)
	{
		if (trim($str)!="")
		{
			$hex="";
			$length=strlen($str);
			for ($i=0; $i<$length; $i++)
			{
				$hex.=str_pad(dechex(ord($str[$i])), 2, 0, STR_PAD_LEFT);
			}
			return "0x".$hex;
		}
	}
///////////////////////////////

 include("../../config.php");
 include("../../lib/mysql.php");
 db_connect();
 
 header("Content-type: text/plain");

// Diese Datei erstellt automatische Backups von Lagern
// Die Datei sollte sich nicht im www-Ordner befinden. Sie wird dann später mit einem Cronjob regelmässig aufgerufen.
// 
// - pro Lager wird ein SQL-File gespeichert. Dateien werden in ein Unterverzeichnis kopiert.
// - wenn ein Lager die maximal zulässige Anzahl Backups überschritten hat, wird das älteste Backup gelöscht

$camp_id = 12;

// Tabellen spezifizieren
// Die Reihenfolge der Tabellen ist wichtig, da sie genau so bei einem Restore wieder zurückgeschrieben werden.
// Eine falsche Reihenfolge führt zur Verletzung von Fremdschlüssel-Bedingungen.
$tables = array(
   // Verknüpfung direkt über camp_id
  "camp"    		=> "SELECT * FROM camp WHERE id=$camp_id",
  "category" 		=> "SELECT * FROM category WHERE camp_id=$camp_id",
  "course_aim"		=> "SELECT * FROM course_aim WHERE camp_id=$camp_id",
  "user_camp"		=> "SELECT * FROM user_camp WHERE camp_id=$camp_id",
  "job"				=> "SELECT * FROM job WHERE camp_id=$camp_id",
//  "pre_user"		=> "SELECT * FROM pre_user WHERE camp_id=$camp_id",
//  "tn"				=> "SELECT * FROM tn WHERE camp_id=$camp_id",
  "todo"			=> "SELECT * FROM todo WHERE camp_id=$camp_id",
  "event"   		=> "SELECT e.* FROM event e WHERE e.camp_id=$camp_id",
  "mat_list"		=> "SELECT ml.* FROM mat_list ml WHERE ml.camp_id=$camp_id",
  
  "subcamp" 	   	=> "SELECT subcamp.* FROM subcamp WHERE camp_id=$camp_id",
  "day"     		=> "SELECT d.* FROM day d, subcamp s WHERE d.subcamp_id=s.id AND s.camp_id=$camp_id",
  
  // Verknüpfung über event
  "event_instance" 	  => "SELECT i.* FROM event_instance i, event e WHERE i.event_id=e.id AND e.camp_id=$camp_id",
  "event_detail"	  => "SELECT d.* FROM event_detail d, event e WHERE d.event_id=e.id AND e.camp_id=$camp_id",
  "event_aim" 		  => "SELECT a.* FROM event_aim a, event e WHERE a.event_id=e.id AND e.camp_id=$camp_id",
  "event_responsible" => "SELECT r.* FROM event_responsible r, event e WHERE r.event_id=e.id AND e.camp_id=$camp_id",
  "event_document" 	  => "SELECT d.* FROM event_document d, event e WHERE d.event_id=e.id AND e.camp_id=$camp_id",
  "event_checklist"   => "SELECT c.* FROM event_checklist c, event e WHERE c.event_id=e.id AND e.camp_id=$camp_id",
  "event_comment"	  => "SELECT ec.* FROM event_comment ec, event e WHERE ec.event_id=e.id AND e.camp_id=$camp_id",
  "mat_event"		  => "SELECT me.* FROM mat_event me, event e WHERE me.event_id=e.id AND e.camp_id=$camp_id",


//  "mat_article_event" => "SELECT m.* FROM mat_article_event m, event e WHERE m.event_id=e.id AND e.camp_id=$camp_id",
//  "mat_stuff"		  => "SELECT m.* FROM mat_stuff m, event e WHERE m.event_id=e.id AND e.camp_id=$camp_id",
//  "comment"  		  => "SELECT c.* FROM comment c, event e WHERE c.event_id=e.id AND e.camp_id=$camp_id",
  
  // andere Verknüpfung
  "job_day"			=> "SELECT jd.* FROM job_day jd, job j WHERE jd.job_id=j.id AND j.camp_id=$camp_id",
  
  "todo_user_camp" 	=> "SELECT t.* FROM todo_user_camp t, user_camp u WHERE t.user_camp_id=u.id AND u.camp_id=$camp_id",
  
//  "comment_user"	=> "SELECT cu.* FROM comment_user cu, event_responsible r, event e WHERE cu.user_event_id=r.id AND r.event_id=e.id AND e.camp_id=$camp_id" 
);


// Daten auslesen und SQL-Statements erstellen
$sql = "";
foreach( $tables as $table => $qry)
{	
	// Zusatz-Infos zum Schema laden
	$query = "SELECT column_name, data_type, column_type, is_nullable FROM information_schema.columns WHERE table_name='$table'";
	$info = mysql_query($query);
	$column = array();
	while ($tmp = mysql_fetch_assoc($info)) 
	{
		$column[$tmp[column_name]] = $tmp;
	}
				
	$result = mysql_query($qry);
	$row_i = 0;
	$row_num = mysql_num_rows($result);
	$data = "";
	$cols = "";
	
	// Alle Datensätze durchlaufen
	while( $row = mysql_fetch_assoc($result) )
	{
		$row_i++;
		$data .= "(";
		
		$i=0;
		foreach( $row as $key => $value )
		{
			$i++;
			
			// Spaltennamen zusammenfügen (nur beim ersten Datzsatz reicht)
			if( $row_i == 1)
			{
				$cols .= "`".$key."`";
				if($i != count($row)) $cols .= ", ";	
			}
			
			// Daten ausgeben
			if( $value == "" AND $column[$key][is_nullable] == "YES")
			{
				$data .= "NULL";
				// !!!etwas unsauber
				// eigentlich müsste überprüft werden, ob der Datentyp numerisch ist
				// denn bei einem varchar gibt es einen Unterschied zwischen NULL und Leerstring
			}
			else if( $column[$key][data_type] == "blob" )
			{
				$data .= "'".string2hex($value)."'";
			}
			else
				$data .= "'".mysql_real_escape_string($value)."'";
				
			if($i != count($row)) $data .= ", ";
		}
		
		$data .= ")";
		if( $row_i != $row_num )
			$data .= ",\n";
	}
	
	// SQL Statement
	if( $row_num != 0 )
		$sql .= "INSERT INTO `$table` ($cols) VALUES\n$data;\n\n";
}

echo $sql;
?>