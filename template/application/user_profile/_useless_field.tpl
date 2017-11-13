<div metal:define-macro="simple_input">
    <div class="profile_input">
        <div class="wait hidden"><img border="0" src="public/global/img/wait.gif" /></div>
        
        <div class="display">
            <input type="text" readonly="readonly" class="showtext" tal:attributes="value input_value" />
        </div>
        
        <div class="input hidden">
            <form enctype="text/plain" onsubmit="return false;" action="index.php">
                <input name="value" type="text" class="input_field askedit " style="width:54%;" tal:attributes="value input_value" />
                <input type="button" class="ok_button askeditbutton " value="OK" style="width:10%;" />
                <input type="button" class="cancel_button askeditbutton " value="Abbrechen" style="width:20%;" />    
                <input name="field" type="hidden" tal:attributes="value input_name"/>
                
                <input name="app" value="user_profile" type="hidden" />
                <input name="cmd" value="action_save_change"  type="hidden" />
            </form>
        </div>
    </div>
</div>

<div metal:define-macro="birthday_input">
    <div class="profile_input">
        <div class="wait hidden"><img border="0" src="public/global/img/wait.gif" /></div>
        
        <div class="display">
            <input type="text" readonly="readonly" class="showtext" tal:attributes="value input_value" /> 
        </div>
        
        <div class="input hidden">
            <form enctype="text/plain" onsubmit="return false;" action="index.php">
                <input id="birthday_input" name="value" type="text" class="input_field askedit " tal:attributes="value input_value" style="width:44%;" />
                <input type="button" class="ok_button askeditbutton " value="OK" style="width:10%;" />
                <input type="button" class="cancel_button askeditbutton " value="Abbrechen" style="width:20%;" />
                <input name="field" type="hidden" tal:attributes="value input_name" />
                
                <input name="app" value="user_profile" type="hidden" />
                <input name="cmd" value="action_save_change"  type="hidden"/>
            </form>
        </div>
    </div>
</div>