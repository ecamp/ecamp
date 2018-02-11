<?php
	/*
	 * Copyright (C) 2017 Caspar Brenneisen
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

	$_page->html->set('main_macro', $GLOBALS['tpl_dir'].'/application/mail/home.tpl/home');

	if(isset($_GET['mailtest'])){
		$mailBody = <<<___MAILBODY
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
													Dies ist eine Testmail!
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

		ecamp_send_mail($_GET['mailtest'],'Testmail von '.$GLOBALS['base_uri'],$mailBody);
	}
