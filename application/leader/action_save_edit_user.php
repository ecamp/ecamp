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

	$scoutname	= $_REQUEST['scoutname'];
	$firstname	= $_REQUEST['firstname'];
	$surname	= $_REQUEST['surname'];
	
	$street		= $_REQUEST['street'];
	$zipcode	= $_REQUEST['zipcode'];
	$city		= $_REQUEST['city'];
	
	$mobilnr	= $_REQUEST['mobilnr'];
	$homenr		= $_REQUEST['homenr'];
	
	$ahv		= $_REQUEST['ahv'];
	$birthday	= $_REQUEST['birthday'];
	$jsedu		= $_REQUEST['jsedu'];
	$pbsedu		= $_REQUEST['pbsedu'];
	$jspersnr	= $_REQUEST['jspersnr'];
	$sex		= $_REQUEST['sex'];
	
	$id 		= $_REQUEST['id'];
	
	$birthday = strtotime(preg_replace("/^\s*([0-9]{1,2})[\/\. -]+([0-9]{1,2})[\/\. -]+([0-9]{1,4})/", "\\2/\\1/\\3", $birthday));
	
	$query = "UPDATE user SET 
				scoutname 	= '$scoutname',
				firstname 	= '$firstname',
				surname 	= '$surname',
				
				street 		= '$street',
				zipcode 	= '$zipcode',
				city		= '$city',
				
				mobilnr		= '$mobilnr',
				homenr		= '$homenr',
				
				ahv			= '$ahv',
				birthday	= '$birthday',
				jsedu		= '$jsedu',
				pbsedu		= '$pbsedu',
				jspersnr	= '$jspersnr',
				sex			= '$sex'
		
			WHERE 
				id = '$id'
			LIMIT 1";
	
	mysql_query($query);
	
	header("Location: index.php?app=leader");
	die();
	