<span metal:define-macro="border" tal:omit-tag="">
	
<!--    
    <div align="center">
        <div style="width:280px; display:inline-block; border:1px black solid; margin-right:10px" tal:repeat="request request_camp_list" class="bgcolor_content invention">
            <form style="width:280px" action="index.php">
            <table width="280px" cellspacing="20px">
             <tr align="left">
                <td width="100%">Du hast eine neue Lager/Kurs-Einladung von <b tal:content="request/from"></b> erhalten:<br /><br />
                    <table>
                    <tr>
                      <td>Gruppe: </td><td tal:content="request/scout"></td>
                    </tr>
                    <tr>
                      <td>Lagername: </td><td tal:content="request/name"></td>
                    </tr>
                    <tr>
                      <td>Motto: </td><td tal:content="request/slogan"></td>
                    </tr>
                    <tr>
                      <td>Datum: </td><td><tal:block content="request/start" /> - <tal:block content="request/end" /></td>
                    </tr>
                    <tr>
                      <td>
                      	<input type="submit" value="Annehmen" name="accept" />
                      </td>
                      <td align="right">
                      	<input type="submit" value="Ablehnen" name="accept" />
                      </td>
                    </tr>
                    </table>
                </td>
             </tr>
            </table>
            <input type="hidden" name="app" value="camp_admin" />
            <input type="hidden" name="cmd" value="action_inventation" />
            
            <input type="hidden" name="user_camp_id" tal:attributes="value request/user_camp_id" />
            </form>
        </div>
    </div>
-->    

    <span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />

</span>