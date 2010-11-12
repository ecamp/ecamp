<span metal:define-macro="statistics" tal:omit-tag="">
	<h1>Zahlen:</h1>
	
	<table >
		<tr>
			<td>Anzahl User:</td>
			<td tal:content="count/user" />
		</tr>
		
		<tr>
			<td>Anzahl Camps:</td>
			<td tal:content="count/camp" />
		</tr>
	</table>
</span>
