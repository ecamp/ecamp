<span metal:define-macro="dp_lp_head" tal:omit-tag="">
    <span metal:use-macro="dp_border.tpl/dp_border">
    	<span metal:fill-slot="border_title" tal:omit-tag="">Ziel / Methode:</span>
    	
    	<span metal:fill-slot="border_content" tal:omit-tag="">
			<table width="100%" class="dp_head">
				<tr>
					<td><b>Roter Faden:</b></td>
				</tr>
				<tr>
					<td id="head_story" style="vertical-align:top" class="single_save head_story">
                    	<textarea id="event_dp_head_story" name="input_edit" class="input_show showtext" style="width:99%" tal:content="dp_head/story/value" ></textarea>
                    </td>
				</tr>
				<tr>
					<td><b>Ziele:</b></td>
				</tr>
				<tr>
					<td id="head_aim" style="vertical-align:top" class="single_save head_aim">
                    	<textarea id="event_dp_head_aim" name="input_edit" class="input_show showtext" style="width:99%" tal:content="dp_head/aim/value" ></textarea>
                    </td>
				</tr>
			</table>
        </span>
	</span>
</span>