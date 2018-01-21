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

	$login = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_REQUEST[ 'Login' ] ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

	$query = "	SELECT id, active, acode FROM user WHERE mail = '$login'";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	if( ! mysqli_num_rows( $result ) )
	{
		header( "location: login.php?msg=Angegebene Mailadresse ist nicht registriert!" );
		die();
	}
	
	$active = mysqli_result( $result,  0,  'active' );
	if( $active )
	{
		header( "location: login.php?msg=Account ist bereits aktiviert!<br /> Du kannst dich einloggen!" );
		die();
	}
	
	$user_id = mysqli_result( $result,  0,  'id' );
	$acode 	= mysqli_result( $result,  0,  'acode' );
	if( $acode == "" )
	{
		$acode = md5( microtime() );
		$query = "UPDATE user SET acode = '$acode' WHERE id = ". $user_id;
		mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	}
	
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
													Um dich bei eCamp einloggen zu können, musst du deinen Account aktivieren.
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
	//mail( $login, "eCamp - Willkommen", $text, "From: eCamp Pfadi Luzern <ecamp@pfadiluzern.ch>" );
	
	/*
	$text = urlencode( $text );
 	$subject = urlencode( "eCamp - Passwort ändern" );
	fopen( "http://ecamp2.pfadiluzern.ch/mail.php?to=$login&subject=$subject&message=$text", "r" );
	*/
	
	header( 'location: login.php?msg=Überprüfe nun bitte deine Mailbox.' );
	die();
