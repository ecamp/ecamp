<span metal:define-macro="simple_input">
    <div class="camp_input">
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
                
                <input name="app" value="camp" type="hidden" />
                <input name="cmd" value="action_save_change"  type="hidden" />
            </form>
        </div>
    </div>
</span>

<span metal:define-macro="simple_readonly">
    <div>
        <div class="display">
            <input type="text" readonly="readonly" class="showtext " tal:attributes="value input_value" />
        </div>
    </div>
</span>

<span metal:define-macro="plz_input">
    <div class="camp_input">
        <div class="wait hidden"><img border="0" src="public/global/img/wait.gif" /></div>
        
        <div class="display">
            <input type="text" readonly="readonly" class="showtext " tal:attributes="value input_value" />
        </div>
        
        <div class="input hidden">
            <form enctype="text/plain" onsubmit="return false;" action="index.php">
                <input name="value" type="text" maxlength="4" class="input_field askedit " style="width:54%;" tal:attributes="value input_value" />
                <input type="button" class="ok_button askeditbutton " value="OK" style="width:10%;" />
                <input type="button" class="cancel_button askeditbutton " value="Abbrechen" style="width:20%;" />    
                <input name="field" type="hidden" tal:attributes="value input_name"/>
                
                <input name="app" value="camp" type="hidden" />
                <input name="cmd" value="action_save_change"  type="hidden" />
            </form>
        </div>
    </div>
</span>

<span metal:define-macro="plz_readonly">
    <div>
        <div class="display">
            <input type="text" readonly="readonly" class="showtext " tal:attributes="value input_value" />
        </div>
    </div>
</span>

<span metal:define-macro="coor_input">
    <div class="camp_input">
        <div class="wait hidden"><img border="0" src="public/global/img/wait.gif" /></div>
        
        <div class="display">
            <input type="text" readonly="readonly" class="showtext " tal:attributes="value input_value" />
            
            <input type="hidden" name="value1" maxlength="3" tal:attributes="value input_value1" />
            <input type="hidden" name="value2" maxlength="3" tal:attributes="value input_value2" />
            <input type="hidden" name="value3" maxlength="3" tal:attributes="value input_value3" />
            <input type="hidden" name="value4" maxlength="3" tal:attributes="value input_value4" />
        </div>
        
        <div class="input hidden">
            <form enctype="text/plain" onsubmit="return false;" action="index.php">
                <input name="value1" type="text" maxlength="3" class="input_field1 askedit " style="width:30px;" tal:attributes="value input_value1" />
                .
                <input name="value2" type="text" maxlength="3" class="input_field2 askedit " style="width:30px;" tal:attributes="value input_value2" />
                /
                <input name="value3" type="text" maxlength="3" class="input_field3 askedit " style="width:30px;" tal:attributes="value input_value3" />
                .
                <input name="value4" type="text" maxlength="3" class="input_field4 askedit " style="width:30px;" tal:attributes="value input_value4" />
                
                <input type="button" class="ok_button askeditbutton " value="OK" style="width:10%;" />
                <input type="button" class="cancel_button askeditbutton " value="Abbrechen" style="width:20%;" />    
                <input name="field" type="hidden" tal:attributes="value input_name"/>
                
                <input name="app" value="camp" type="hidden" />
                <input name="cmd" value="action_save_change"  type="hidden" />
            </form>
        </div>
    </div>
</span>

<span metal:define-macro="coor_readonly">
    <div>
        <div class="display">
            <input type="text" readonly="readonly" class="showtext " tal:attributes="value input_value" />
        </div>
    </div>
</span>