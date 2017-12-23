<span metal:define-macro="display" tal:omit-tag="">
	<div tal:condition="not: mat_list/selected">
		<center>	
			<b>Links Person oder Einkaufsliste wählen...</b>
		</center>
	</div>
	
	<div tal:condition="mat_list/selected">
		<center>
			
			<table width="90%">
				<tr>
					<td colspan="4">
						<h1>Materialliste:</h1>
					</td>
					<td align="right"> <!-- colspan="2"> -->
						<a href="index.php?app=mat_list&cmd=action_generate_xls&listtype=${mat_list/listtype}&list=${mat_list/list}">
							<img src="public/application/program/img/print.png" /> Liste drucken
						</a>
					</td>
				</tr>
				<tr>
					<td><b>Erledigt</b></td>
					<td align="right"><b>Anzahl</b></td>
					<td> </td>
					<td><b>Material</b></td>
					<td><b>Block</b></td>
				</tr>
				
				<tr tal:repeat="list_entry mat_list/list_entries" class="mat_list_entry" >
					<td width="20px" class="mat_list_organized" align="center">
						<input class="mat_event_id" type="hidden" tal:attributes="value list_entry/id" />
						
						<input class="mat_event_checkbox" type="checkbox" checked="checked" tal:condition="list_entry/organized" />
						<input class="mat_event_checkbox" type="checkbox" tal:condition="not: list_entry/organized" />
					</td>
					<td width="50px" tal:content="list_entry/quantity" align="right" />
					<td> </td>
					<td tal:content="list_entry/article_name" />
					<td tal:content="list_entry/event_name" />
					
					<!--
					<td>
						<a >[edit]</a>
					</td>
					-->
					
					
				</tr>
			</table>
		</center>
	</div>
</span>