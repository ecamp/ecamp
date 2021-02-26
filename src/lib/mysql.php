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

	function db_connect()
	{
		($GLOBALS["___mysqli_ston"] = mysqli_connect($GLOBALS['host'],  $GLOBALS['us'],  $GLOBALS['pw'], $GLOBALS['db'], $GLOBALS['db_port'])) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		// mysqli_select_db($GLOBALS["___mysqli_ston"], $GLOBALS['db']) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		mysqli_query($GLOBALS["___mysqli_ston"], "SET NAMES 'utf8'");
		mysqli_query($GLOBALS["___mysqli_ston"], "SET CHARACTER SET 'utf8'");

		# disable SQL Modes introduced with MySQL 5.7 and MySQL 8 (our queries are not compatible with these modes)
		mysqli_query($GLOBALS["___mysqli_ston"], "SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
		mysqli_query($GLOBALS["___mysqli_ston"], "SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'STRICT_TRANS_TABLES',''));");
		mysqli_query($GLOBALS["___mysqli_ston"], "SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'TRICT_ALL_TABLES',''));");
		
	}

	function mysqli_result($res,$row=0,$col=0){
		$numrows = mysqli_num_rows($res);
		if ($numrows && $row <= ($numrows-1) && $row >=0){
			mysqli_data_seek($res,$row);
			$resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
			if (isset($resrow[$col])){
				return $resrow[$col];
			}
		}
		return false;
	}
