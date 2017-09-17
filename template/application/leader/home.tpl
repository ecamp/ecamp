<span metal:define-macro="home" tal:omit-tag="" >
    <div align="left" style="width:90%">
      
      
      <p tal:condition="not: camp/is_course">
      	Alle Personen, die in dieser Leiterliste aufgeführt sind, können am Lager mitarbeiten. Es wird zwischen folgenden Funktionen unterschieden:<br />
        - Ersteller: alle Rechte (+ Lager löschen)<br />
        - Lagerleiter: alle Rechte<br />
        - Leiter: eingeschränkte Rechte<br />
        - Gast: nur Leserechte<br />
        - Coach: nur Leserechte<br />
      </p>
      
      <p tal:condition="camp/is_course">
      	Alle Personen, die in dieser Leiterliste aufgeführt sind, können am Lager mitarbeiten. Es wird zwischen folgenden Funktionen unterschieden:<br />
        - Ersteller: alle Rechte (+ Lager löschen)<br />
        - Kursleiter: alle Rechte<br />
        - Mitleiter: eingeschränkte Rechte<br />
        - LKB: nur Leserechte<br />
        - Gast: nur Leserechte<br />
      </p>
      
      <br />
    </div>
    <center>
        <table width="90%" cellspacing="0">
            <tal:block repeat="function leader/leaders">
                <tr class="function_title">
                    <td colspan="2">
                        <b><i tal:content="function/function_name">Lagerleiter</i></b>
                    </td>
                    <td colspan="4" align="left">
                        <a href="#" style="color: #000000; text-decoration:none" class="add_leader">(+ Neuer <tal:block content="function/function_name" />)</a>
                        <input type="hidden" class="function_id" tal:attributes="value function/function_id" />
                    </td>
                    <td>
                    	<tal:block condition="function/show">
                        	vCard:
                        </tal:block>
                    </td>
                    <td>
                    	<tal:block condition="function/show">
                        	Option:
                        </tal:block>
                    </td>
                </tr>
                <tr height="10px"><td colspan="8" style="border-bottom:1px black solid"></td></tr>
                
                <tal:block repeat="user_data function/users">
                    <tr class="user_data">
                        <td width="20px">
                            <img tal:condition="user_data/green" src="public/application/leader/img/green.png" />
                            <img tal:condition="user_data/yellow" src="public/application/leader/img/yellow.png" />
                        </td>
                        <td>
                        	<a tal:attributes="href user_data/detail">
                        		<tal:block content="user_data/scoutname" />
                        	</a>
                        </td>
                        <td>
                        	<a tal:attributes="href user_data/detail">
                        		<tal:block content="user_data/firstname" />
                        	</a>
                        </td>
                        <td>
                        	<a tal:attributes="href user_data/detail">
                        		<tal:block content="user_data/surname" />
                        	</a>
                        </td>
                        
                        <td><a href="callto:" style="color:#000000; text-decoration:none" tal:condition="user_data/green" tal:attributes="href user_data/callto" tal:content="user_data/mobilnr"></a></td>
                        <td><a href="mailto:" style="color:#000000; text-decoration:none" tal:attributes="href user_data/mailto" tal:content="user_data/mail"></a></td>
                        <td>
                        	<a tal:attributes="href user_data/vcard" tal:condition="user_data/green"><img src="public/application/leader/img/vcard.gif" /></a>
                        	<a tal:condition="user_data/yellow"><img src="public/application/leader/img/vcard_locked.png" /></a>
                        </td>
                        <td align="right">
                            <tal:block condition="user_data/exit" ><a href="#" class="exit"><img src="public/application/leader/img/exit.png" border="0" /></a></tal:block>
                            <tal:block condition="user_data/creator" >Ersteller</tal:block>
                            <a href="#" class="edit"><img src="public/global/img/edit.png" /></a>
                         	<input type="hidden" class="user_camp_id" tal:attributes="value user_data/user_camp_id" />
                         	<input type="hidden" class="function_id" tal:attributes="value function/function_id" />
                        </td>
                    </tr>
                </tal:block>
                <tr height="20px"><td colspan="7">&nbsp;</td></tr>
            </tal:block>
        </table>
    </center>
</span>