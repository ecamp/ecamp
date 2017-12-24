<span metal:define-macro="new_course" tal:omit-tag="">
	<span tal:define="course string:1" metal:use-macro="new_camp" />
</span>

<span metal:define-macro="new_camp" tal:omit-tag="">
	
	<tal:block condition="not: exists: course">
	 <tal:block define="global course string:0" />
	</tal:block>
	
    <h1 tal:condition="not: course" style="font-size:15px;">Neues Lager erstellen</h1>
	<h1 tal:condition="course" style="font-size:15px;">Neuen Kurs erstellen</h1>
	
	<center>
		<div style="width:85%" align="left">
			<b>
				<span tal:condition="not: course">Ein Lager von:</span>
				<span tal:condition="course">Ein Kurs von:</span>
			</b>
		</div>
		<br />
		
		<div id="new_camp_selects" style="width:80%" align="left"></div>
		
		<br/>
		<div id="new_camp_path" style="width:80%; background-color:#CCCCCC; border:1px solid black; font-weight:bold; font-style:italic" align="left">
			&nbsp;
		</div>
		
	    <form  action="index.php" method="post" onsubmit="return new_check(${course});" onreset="window.location.href='index.php?app=camp_admin';">
	    <input tal:condition="course" type="hidden" name="is_course" value="1" />
				
		<div style="width:80%;" align="left">
			<span tal:condition="not: course">Zusätzliche Gruppenbezeichnung (z.B. genaue Stufe):</span>
			<span tal:condition="course">Veranstalter / Organisator (falls keine obige Auswahl zutreffend):</span><br />
			<input type="text" name="scout" id="scout" style="width:100%;"/>
		</div>
		
		
		<br />
		<br />
		<br />
			
		
			<input type="hidden" name="app" value="camp_admin" />
			<input type="hidden" name="cmd" value="action_new_camp" />
			
			<input type="hidden" name="groups" value="0" id="camp_groups" />
			
			<div style="width:85%" align="left">
				<b>Weitere Angaben:</b>
			</div>
			
			<br />
			<table width="80%" align="center">
				<colgroup>
					<col width="25%" />
					<col width="75%" />
				</colgroup>
				
				<!-- <tr>
					<td>
						<span tal:condition="not: course">Pfadi / Gruppenname (z.B. genaue Stufe):</span>
						<span tal:condition="course">Veranstalter / Organisator (falls keine obige Auswahl zutreffend):</span>
				 	</td>
					<td><input type="text" name="scout" style="width:100%"/></td>
				</tr>-->
				
				<tr>
					<td>
						<span tal:condition="not: course">Lagername:</span>
						<span tal:condition="course">Kursbezeichnung:</span>
					</td>
					<td><input type="text" name="camp_name" id="camp_name" style="width:100%"/></td>
				</tr>
				
				<tr>
					<td>
						<span tal:condition="not: course">Kurze Bezeichnung:</span>
						<span tal:condition="course">Kurze Bezeichnung (z.B. Kurs-Nr.):</span>
					</td>
					<td><input type="text" name="camp_short_name" id="camp_short_name" maxlength="15" style="width:170px"/></td>
				</tr>
				
				<tr>
					<td>Startdatum:</td>
					<td><input type="text" name="camp_start" id="camp_start" style="width:90%"/></td>
				</tr>
				
				<tr>
					<td>Enddatum:</td>
					<td><input type="text" name="camp_end" id="camp_end" style="width:90%"/></td>
				</tr>
				
				<tr>
					<td>Meine Funktion:</td>
					<td>
						<select name="function_id" id="function_id" style="width:100%">
							<tal:block repeat="function functions">
								<option tal:attributes="value function/id" tal:content="function/entry" />
							</tal:block>
						</select>
					</td>
				</tr>
				
				<tr>
					<td>J+S:</td>
					<td>
						<select name="jstype" style="width: 100%">
							<tal:block repeat="jstype jstypes">
								<option tal:attributes="value jstype/id" tal:content="jstype/entry" />
							</tal:block>
						</select>
					</td>
				</tr>
				
				<!-- <tr>
					<td>Lagerform:</td>
					<td>
						<input type="radio" name="is_course" value="0" id="camp_is_not_course" checked="checked" />
						<label for="camp_is_not_course">J+S - Lager</label>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="is_course" value="1" id="camp_is_course" />
						<label for="camp_is_course">Leiterkurs</label>
					</td>
				</tr> -->
				
				<!--
				<tr class="jscamp hidden">
					<td>J+S - Lager:</td>
					<td>
						<select name="camp_type" style="width:100%">
							<tal:block repeat="camptype camptypes">
								<option tal:attributes="value camptype/value" tal:content="camptype/entry" />
							</tal:block>
						</select>
					</td>
				</tr>
				-->
				
				<tr tal:condition="course">
					<td>Kursart:</td>
					<td>
						<select name="course_type" id="course_type" style="width:100%">
							<option selected="selected" />
							<tal:block repeat="coursetype coursetypes">
								<option tal:attributes="value coursetype/value" tal:content="coursetype/entry" />
							</tal:block>
						</select>
					</td>
				</tr>
				
				<tr tal:condition="course">
					<td>Kursart (Freitext):</td>
					<td><input type="text" name="course_type_text" id="course_type_text" style="width:100%"/></td>
				</tr>
				
				
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td></td>
					<td align="right">
						<input type="reset" value="Abbrechen" />
						<input type="submit" value="Hinzufügen" />
					</td>
				</tr>
			</table>
		</form>
	</center>
</span>