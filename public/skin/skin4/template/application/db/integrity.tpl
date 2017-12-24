<span metal:define-macro="integrity" tal:omit-tag="">
	<h1>Days in Subcamps:</h1>
	
	<table>
		<tr>
			<td>Camp-Id</td>
			<td>Subcamp-Id</td>
			<td>Subcamp-Length</td>
			<td>Counted Days</td>
		</tr>
		
		<tal:block repeat="error subCampLength">
			<tr>
				<td tal:content="error/camp_id" />
				<td tal:content="error/subcamp_id" />
				<td tal:content="error/subcamp_length" />
				<td tal:content="error/days_length" />
			</tr>
		</tal:block>
	</table>
	
	
	
	<h1>Event Detail sorting:</h1>
	
	<table>
		<tr>
			<td>Event-ID</td>
		</tr>
		
		<tal:block repeat="error eventDetailSorting">
			<tr>
				<td tal:content="error/event_id" />
			</tr>
		</tal:block>
	</table>
	
	
</span>
