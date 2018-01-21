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

	$resp = recaptcha_check_answer ($GLOBALS['captcha_prv'], $_SERVER["REMOTE_ADDR"],
									$_REQUEST["recaptcha_challenge_field"],
									$_REQUEST["recaptcha_response_field"]	);
	
	if (!$resp->is_valid)
	{	header( 'location: reminder.php?msg=Bitte CAPTCHA richtig abschreiben!' );	die();	}

	$login = mysql_escape_string( $_REQUEST[ 'Login' ] );

	$query = "	SELECT id, pw, active FROM user WHERE mail = '$login'";
	$result = mysql_query( $query );
	
	if( ! mysql_num_rows( $result ) )
	{
		header( "location: login.php" );
		die();
	}
	
	$user_id 		= mysql_result( $result, 0, 'id' );
	$user_pw 		= mysql_result( $result, 0, 'pw' );
	$user_active 	= mysql_result( $result, 0, 'active' );

	if( ! $user_active )
	{
		header( "location: login.php" );
		die();
	}

	$acode = microtime() . $user_pw;
	$acode = md5( $acode );

	$query = "	UPDATE  user SET  `acode` =  '$acode' WHERE id = $user_id";
	$result = mysql_query( $query );

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
													eCamp - Passwort ändern
													<br />
													Um das Passwort zu ändern, musst du dem nachfolgendem Link folgen:
													<br />
													<br />
													<a href="$GLOBALS[base_uri]pwreset.php?user_id=$user_id&login=$login&acode=$acode">$GLOBALS[base_uri]pwreset.php?user_id=$user_id&login=$login&acode=$acode</a>
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

	ecamp_send_mail($login, "eCamp - Passwort ändern", $text);
	//mail( $login, "eCamp - Passwort ändern", $text, "From: eCamp Pfadi Luzern <ecamp@pfadiluzern.ch>" );
	
	/*
	$text = urlencode( $text );
 	$subject = urlencode( "eCamp - Passwort ändern" );
	fopen( "http://ecamp2.pfadiluzern.ch/mail.php?to=$login&subject=$subject&message=$text", "r" );
	*/

	header( 'location: login.php?msg=Überprüfe deine Mailbox. Mit dem Link im Mail kann das Passwort neu gesetzt werden.' );
	die();
