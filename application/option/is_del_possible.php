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

	$cat_id	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['category_id']);
	
	$_camp->category( $cat_id ) || die( "error" );

	$query = "SELECT * FROM category WHERE id = '$cat_id' AND camp_id='$_camp->id'";
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	if( mysqli_num_rows($result) == 0 )
	{
		// Keine Berechtigung oder Kategorie existiert nicht
		$ans = array( "error" => true, "msg" => "Keine Berechtigung" );
		echo json_encode( $ans );
		die();
	}
	
	$category = mysqli_fetch_assoc($result);
	
	$query = "SELECT id FROM event WHERE category_id='$category[id]'";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	$num_failure = mysqli_num_rows( $result );
	
	if( $num_failure > 0 )
	{
	    // Es existieren Events zu dieser Kategorie

		$ans = array( "error" => false, "del" => false, "msg" => "Diese Kategory kann nicht gelöscht werden, da ihr $num_failure Programmblöcke zugeordnet sind. Bitte lösche erst die Blöcke, oder weise ihnen eine andere Kategorie zu, und wiederhole dann den Löschvorgang" );
		echo json_encode( $ans );
		die();
	}
	
	$ans = array( "error" => false, "del" => true );
	echo json_encode( $ans );
	die();
