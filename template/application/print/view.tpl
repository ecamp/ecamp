<span metal:define-macro="view" tal:omit-tag="">
	<p>
		Um einen angepassten Download zu erhalten, kann dieser nach belieben zusammengestellt werden.
		Die einzelnen Teile können durch <nobr>Drag & Drop</nobr> verschoben werden. Um Neue Teile hinzuzufügen, 
		könne diese aus der Bibliothek gewählt werden.
	</p>
	
	<h1>Zusammenstellung:</h1>
	
	<form id="form_view" action="index.php" method="post" enctype="multipart/form-data" target="_blank" >
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td>
					<ul id="view"></ul>
				</td>
			</tr>
			<tr>
				<td align="right">
					<input id="print" type="button" value="Drucken" />
				</td>
			</tr>
		</table>
		
		<input type="hidden" name="app" value="print" />
		<input type="hidden" name="cmd" value="builder" />
	</form>
	
</span>