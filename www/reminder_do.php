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

	require '../vendor/autoload.php';
	use Phelium\Component\reCAPTCHA;

	include("./config/config.php");
	include($lib_dir . "/mysql.php");
	include($lib_dir . "/functions/mail.php");
	db_connect();

	$captcha = new reCAPTCHA($GLOBALS['captcha_pub'], $GLOBALS['captcha_prv']);
	
	if (!$captcha->isValid($_POST['g-recaptcha-response']))
	{	header( 'location: reminder.php?msg=Bitte CAPTCHA richtig abschreiben!' );	die();	}

	$login = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'Login' ] );

	$query = "	SELECT id, pw, active FROM user WHERE mail = '$login'";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	if( ! mysqli_num_rows( $result ) )
	{
		header( "location: login.php" );
		die();
	}
	
	$user_id 		= mysqli_result( $result,  0,  'id' );
	$user_pw 		= mysqli_result( $result,  0,  'pw' );
	$user_active 	= mysqli_result( $result,  0,  'active' );

	if( ! $user_active )
	{
		header( "location: login.php" );
		die();
	}

	$acode = microtime() . $user_pw;
	$acode = md5( $acode );

	$query = "	UPDATE  user SET  `acode` =  '$acode' WHERE id = $user_id";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );

	//	SEND MAIL FOR REMINDER:
	// =========================
$text = <<<___MAILBODY
<table width="100%">
    <tbody>
		<tr>
			<td align="center">
				<table border="0" width="550">
					<tbody>
						<tr>
							<td valign="top" align="left" width="200"><h1>eCamp v2</h1></td>
							<td valign="top" align="rigth" width="200"><img alt="eCamp v2" src="https://ecamp.pfadiluzern.ch/logo.gif"></td>
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
													eCamp - Passwort ändern
													<br />
													Um das Passwort zu ändern, musst du dem nachfolgendem Link folgen:
													<br />
													<br />
													<a href="$GLOBALS[base_uri]pwreset.php?user_id=$user_id&login=$login&acode=$acode">$GLOBALS[base_uri]pwreset.php?user_id=$user_id&login=$login&acode=$acode</a>
												</p>

												<br />

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

	ecamp_send_mail($login, "eCamp - Passwort ändern", $text);
	//mail( $login, "eCamp - Passwort ändern", $text, "From: eCamp Pfadi Luzern <ecamp@pfadiluzern.ch>" );
	
	/*
	$text = urlencode( $text );
 	$subject = urlencode( "eCamp - Passwort ändern" );
	fopen( "http://ecamp2.pfadiluzern.ch/mail.php?to=$login&subject=$subject&message=$text", "r" );
	*/

	header( 'location: login.php?msg=Überprüfe deine Mailbox. Mit dem Link im Mail kann das Passwort neu gesetzt werden.' );
	die();
