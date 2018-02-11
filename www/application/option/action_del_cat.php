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

	$cat_del_id 	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['category_id']);
	
	$_camp->category( $cat_del_id ) || die( "error" );
		//TESTEN OB NOCH BLÖCKE IN DIESER KATEGORIE SIND
		$query = "SELECT id FROM event WHERE category_id='$cat_del_id'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		$num_failure = mysqli_num_rows( $result );
	
		if( $num_failure > 0 )
		{
			$ans = array( "error" => true, "msg" => "Diese Kategorie kann nicht gelöscht werden, da ihr $num_failure Programmblöcke zugeordnet sind. Bitte lösche erst diese Blöcke, oder weise ihnen eine andere Kategorie zu, und wiederhole dann den Löschvorgang." );
			echo json_encode( $ans );
			die();
		}
		
		// LÖSCHEN:
		$query = "DELETE FROM category WHERE id = '$cat_del_id' and camp_id='$_camp->id'";
		mysqli_query($GLOBALS["___mysqli_ston"], $query);
		
	//header("Location: index.php?app=option");
	$ans = array( "error" => false );
	echo json_encode( $ans );
	die();
	