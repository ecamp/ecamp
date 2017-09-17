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

	$type = mysql_real_escape_string($_REQUEST[type]);
	$camp_id = $_camp->id;

	if( ($type>=1) && ($type<=5) )
	{
		$sql = implode("",file("./template/application/aim/sql/course_aim_".$type.".sql"));

		eval ("\$sql = \"$sql\";");
		$queries = explode(";",$sql);
		
		foreach( $queries as $query )
		{
			//echo $query."\n";
			mysql_query($query);
			//echo mysql_error()."\n";
		}
	}

	header("Location:index.php?app=aim");
	die();
?>
