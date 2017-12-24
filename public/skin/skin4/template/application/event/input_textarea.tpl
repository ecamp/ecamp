<span metal:define-macro="input_textarea" tal:omit-tag="">
	<form class="input_form">
		<div class="input_show_border">
			<textarea class="input_show fit_on_the_fly showtext" readonly="readonly" style="width:100%" tal:content="value" ></textarea>
		</div>
		
		<div class="input_edit_border hidden" align="right">
			<textarea class="input_edit fit_on_the_fly askedit" style="width:100%" name="input_edit" tal:content="value" ></textarea>
			<br />
			<div class="input_edit_button">
				<input type="button" class="input_edit_save" value="OK" />
				<input type="button" class="input_edit_cancel" value="Abbrechen" />
			</div>
		</div>
		<input type="hidden" name="app" value="event" />
		<input type="hidden" name="cmd" tal:attributes="value cmd"  />
		<input type="hidden" name="event_id" tal:attributes="value event_id"  />
		
		<div class="input_wait_border hidden"><img src="public/global/img/wait.gif" /></div>
	</form>
</span>