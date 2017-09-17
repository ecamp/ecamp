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

	if( $_camp->type == 1)
	{	$query_camptype = "SELECT value, entry 	FROM dropdown WHERE list = 'form'";	}
	else
	{	$query_camptype = "SELECT value, entry 	FROM dropdown WHERE list = 'form' AND item_nr <= 4";	}
	
	$result_camptype = mysql_query($query_camptype);
	$ans_camptype = array();
	
	while( $row = mysql_fetch_assoc($result_camptype) )
	{	$ans_camptype[] = $row;	}
	
	echo json_encode( array("formtype" => $ans_camptype ) );
	die();
?>