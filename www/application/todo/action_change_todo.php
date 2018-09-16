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

	$title = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['title']);
	$text 	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['text']);
	$date 	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['date']);
	$id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['id']);
	
	$_camp->todo($id) || die("error");

	if ($title == "" || $date == "")
	{	header("Location: index.php?app=todo"); }
	
	$date = preg_match("/([0-9]{1,2})[\/\. -]+([0-9]{1,2})[\/\. -]+([0-9]{1,4})/", $date, $regs);
	$date = gmmktime(0, 0, 0, $regs[2], $regs[1], $regs[3]);
	
	$todo_date = new c_date();
	$todo_date->setUnix($date);
	
	$query = "UPDATE todo SET title='$title', short='$text', date='".$todo_date->getValue()."' WHERE id = $id";
	mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	header("Location: index.php?app=todo");
	die();
