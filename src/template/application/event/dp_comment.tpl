<span metal:define-macro="dp_comment" tal:omit-tag="">
    <span metal:use-macro="dp_border.tpl/dp_border">
    	<span metal:fill-slot="border_title" tal:omit-tag="">Kommentare:</span>
    	
    	<span metal:fill-slot="border_content" tal:omit-tag="">
            <table width="100%" >
                <tbody id="comment_tbody">
                	<tal:block repeat="comment comments">
	                	<tr tal:attributes="class comment/id">
	                		<td style="padding-left:10px; font-weight:bold">
	                			<i tal:content="comment/display_name" />
	                		</td>
	                		<td align="right" style="font-size:9px">
	                			<tal:block content="comment/string_created" />
	                		</td>
	                		<td align="right" width="15">
	                			<img class="del" src="public/global/img/del.png" width="12" />
	                			<input type="hidden" class="comment_id" name="comment_id" tal:attributes="value comment/id" />
	                		</td>
	                	</tr>
	                	<tr tal:attributes="class comment/id">
	                		<td colspan="3" style="padding-bottom:10px; border-bottom: 1px dotted black">
	                			<tal:block content="comment/text" />
	                		</td>
	                	</tr>
	                	
	                	
	                	
	                	
                	</tal:block>
                		<tr class="hidden" id="comment_head_example">
	                		<td style="padding-left:10px; font-weight:bold">
	                			<i class="name" />
	                		</td>
	                		<td align="right" style="font-size:9px" class="date" />
	                		<td align="right" width="15">
	                			<img src="public/global/img/del.png" class="del" width="12" />
	                			<input type="hidden" class="comment_id" name="comment_id" />
	                		</td>
	                	</tr>
	                	<tr class="hidden" id="comment_content_example">
	                		<td colspan="3" style="padding-bottom:10px; border-bottom: 1px dotted black" class="text" />
	                	</tr>
                </tbody>
                <tfoot>
                	<tr>
	                    <td colspan="3" style="padding-top:10px;">
	                    	<b>Kommentar verfassen:</b>
	                	</td>
	                </tr>
	                <tr>
	                    <td colspan="3"><textarea rows="3" style="width:100%; border:1px solid black" id="comment_text" /></td>
	                </tr>
	                <tr>
	                	<td colspan="3" align="right">
	                		<input type="button" value="Kommentieren" id="comment_save" />
	                	</td>
	                </tr>
                </tfoot>
            </table>
		</span>
	</span>
</span>