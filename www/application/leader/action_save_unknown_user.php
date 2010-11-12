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

	$scoutname	= $_REQUEST[scoutname];
	$firstname	= $_REQUEST[firstname];
	$surname	= $_REQUEST[surname];
	
	$street		= $_REQUEST[street];
	$zipcode	= $_REQUEST[zipcode];
	$city		= $_REQUEST[city];
	
	$mail		= $_REQUEST[mail];
	$mobilnr	= $_REQUEST[mobilnr];
	$homenr		= $_REQUEST[homenr];
	
	$ahv		= $_REQUEST[ahv];
	$birthday	= $_REQUEST[birthday];
	$jsedu		= $_REQUEST[jsedu];
	$pbsedu		= $_REQUEST[pbsedu];
	$jspersnr	= $_REQUEST[jspersnr];
	$sex		= $_REQUEST[sex];
	
	$function	= $_REQUEST['function'];
	
	
	
	$query = "SELECT * FROM user WHERE mail = '$mail'";
	$result = mysql_query($query);
	if(mysql_num_rows($result) > 0)
	{	
		header("Location: index.php?app=leader");
		die();
	}
	
	$birthday = strtotime(preg_replace("/^\s*([0-9]{1,2})[\/\. -]+([0-9]{1,2})[\/\. -]+([0-9]{1,4})/", "\\2/\\1/\\3", $birthday));
	
	
	$query = "INSERT INTO user (`mail` ,`pw` ,`scoutname` ,`firstname` ,`surname` ,`street` ,`zipcode` ,`city` ,`homenr` ,`mobilnr` ,
								`birthday` ,`ahv` ,`sex` ,`jspersnr` ,`jsedu` ,`pbsedu` ,`regtime` ,`active` ,`acode` ,`admin`)
	
	VALUES ('$mail', '0', '$scoutname', '$firstname', '$surname', '$street', '$zipcode', '$city', '$homenr', '$mobilnr', 
			'$birthday', '$ahv', '$sex', '$jspersnr', '$jsedu', '$pbsedu', '0', '0', '0', '0')";
	
	mysql_query($query);
	
	
	
	$query = "SELECT LAST_INSERT_ID() FROM user";
	$result = mysql_query($query);
	$user = implode(mysql_fetch_assoc($result));
	
	
	
	$query = "SELECT * FROM user_camp WHERE user = '$user' AND camp = '$camp_id'";
	$result = mysql_query($query);
	
	if($mysql_num_rows == 0)
	{
		$query = "INSERT INTO user_camp 	(user ,camp ,function)
								VALUES 		('$user', '$camp_id', '$function')";
		$result = mysql_query($query);
		//echo $query;
	}
	
	
	header("Location: index.php?app=leader");
	die();
	
?>