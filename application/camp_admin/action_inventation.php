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


  $user_camp_id = mysql_real_escape_string($_REQUEST[user_camp_id]);
  $accept       = mysql_real_escape_string($_REQUEST[accept]);
	
  if($accept == "Annehmen")	{	$accept = 1;	}
  else						{	$accept = 0;	}
	
  $query = "SELECT * FROM user_camp WHERE id='$user_camp_id' AND user_id='$_user->id'";
  $result = mysql_query($query);
  
  if( mysql_num_rows($result) == 0 )
  {
  	// error
	echo "error";
	die();
  }
  
  $user_camp = mysql_fetch_assoc( $result );
  
  // Update vornehmen
  if( $accept == 1 )
  {
  	$query = "SELECT scoutname, firstname, surname FROM user WHERE id = " . $user_camp['user_id'];
    $result = mysql_query( $query );
    $user = mysql_fetch_assoc( $result );
    
    $query = "SELECT id, short_name FROM camp WHERE id = " . $user_camp['camp_id'];
    $result = mysql_query( $query );
    $camp = mysql_fetch_assoc( $result );
    
    if( $user['scoutname'] )	{	$leader = $user['scoutname'];	}
    else						{	$leader = $user['firstname'] . " " . $user['surname'];	}
    
    $_news->add2camp( "Neuer Leiter im Team", "$leader hat der Mitarbeit im Lager '" . $camp['short_name'] . "' zugestimmt.", time(), $camp['id'] );
	$_news->add2user( "Teilnahme an einem Lager zugestimmt", "Du hast der Mitarbeit am Lager '" . $camp['short_name'] . "' zugestimmt.", time(), $_user->id );
    
    
    
    
    mysql_query("UPDATE user_camp SET active='1' WHERE id='$user_camp_id'");
   
  }
  else if( $accept == 0 )
  {
  	mysql_query("DELETE FROM user_camp WHERE id='$user_camp_id'");
  }
  
  
  header("Location: index.php?app=camp_admin");
  die();

?>
