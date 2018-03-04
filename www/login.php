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

  #############################################################################
  #
  # Filename:     login.php
  # Beschreibung: Übernimmt den Login-Vorgang
  #
  # ToDo:  - Herausfinden der Berechtigungen nach dem Login   --> user[auth_level]
  #					=> NICHT BEI ANMELDUNG, SONDERN BEI LAGERWAHL!!!
  #        - Überprüfen, wie oft ein Login versucht wurde --> Kennwortrücksetzung anbieten
  #        - Validieren der User-Eingaben
  
	include( "./config.php" );
	include( $lib_dir . "/session.php" );
	include( $lib_dir . "/functions/error.php" );
	require_once( "./lib/PHPTAL.php" );
	
	if( $_SESSION['skin'] == "" ) $_SESSION['skin'] = $GLOBALS['skin'];
	$html = new PHPTAL("public/skin/".$_SESSION['skin']."/login.tpl");
	
	$html->setEncoding('UTF-8');
	$html->set('SHOW_MSG', false);
    $html->set('LOGIN_TYPE', (($GLOBALS['auth'] == "midata") ? "MiData" : "Lokal"));
	
	session_start();

	if(isset( $_REQUEST['msg'] ) )
	{
		$html->set('SHOW_MSG', true);
		$html->set('MSG', $_REQUEST['msg']);
	}
	
	if($_POST['Form'] == "Login")
	{
	    include($lib_dir . "/mysql.php");
		db_connect();
		
		// Verhindern von injection!!!
		$_POST['Login'] = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['Login']);

        if($_POST['Login'])
        {
            // Get MiData Auth-Token
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL 			=> "https://db.scout.ch/users/sign_in.json?person[email]=".urlencode($_POST['Login'])."&person[password]=".urlencode($_POST['Passwort']),
                CURLOPT_RETURNTRANSFER 	=> true,
                CURLOPT_ENCODING 		=> "",
                CURLOPT_HTTP_VERSION 	=> CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST 	=> "POST"
            ));
            $result	= json_decode(curl_exec($curl), true);
            $href	= $result['people'][0]['href'];
            $token	= $result['people'][0]['authentication_token'];

            // Get details of person
            curl_setopt_array($curl, array(
                CURLOPT_URL 			=> $href."?user_email=".urlencode($_POST['Login'])."&user_token=".$token,
                CURLOPT_CUSTOMREQUEST 	=> "GET"
            ));
            $result	= json_decode(curl_exec($curl), true);

            if($result)
            {
                // Check if member of group
                $groups = $result['linked']['groups'];

                $i = $result['people'][0];

                $id			= $i['id'];
                $mail		= $i['email'];
                $pw			= md5($_POST['Passwort']);
                $scoutname	= $i['nickname'];
                $firstname	= $i['first_name'];
                $surname	= $i['last_name'];
                $street		= (isset($i['address'])) ? $i['address'] : "NULL";
                $zipcode	= (isset($i['zip_code'])) ? $i['zip_code'] : "NULL";
                $city		= (isset($i['town'])) ? $i['town'] : "NULL";
                $birthday	= (isset($i['birthday'])) ? $i['birthday'] : "NULL";
                $ahvnr      = (isset($i['ahv_nummer'])) ? $i['ahv_nummer'] : "NULL";
                $sex		= (isset($i['gender'])) ? (($i['gender'] == "m") ? 0 : 1) : "NULL";
                $jspersnr	= (isset($i['j_s_number'])) ? $i['j_s_number'] : "NULL";
                $admin		= 0;
                $active		= 1;

                $j = $result['linked'];

                foreach ($j['phone_numbers'] as $phone_number){
                    if ($phone_number['label'] == "Privat"){
                        $priv_number = $phone_number['number'];
                    }elseif ($phone_number['label'] == "Mobil"){
                        $mobile_number = $phone_number['number'];
                    }
                }

                // Format birthday
                require_once( $GLOBALS['lib_dir'] . "/functions/date.php" );
                if($birthday != "NULL")
                {
                    $d = date_create($birthday);
                    $d = date_format($d, "d-m-Y");
                    $date = new c_date;
                    $date->setString($d);
                    $birthday = $date->getValue();
                }

                // Check if already in db
                $query = "SELECT * FROM user WHERE id=$id LIMIT 1;";
                if(mysqli_num_rows(mysqli_query($GLOBALS['___mysqli_ston'],$query)))
                {
                    $query = "
                        UPDATE user SET
                        mail='$mail',pw='$pw',scoutname='$scoutname',firstname='$firstname',surname='$surname',street='$street',
                        zipcode='$zipcode',city='$city',homenr='$priv_number',mobilnr='$mobile_number',birthday='$birthday',ahv='$ahvnr',sex=$sex,jspersnr='$jspersnr'
                        WHERE id=$id;
                    ";
                }
                else
                {
                    $query = "
                        INSERT INTO user
                        (id, mail, pw, scoutname, firstname, surname, street, zipcode, city, homenr, mobilenr, birthday, ahv, sex, jspersnr, admin, active)
                        VALUES
                        ($id, '$mail', '$pw', '$scoutname', '$firstname', '$surname', '$street', '$zipcode', '$city', $priv_number, $mobile_number, '$birthday', $ahvnr, $sex, '$jspersnr', $admin, $active)
                    ";
                }

                mysqli_query($GLOBALS['___mysqli_ston'],$query);
            }
            else
            {
                $html->set('SHOW_MSG', true);
                $html->set('MSG', "MiData Anmeldung fehlgeschlagen.");
            }
            curl_close($curl);

        }

		$query = "SELECT pw, id, scoutname, firstname, active, last_camp FROM user WHERE mail = '" . $_POST['Login'] . "' LIMIT 1";
		$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
		
		if(mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_assoc($result);
			if($row['active'] == 1)
			{
				if(md5($_POST['Passwort']) == $row['pw'])
				{				
					$user_id = $row['id'];

					if( $_REQUEST['autologin'] )
					{	autologin_setup( $user_id );	}
					
					session_setup( $user_id );
					
					header("Location: index.php");                    
					die();
				}
				else
				{
					$html->set('SHOW_MSG', true);
					$html->set('MSG', "Login ist fehlgeschlagen.");
				}
			}
			else
			{
				$html->set('SHOW_MSG', true);
				$html->set('MSG', "	Du musst deinen Account zuerst aktivieren. 
									<br /><br /><a href='resendacode.php'>Wie aktiviere ich meinen Account?</a>");
			}
		}
		else
		{
			$html->set('SHOW_MSG', true);
			$html->set('MSG', "Login ist fehlgeschlagen.");
		}
	}

	if( isset( $_COOKIE['autologin'] ) && $_COOKIE['autologin'] && isset( $_COOKIE['auth_key'] ) && is_numeric( $_COOKIE['user_id'] ) )
	{
	    include($lib_dir . "/mysql.php");
		db_connect();
		
		$user_id 	= $_COOKIE['user_id'];
		$auth_key 	= md5( $_COOKIE['auth_key'] );
		
		$query = "SELECT id FROM user WHERE id = $user_id AND auth_key = '" . $auth_key . "'";
		$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		
		if( mysqli_num_rows( $result ) )
		{
			session_setup( $user_id );
			
			header( "Location: index.php" );
			die();
		}
		else
		{
			setcookie( 'autologin', false );
			setcookie( 'user_id', '' );
			setcookie( 'auth_key', '' );
		}
	}

	echo $html->execute();
