<span metal:define-macro="dp_course_head" tal:omit-tag="">
    <span metal:use-macro="dp_border.tpl/dp_border">
    	<span metal:fill-slot="border_title" tal:omit-tag="">Ausbildung:</span>
    	
    	<span metal:fill-slot="border_content" tal:omit-tag="">
            <table width="100%" cellpadding="2" cellspacing="2" class="dp_head">
                <tr>
                    <td width="50%"><b>Ausbildungsziele:</b></td>
                    <td width="50%"><b>Checkliste J+S/PBS:</b></td>
                </tr>
                <tr>
                	<td>
                		<ul id="course_aim_list" class="dp_course_aims">
                		</ul>
                	</td>
                	<td id="course_checklist_list">
                		
                	</td>
                </tr>
                <tr>
                    <td id="head_aim_predefined" style="vertical-align:top" class="single_save head_aim_predefined">
                    	<input type="button" value="Ändern" id="edit_aim" />
                    </td>
                    <td id="head_checklist" style="vertical-align:top" class="single_save head_checklist">
                    	<input type="button" value="Ändern" id="edit_checklist" />
                    </td>
                </tr>
                <tr>
                    <td width="50%"><b>Blockziele:</b></td>
                    <td width="50%"><b>Blockinhalte:</b></td>
                </tr>
                <tr>
                    <td id="head_aim" style="vertical-align:top" class="single_save head_aim">
                    	<textarea id="event_dp_head_aim" name="input_edit" class="input_show showtext" style="width:100%" tal:content="dp_head/aim/value" ></textarea>  
                    </td>
                    
                    <td id="head_topics" style="vertical-align:top" class="single_save head_topics">
                     	<textarea id="event_dp_head_topics" name="input_edit" class="input_show showtext" style="width:100%" tal:content="dp_head/topics/value" ></textarea>  
                   </td>
                </tr>
            </table>
        </span>
	</span>
</span>