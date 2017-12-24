<span metal:define-macro="dp_header" tal:omit-tag="">
    <span metal:use-macro="dp_border.tpl/dp_border">
    	<span metal:fill-slot="border_title" tal:omit-tag="">Kopf:</span>
    	
    	<span metal:fill-slot="border_content" tal:omit-tag="">
            <table width="100%" border="0" class="dp_header">
            	<colgroup>
            		<col width="50%"></col>
            		<col width="50%"></col>
            	</colgroup>
            	
            	<tr>
                    <td>
                    	<table width="100%">
                        	<tr>
                        		<td> </td>
                            	<td><b>Datum:</b></td>
                                <td><b>Zeit:</b></td>
                            </tr>
                        	<tal:block repeat="instance dp_header/event_instance">
                                <tr>
                                    <td tal:content="instance/event_nr" > </td>
                                    <td tal:content="instance/startdate"> </td>
                                    <td tal:content="instance/starttime"> </td>
                                </tr>
                            </tal:block>
                        </table>
                    </td>
                    
                	<td width="50%">
                    	<table width="100%" border="0">
                        	<colgroup>
                        		<col width="50%"></col>
                        		<col width="50%"></col>
                        	</colgroup>
                        	
                        	<tr>
                                <td><b>Ort:</b></td>
                                <td>
                                    <input name="input_edit" type="text" id="event_dp_header_place" tal:attributes="value dp_header/place/value" style="width:99%" />
                                </td>
                            </tr>
                            
                            <tr>
                            	<td><b>Verantwortliche:</b></td>
                                
                                <td>
                                	<!--
                                	<tal:block repeat="user dp_header/users">
                                    	<tal:block content="user" />
                                	</tal:block>
                                	-->
                                	<select style="width:100%" id="event_dp_header_resp" name="resp_user">
                                		<tal:block repeat="leader leaders">
                                			<option tal:condition="leader/resp" tal:attributes="value leader/id" tal:content="leader/displayname" mselected="true" />
                                			<option tal:condition="not: leader/resp" tal:attributes="value leader/id" tal:content="leader/displayname" />
                                		</tal:block>
                                	</select>
                                </td>
                            </tr>
                            
                        </table>
                    </td>
                </tr>
            </table>
        </span>
	</span>
</span>