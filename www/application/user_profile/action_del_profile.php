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

	$query = "SELECT user_camp.id FROM user_camp WHERE user_id = ".$_user->id;
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	if (mysqli_num_rows($result))
	{	die("Profil kann nicht gelöscht werden!"); }

	$query = "UPDATE camp SET creator_user_id = NULL WHERE creator_user_id = ".$_user->id;
	mysqli_query($GLOBALS["___mysqli_ston"], $query);

	$query = "DELETE FROM user WHERE id = ".$_user->id;
	mysqli_query($GLOBALS["___mysqli_ston"], $query);

	header("Location: logout.php");
	die();
