<span metal:define-macro="input_text" tal:omit-tag="">
    <form class="input_form" action="index.php">
        <div class="input_show_border">
            <input type="text" readonly="readonly" class="input_show showtext" style="width:100%" tal:attributes="value value" />
        </div>
        
        <div class="input_edit_border hidden" align="right">
            <input type="text" class="input_edit askedit" name="input_edit" style="width:100%" tal:attributes="value value" />
            
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