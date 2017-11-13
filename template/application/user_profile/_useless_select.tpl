<span metal:define-macro="select_input">
    <div class="profile_select">
        <div class="wait hidden"><img border="0" src="public/global/img/wait.gif" /></div>
        
        <div class="input">
            <form>
                <select name="value selectpicker" style="width:100%">
                	<tal:block repeat="item input_value">
                        <option tal:condition="item/selected" selected="selected" tal:content="structure item/content" tal:attributes="value item/value">
                            <!-- content -->
                        </option>
                        <option tal:condition="not: item/selected" tal:content="structure item/content" tal:attributes="value item/value">
                            <!-- content -->
                        </option>
                    </tal:block>
                </select>
                
                <input name="field" type="hidden" tal:attributes="value input_name" />
                <input name="app" value="user_profile" type="hidden" />
                <input name="cmd" value="action_save_change"  type="hidden" />
            </form>
        </div>
    </div>
</span>