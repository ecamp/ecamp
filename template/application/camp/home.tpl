<p metal:define-macro="home">
	<p tal:condition="camp_info/firsttime">
		<b>Wichtig!!</b>
		<p>
			<img src="public/global/img/warning.png" />
			<img src="public/global/img/warning.png" />
			Nach dem Eintragen der Lagerdetails/Kursdetails auf dieser Seite, sollten als nächstes unbedingt ein paar Einstellungen zum Lager vorgenommen werden!
			<br />
			<br />
			Die Einstellungen müssen vor dem Beginn der Planung festgelegt werden. Spätere Änderungen können eingeschränkt sein und zu Missverständnissen führen!
			<br />
			<br />
			<a href="index.php?app=option" style="font-size:14px;">[Zu den Einstellungen]</a>
			<br />
			<a href="index.php?app=camp" style="color:white">Warnung ausblenden</a>
		</p>
	</p>

    <div class="alert alert-success">
 		Hier kannst du allgemeine Infos und Zeitpunkt des Lagers/Kurses bestimmen. Daten auf dieser Seite k&ouml;nnen nur vom Lagerleiter/Kursleiter oder vom Ersteller bearbeitet werden.
	</div>
	<div class="form-horizontal">
		<label class="col-sm-12">Informationen zum Lager/Kurs:</label>
		<div class="clearfix"></div>
		<div class="space-top"></div>
		<div class="form-group">
			<label tal:condition="not: camp/is_course" for="labelGroup" class="col-sm-2 control-label">Pfadi / Gruppe:</label>
			<label tal:condition="camp/is_course" for="inputVeranstalter" class="col-sm-2 control-label">Veranstalter / Organisator:</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="Login" placeholder="Email" name="Login" />
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="space-top"></div>
		<div class="form-group">
			<label tal:condition="not: camp/is_course" for="camp_group_name" class="col-sm-2 control-label">Pfadi / Gruppe (Freitext):</label>
			<label tal:condition="camp/is_course" for="camp_group_name" class="col-sm-2 control-label">Veranstalter / Organisator (Freitext):</label>
			<div class="col-sm-10">
				<input tal:attributes="value camp_info/group_name/value" type="text" class="form-control" id="camp_group_name" placeholder="Email" name="value" />
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="space-top"></div>
		<div class="form-group">
			<label tal:condition="not: camp/is_course" for="camp_name" class="col-sm-2 control-label">Lagername:</label>
			<label tal:condition="camp/is_course" for="camp_name" class="col-sm-2 control-label">Kursbezeichnung:</label>
			<div class="col-sm-10">
				<input tal:attributes="value camp_info/name/value" type="text" class="form-control" id="camp_name" placeholder="Email" name="value" />
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="space-top"></div>
		<div class="form-group">
			<label for="camp_short_name" class="col-sm-2 control-label">Kurzer Anzeigenamen:</label>
			<div class="col-sm-10">
				<input tal:attributes="value camp_info/short_name/value" type="text" class="form-control" id="camp_short_name" placeholder="Email" name="value" />
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="space-top"></div>
		<div class="form-group">
			<label for="camp_slogan" class="col-sm-2 control-label">Motto/Thema:</label>
			<div class="col-sm-10">
				<input tal:attributes="value camp_info/slogan/value" type="text" class="form-control" id="camp_slogan" placeholder="Email" name="value" />
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="space-top"></div>
		<p tal:condition="camp_info/is_course">
			<p align="left">Leiterkurs:</p>
			<p align="left" tal:content="camp_info/type" />
		</p>

		<p><b>Lageradresse:</b></p>
		<div class="form-group">
			<label for="camp_ca_name" class="col-sm-2 control-label">Name:</label>
			<div class="col-sm-10">
				<input tal:attributes="value camp_info/ca_name/value" type="text" class="form-control" id="camp_ca_name" placeholder="Email" name="value" />
			</div>
		</div>
		<div class="form-group">
			<label for="camp_ca_street" class="col-sm-2 control-label">Strasse:</label>
			<div class="col-sm-10">
				<input tal:attributes="value camp_info/ca_street/value" type="text" class="form-control" id="camp_ca_street" placeholder="Email" name="value" />
			</div>
		</div>
		<div class="form-group">
			<label for="camp_ca_zipcode" class="col-sm-2 control-label">PLZ:</label>
			<div class="col-sm-10">
				<input tal:attributes="value camp_info/ca_zipcode/value" type="text" class="form-control" id="camp_ca_zipcode" placeholder="Email" name="value" />
			</div>
		</div>
		<div class="form-group">
			<label for="camp_ca_city" class="col-sm-2 control-label">Ort:</label>
			<div class="col-sm-10">
				<input tal:attributes="value camp_info/ca_city/value" type="text" class="form-control" id="camp_ca_city" placeholder="Email" name="value" />
			</div>
		</div>
		<div class="form-group">
			<label for="camp_ca_tel" class="col-sm-2 control-label">Telefon:</label>
			<div class="col-sm-10">
				<input tal:attributes="value camp_info/ca_tel/value" type="text" class="form-control" id="camp_ca_tel" placeholder="Email" name="value" />
			</div>
		</div>

		<div class="form-group">
			<label for="camp_ca_coor1" class="col-sm-2 control-label">Koordinaten:</label>
			<div class="col-sm-1">
				<input tal:attributes="value camp_info/ca_coor/value1" maxlength="3" type="text" class="form-control" id="camp_ca_coor1" placeholder="Email" name="value1" />
			</div>
			<label for="camp_ca_coor2" class="control-label">/</label>
			<div class="col-sm-1">
				<input tal:attributes="value camp_info/ca_coor/value2" maxlength="3" type="text" class="form-control" id="camp_ca_coor2" placeholder="Email" name="value2" />
			</div>
			<label for="camp_ca_coor3" class="control-label">//</label>
			<div class="col-sm-1">
				<input tal:attributes="value camp_info/ca_coor/value3" maxlength="3" type="text" class="form-control" id="camp_ca_coor3" placeholder="Email" name="value3" />
			</div>
			<label for="camp_ca_coor4" class="control-label">/</label>
			<div class="col-sm-1">
				<input tal:attributes="value camp_info/ca_coor/value4" maxlength="3" type="text" class="form-control" id="camp_ca_coor4" placeholder="Email" name="value4" />
			</div>
			<div class="col-sm-1">
				<input type="button" class="form-control btn btn-info" id="camp_show_map" value="Karte anzeigen" />
			</div>
		</div>

		<div id="mapcontainer"></div>

		<b>Lagerdauer:</b>
		<tr tal:repeat="subcamp camp_info/subcamps" class="camp_subcamp">
			<p align="left" class="date"><tal:block content="subcamp/start" /> - <tal:block content="subcamp/end" /></p>
			<div align="left" tal:condition="php: user_camp.auth_level >= 50">
				<a href="#" class="delete">
					<img src="public/global/img/del.png" border="0" />
				</a>

				<input type="button" class="change btn" value="Zeitfenster verändern" />
				<input type="button" class="move btn" value="Programm verschieben" />

				<input type="hidden" class="subcamp_start" 	tal:attributes="value subcamp/start" />
				<input type="hidden" class="subcamp_end"	tal:attributes="value subcamp/end" />
				<input type="hidden" class="subcamp_id" tal:attributes="value subcamp/id" />

				<form class="delete_form">
					<input type="hidden" name="subcamp_id" tal:attributes="value subcamp/id" />
					<input type="hidden" name="app" value="camp" />
					<input type="hidden" name="cmd" value="action_del_subcamp" />
				</form>
			</div>
		</tr>
	</div>
                            
	<div tal:condition="php: user_camp.auth_level >= 50">
		<input class="add_subcamp btn btn-info" type="button" value="+" />
	</div>

	<img src="public/global/img/wait.gif" class="hidden" id="busy_gif" />
	<div>
		<div>Zeitfenster ver&auml;nden = Das Lager kann nach hinten/vorne verkürzt oder verl&auml;ngert werden. Das Lager kann nicht verk&uuml;rzt werden, falls dadurch Programmbl&ouml;cke verloren gehen. Alle Programmbl&ouml;cke bleiben an ihrem urspr&uuml;nglichen Datum.<br />
			<br />Programm verschieben = Das ganze Lager wird auf ein neues Startdatum verschoben. Alle Programmbl&ouml;cke verschieben sich dementsprechend.</div>
	</div>
</p>