<span metal:define-macro="list" tal:omit-tag="">
	
	<tal:block repeat = "subcamp day/day_list">
	
		<h1 style="font-size:12px">
			<tal:block content = "subcamp/subcamp/start_str" />
			-
			<tal:block content = "subcamp/subcamp/end_str" />
		</h1>
		
		
		<table style="width:100%;" border="0">
			<colgroup>
				<col width="55%" />
				<col width="45%" />
			</colgroup>
			
			<tal:block repeat = "day subcamp/days">
				<tr>
					<td align="center">
						<a tal:attributes="href day/link">
							<b tal:condition="day/bold">
								<tal:block content = "day/date_str" />
							</b>
							
							<tal:block condition="not: day/bold" content="day/date_str" />
						</a>
					</td>
					<td>
						<a tal:attributes="href day/link">
							<b tal:condition="day/bold">
								<tal:block content="day/day_str" />
							</b>
							
							<tal:block condition="not: day/bold" content="day/day_str" />
						</a>
					</td>
				</tr>
			</tal:block>		
		</table>
		
	
	</tal:block>
	
</span>