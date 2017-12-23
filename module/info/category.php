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

	$cat_content = "";
	$query = "SELECT * FROM category WHERE camp_id = $_camp->id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	while($row = mysqli_fetch_assoc($result))
	{
		$cat_content .= "<tr bgcolor='#$row[color]'><td align='center'>". htmlentities_utf8($row['name']) ."</td></tr>";
	}
	
	$_page->html->set( 'info_box_content', $cat_content );
	$_page->html->set( 'info_box_title', "Blocktypen:" );
