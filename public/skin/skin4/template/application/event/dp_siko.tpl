<span metal:define-macro="dp_siko" tal:omit-tag="">
    <span metal:use-macro="dp_border.tpl/dp_border">
    	<span metal:fill-slot="border_title" tal:omit-tag="">Notizen SiKo:</span>
		
		<span metal:fill-slot="border_content" tal:omit-tag="">
			<table width="100%">
				<colgroup>
					<col width="100%"></col>
				</colgroup>
				
				<tr><td><b>Sicherheits Konzept:</b></td></tr>
				<tr><td valign="top" class="single_save">
					<textarea id="event_dp_siko_siko" name="input_edit" class="input_show showtext" style="width:99%" tal:content="siko_note/siko/value" ></textarea>
				</td></tr>
				<tr><td><b>Notizen:</b></td></tr>
				<tr><td valign="top" class="single_save">
					<textarea id="event_dp_siko_note" name="input_edit" class="input_show showtext" style="width:99%" tal:content="siko_note/notes/value" ></textarea>
				</td></tr>
			</table>
		</span>
	</span>
</span>