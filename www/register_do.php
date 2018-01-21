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

	include("./config.php");
	include($lib_dir . "/mysql.php");
	include($lib_dir . "/functions/mail.php");
	db_connect();
	
	require_once( "./lib/recaptchalib.php" );

	//	CHECK ALL INPUTS:
	// ===================
	$resp = recaptcha_check_answer ($GLOBALS['captcha_prv'], $_SERVER["REMOTE_ADDR"],
									$_REQUEST["recaptcha_challenge_field"],
									$_REQUEST["recaptcha_response_field"]	);

	if (!$resp->is_valid)
	{	header( 'location: register.php?msg=Bitte CAPTCHA richtig abschreiben!' );	die();	}
	
	if( $_REQUEST[ 'Login' ] == "" )
	{	header( 'location: register.php?msg=eMail - Adresse muss angegeben werden!' );	die();	}
	
	if( !filter_var( $_REQUEST[ 'Login' ], FILTER_VALIDATE_EMAIL) )
	{	header( 'location: register.php?msg=Eine gültige eMail - Adresse muss angegeben werden!' );	die();	}
	
	if( $_REQUEST[ 'Passwort1' ] == "" )
	{	header( 'location: register.php?msg=Passwort muss angegeben werden!' );	die();	}
	
	if( $_REQUEST[ 'Passwort2' ] == "" )
	{	header( 'location: register.php?msg=Wiederholung muss angegeben werden!' );	die();	}
	
	if( $_REQUEST[ 'firstname' ] == "" )
	{	header( 'location: register.php?msg=Vorname muss angegeben werden!' );	die();	}
	
	if( $_REQUEST[ 'surname' ] == "" )
	{	header( 'location: register.php?msg=Nachname muss angegeben werden!' );	die();	}
	
	$login 	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'Login' ] );
	$pw1	= md5( $_REQUEST[ 'Passwort1' ] );
	$pw2	= md5( $_REQUEST[ 'Passwort2' ] );
	
	$scoutname 	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'scoutname' ] );
	$firstname 	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'firstname' ] );
	$surname 	= mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'surname' ] );

	if( $pw1 != $pw2 )
	{	header( 'location: register.php?msg=Passwort unstimmig' );	die();	}

	$query = "SELECT user.id FROM user WHERE user.mail = '" . $login . "'";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	if( mysqli_num_rows( $result ) )
	{	header( 'location: register.php?msg=eMail-Adresse ist bereits registriert' );	die();	}
	
	//	INSERT NEW USER:
	// ==================
	$acode = md5( time() . $pw1 );

	$query = "	INSERT INTO user ( `mail`, `pw`, `scoutname`, `firstname`, `surname`, `acode` )
				VALUES ( '$login', '$pw1', '$scoutname', '$firstname', '$surname', '$acode' );";
mysqli_query($GLOBALS["___mysqli_ston"],  $query );

	$user_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);

	//	SEND MAIL FOR ACTIVATION:
	// ===========================
$text = <<<___MAILBODY
<table width="100%">
    <tbody>
		<tr>
			<td align="center">
				<table border="0" width="550">
					<tbody>
						<tr>
							<td valign="top" align="left" width="200"><h1>eCamp v2</h1></td>
							<td valign="top" align="rigth" width="200"><img alt="eCamp v2" src="https://ecamps.ch/logo.gif"></td>
						</tr>
					</tbody>
				</table>
				<br />
				<table width="550" cellpadding="0" cellspacing="0" border="0">
					<tbody>
						<tr>
							<td width="15"></td>
							<td align="left" width="535">
								<table width="507" cellpadding="0" cellspacing="0" border="0">
									<tbody>
										<tr>
											<td>
												<p style="padding-left: 5px;">
													eCamp - Willkommen
													<br />
													Um dich bie eCamp einloggen zu können, musst du deinen Account aktivieren.
													Zu diesem Zweck musst du nachfolgendem Link folgen:
													<br />
													<br />
													<a href="$GLOBALS[base_uri]activate.php?user_id=$user_id&login=$login&acode=$acode">$GLOBALS[base_uri]activate.php?user_id=$user_id&login=$login&acode=$acode</a>
												</p>

												<br />
												<br />
												<br />
												<br />

												<table style="padding-left: 5px; color: #888888;" width="507" cellpadding="5" cellspacing="0" border="0">
													<tbody>
														<tr>
															<td style="border-top: 1px dashed #888888; border-bottom: 1px dashed #888888;">
																<b>Hinweis:</b>
																<br />
																Diese Mail wurde durch den Mailbot von <a href="https://www.ecamps.ch/">ecamps.ch</a> versendet.
																<br />
																Antworten Sie nicht auf diese Mail. Die Nachrichten werden vom Server abgelehnt.
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
___MAILBODY;

	ecamp_send_mail($login, "eCamp - Willkommen", $text);
	
	header( 'location: login.php?msg=Vor dem ersten Login muss der Account aktiviert werden. Dafür bitte Mailbox überprüfen.' );
	die();
