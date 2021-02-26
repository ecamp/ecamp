<span metal:define-macro="home" tal:omit-tag="" >
                        <table width="100%">
							<tr tal:condition="camp_info/firsttime">
								<td bgcolor="#ff9922" style="border:5px solid red;">
									<center>
										<b style="font-size:20px">Wichtig!!</b>
										<p style="font-size:14px; width:90%;">
											<img src="public/global/img/warning.png" align="left" />
											<img src="public/global/img/warning.png" align="right" />
											
											Nach dem Eintragen der Lagerdetails/Kursdetails auf dieser Seite, sollten als nächstes 
											unbedingt ein paar Einstellungen zum Lager vorgenommen werden!
											<br />
											<br />
											Die Einstellungen müssen vor dem Beginn der Planung festgelegt werden.
											Spätere Änderungen können eingeschränkt sein und zu Missverständnissen führen!
											<br />
											<br />
											
											<a href="index.php?app=option" style="font-size:14px;">[Zu den Einstellungen]</a>
											
											<br />
											<div style="position: absolute; right: 5px; top:0px;">
												<a href="index.php?app=camp" style="color:white">Warnung ausblenden</a>
											</div>
										</p>
									</center>
								</td>
							</tr>
							
							<tr><td align="left">
                                    <div align="left">Hier kannst du allgemeine Infos und Zeitpunkt des Lagers/Kurses bestimmen. Daten auf dieser Seite k&ouml;nnen nur vom Lagerleiter/Kursleiter oder vom Ersteller bearbeitet werden.<br />
                                      <br />
                                    </div>
                            </td></tr>
                        </table>
                        <center>
						<table width="90%" border="0">
							<colgroup>
								<col width="28%"></col>
								<col width="72%"></col>
							</colgroup>
							
							<tr><td align="left"><b>Informationen zum Lager/Kurs:</b></td><td></td></tr>
							
							<tr style="height:23px">
								<td>
									<span tal:condition="not: camp/is_course">Pfadi / Gruppe:</span>
									<span tal:condition="camp/is_course">Veranstalter / Organisator:</span>
								</td>
								<td tal:content="camp_info/base" style="padding-left:5px" />
							</tr>
							
							<tr>
								<td align="left">
									<span tal:condition="not: camp/is_course">Pfadi / Gruppe (Freitext):</span>
									<span tal:condition="camp/is_course">Veranstalter / Organisator (Freitext):</span>
								</td>
                                <td align="left">
									<input type="text" name="value" id="camp_group_name" style="width: 100%" tal:attributes="value camp_info/group_name/value" />
								</td>
							</tr>
                            
							<tr>
								<td align="left">
									<span tal:condition="not: camp/is_course">Lagername:</span>
									<span tal:condition="camp/is_course">Kursbezeichnung:</span>
								</td>
                                <td align="left">
									<input type="text" name="value" id="camp_name" style="width: 100%" tal:attributes="value camp_info/name/value" />
								</td>
							</tr>
							<tr>
								<td align="left">
									<span tal:condition="not: camp/is_course">Kurzer Anzeigenamen:</span>
									<span tal:condition="camp/is_course">Kursnummer:</span>
								</td>
								<td align="left">
									<input type="text" name="value" id="camp_short_name" style="width: 100%" tal:attributes="value camp_info/short_name/value" />
								</td>
							</tr>
							<tr>
                            	<td align="left">Motto/Thema:</td>
								<td align="left">
									<input type="text" name="value" id="camp_slogan" style="width: 100%" tal:attributes="value camp_info/slogan/value" />
								</td>
							</tr>
                            
							<tr tal:condition="camp_info/is_course">
								<td align="left">Leiterkurs:</td>
								<td align="left" tal:content="camp_info/type" />
							</tr>
							
							
						</table>

						<br /><br />
						
						
						<table width="90%" border="0" >
							<colgroup>
								<col width="28%"></col>
								<col width="40px"></col>
								<col width="10px"></col>
								<col width="40px"></col>
								<col width="15px"></col>
								<col width="40px"></col>
								<col width="10px"></col>
								<col width="100px"></col>
								<col width="100px"></col>
								<col width="*"></col>
							</colgroup>
							
							<tr>
								<td align="left"><b>Lageradresse:</b></td>
								<td colspan="8"> </td>
								<td rowspan="8" style="text-align:right;">
									<div id="mapcontainer" style="margin-left:20px; width:100%; height:200px; border:1px solid black; background-color:white;"></div>
								</td>
							</tr>
							
							<tr>
								<td align="left">Name:</td>
								<td align="left" colspan="8">
									<input type="text" name="value" id="camp_ca_name" style="width: 100%" tal:attributes="value camp_info/ca_name/value" />
								</td>
							</tr>
							
							<tr>
								<td align="left">Strasse:</td>
								<td align="left" colspan="8">
									<input type="text" name="value" id="camp_ca_street" style="width: 100%" tal:attributes="value camp_info/ca_street/value" />
								</td>
							</tr>
							
                            <tr>
								<td align="left">PLZ:</td>
								<td align="left" colspan="8">
									<input type="text" name="value" id="camp_ca_zipcode" style="width: 100%" tal:attributes="value camp_info/ca_zipcode/value" />
								</td>
							</tr>
                            
							<tr>
								<td align="left">Ort:</td>
								<td align="left" colspan="8">
									<input type="text" name="value" id="camp_ca_city" style="width: 100%" tal:attributes="value camp_info/ca_city/value" />
								</td>
							</tr>
							
							<tr>

								<td align="left">Telefon:</td>
								<td align="left" colspan="8">
									<input type="text" name="value" id="camp_ca_tel" style="width: 100%" tal:attributes="value camp_info/ca_tel/value" />
								</td>

							</tr>
                            
                            <tr>
								<td align="left">Koordinaten:</td>
								
								<td align="left">
									<input  maxlength="3" type="text" name="value1" id="camp_ca_coor1" style="width: 30px" tal:attributes="value camp_info/ca_coor/value1" />
								</td>
								<td style="vertical-align: middle">/</td>
								<td align="left">
									<input maxlength="3" type="text" name="value2" id="camp_ca_coor2" style="width: 30px" tal:attributes="value camp_info/ca_coor/value2" />
								</td>
								<td style="vertical-align: middle">//</td>
								<td align="left">
									<input  maxlength="3" type="text" name="value3" id="camp_ca_coor3" style="width: 30px" tal:attributes="value camp_info/ca_coor/value3" />
								</td>
								<td style="vertical-align: middle">/</td>
								<td align="left">
									<input maxlength="3" type="text" name="value4" id="camp_ca_coor4" style="width: 30px" tal:attributes="value camp_info/ca_coor/value4" />
								</td>
								<td align="left">
									<input type="button" id="camp_show_map" value="Karte anzeigen" />
								</td>
							</tr>
							<tr>
								<td align="left" colspan="9"></td>
							</tr>
						</table>
                        <br /><br />
                        
                        <table width="90%" id="subcamp_list">
	                        <colgroup>
	                        	<col width="28%" />
	                        	<col width="72%" />
	                        </colgroup>
	                        <tr>
                          		<td align="left">
                            		<b>Lagerdauer:</b>
                            	</td>
                       	  		<td></td>
                        	</tr>
                        	
                            <tr tal:repeat="subcamp camp_info/subcamps" class="camp_subcamp">
                                <td align="left" class="date"><tal:block content="subcamp/start" /> - <tal:block content="subcamp/end" /></td>
                                <td align="left" tal:condition="php: user_camp.auth_level >= 50">
                                    <a href="#" class="delete"><img src="public/global/img/del.png" border="0" /></a>
                                    
                                    <input type="button" class="change" style="width:140px;" value="Zeitfenster ver&auml;ndern" />
                                    <input type="button" class="move" style="width:140px;" value="Programm verschieben" />
                                    
                                    <input type="hidden" class="subcamp_start" 	tal:attributes="value subcamp/start" />
                                    <input type="hidden" class="subcamp_end"	tal:attributes="value subcamp/end" />
                                    <input type="hidden" class="subcamp_id" tal:attributes="value subcamp/id" />
                                        
                                    <form class="delete_form">
                                    	<input type="hidden" name="subcamp_id" tal:attributes="value subcamp/id" />
                                        <input type="hidden" name="app" value="camp" />
                                        <input type="hidden" name="cmd" value="action_del_subcamp" />
                                    </form>
                                    
                                </td>
                            </tr>
                            
                            <tr tal:condition="php: user_camp.auth_level >= 50">
                            	<td><input class="add_subcamp" style="width:40px;" type="button" value="&nbsp;+&nbsp;" /></td>
                                <td></td>
                            </tr>
                        
                        </table>
                        
                        <table width="90%" border="0">
                        	 <tr>
                             <td align="left"><img src="public/global/img/wait.gif" class="hidden" id="busy_gif" /></td>
                            	<td align="right">&nbsp;</td>
                          </tr>
                        </table>
                        <table width="90%" border="0">
                        	 <tr>
                             	<td align="left">
                                    <div align="left" style="font-size:11px;">Zeitfenster ver&auml;nden = Das Lager kann nach hinten/vorne verk&uuml;rzt oder verl&auml;ngert werden. Das Lager kann nicht verk&uuml;rzt werden, falls dadurch Programmbl&ouml;cke verloren gehen. Alle Programmbl&ouml;cke bleiben an ihrem urspr&uuml;nglichen Datum.<br />
                                    <br />Programm verschieben = Das ganze Lager wird auf ein neues Startdatum verschoben. Alle Programmbl&ouml;cke verschieben sich dementsprechend.</div>
                                </td>
                            </tr>
                        </table>
                        
						</center>
</span>
