<span metal:define-macro="day" tal:omit-tag="">
	<center tal:condition="not: day_selected">
		<h1 style="font-size: 16px">
			Tag auswählen!
		</h1>
	</center>
	
	<center tal:condition="day_selected">
		<h1 style="font-size: 16px">
			<tal:block content="day/day_str"/>
		</h1>
		<br />
		
		<h2 align="left" style="width:90%">Jobs des Tages:</h2>
		<div style="width:90%; border:1px solid black; background-color:white;" id="day_job_list">
			<ul style="display:inline; padding:5px">
				
				<tal:block repeat="job day/job_list/jobs">
					<li style="display:inline-table; padding-right:30px">
						<table>
							<tr>
								<td style="vertical-align: middle"><tal:block content="job/job_name" />:</td>
								<td>
									<select name="user_id" tal:attributes="initvalue job/user_id">
										<option value="0">-</option>
										<tal:block repeat="user day/job_list/users">
											<option tal:attributes="value user/id" tal:content="user/scoutname" />
										</tal:block>
									</select>
									<input type="hidden" name="job_id" tal:attributes="value job/id" />
								</td>
							</tr>
						</table>
					</li>
				</tal:block>
				
			</ul>
			
			<input type="hidden" name="day_id" tal:attributes="value day/day_id" />
		</div>
		
		<br />
		<br />
		
		<h2 align="left" style="width:90%">Alle Blöcke des Tages:</h2>
		<table width="90%" bgcolor="white" style="border:1px solid black; padding:5px" cellpadding="1" cellspacing="1">
			<tr style="font-weight: bold">
				<td>Zeit:</td>
				<td colspan="3">Blockname:</td>
				<td>Länge:</td>
				<td colspan="2">Planungsfortschritt:</td>
				
			</tr>
			<tbody id="day_event_list">
				<tr tal:repeat="event_instance day/event_list">
					<td width="100px" class="time">
						<tal:block content="event_instance/starttime_str" />
						- 
						<tal:block content="event_instance/endtime_str" />
					</td>
					
					<td align="center" width="40px">
						<i tal:condition="event_instance/form_type">
							(<tal:block content="event_instance/daynr" />.<tal:block content="event_instance/eventnr" />)
						</i>
					</td>
					<td align="center" tal:attributes="style event_instance/color_str" width="40px">
						<b><tal:block content="event_instance/short_name_str" /></b>
					</td>
					
					<td class="event_name" >
						<b><tal:block content="event_instance/name" /></b>
						<input type="hidden" name="event_id" tal:attributes="value event_instance/event_id" />
					</td>
					
					<td width="100px"><tal:block content="event_instance/length_str" /></td>
					
					<td class="progress"><tal:block content="event_instance/progress" /></td>
					
					<td width="40px" class="opt" align="center" style="padding:0px; margin:0px">
						<img class="edit" src="./public/global/img/edit.png" height="14" />
						<img class="del"  src="./public/global/img/del.png"  height="14" />
						<input type="hidden" name="event_instance_id" tal:attributes="value event_instance/id" />
					</td>
				</tr>
			</tbody>
			
		</table>
		
		<div align="right" style="width:90%; padding:0px; margin:0px">
			<input type="button" value="Neuer Block" id="day_new_event" />
		</div>
		<br />
		<br />

		<table width="90%">
			<colgroup>
				<col width="50%" />
				<col width="50%" />
			</colgroup>
			<tr>
				<td><h2 style="margin-bottom:2px">Roter Faden (Tagesablauf):</h2></td>
				<td><h2 style="margin-bottom:2px">Notizen:</h2></td>
			</tr>
			<tr>
				<td>
					<textarea style="width:100%" name="story" id="day_story" ><tal:block content="day/day_story" /></textarea>
				</td>
				<td>
					<textarea style="width:100%" name="notes" id="day_notes" ><tal:block content="day/day_notes" /></textarea>
				</td>
			</tr>
		</table>
	</center>
	
	
</span>