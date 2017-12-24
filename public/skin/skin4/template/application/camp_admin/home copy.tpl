<span metal:define-macro="home" tal:omit-tag="">
    
    <div align="left">Eigene Lager k&ouml;nnen gel&ouml;scht werden. Aus Lagern, in denen man zur Mitarbeit eingeladen wurde, kann man hier wieder austreten.<br />
    &nbsp;</div>
    <center>
        <table width="100%" border="0" id="camp_list" cellspacing="10px">
            <tr>
                <td><b>Pfadi / Gruppenname</b></td>
                <td><b>Lagername</b></td>
                <td><b>Kurzname</b></td>
                <td><b>Motto</b></td>
                <td><b>Funktion</b></td>
                <td><b>Lagerdauer</b></td>
                <td><b>Ersteller/Admin.</b></td>
                <td>&nbsp;</td>
            </tr>    
            
            
            <tr tal:repeat="camp_detail active_camp_list" class="camp_col">
                <td tal:content="camp_detail/group_name" ><!-- group_name --></td>
                <td tal:content="camp_detail/name" ><!-- name --></td>
                <td tal:content="camp_detail/short_name" ><!-- short_name --></td>
                <td tal:content="camp_detail/slogan" ><!-- slogan --></td>
                <td tal:content="camp_detail/function" ><!-- function --></td>
                <td><tal:block content="camp_detail/start" /> - <tal:block content="camp_detail/end" /></td>
                <td tal:content="camp_detail/creator" ><!-- creator --></td>
                <td class="camp_option">
                	<form class="form">
                    	<input type="hidden" name="camp_id" tal:attributes="value camp_detail/id" />
                		<input type="hidden" name="user_camp_id" tal:attributes="value camp_detail/user_camp_id" />
                    </form>
                    <div tal:condition="camp_detail/delete"><a href="#" class="delete" ><img src="public/application/camp_admin/img/del.png" border="0" class="tooltip" title="L&ouml;schen :: Dieses Lager l&ouml;schen."/></a></div>
                    <div tal:condition="camp_detail/exit"><a href="#" class="exit"><img src="public/application/camp_admin/img/exit.png" border="0" class="tooltip" title="Verlassen :: Dieses Lager verlassen" /></a></div>
                </td>
            </tr>
        </table>
        
        
        <table width="90%" border="0">
            <tr><td>&nbsp;</td></tr>
            <tr><td align="right"><input type="button"  value="Neues Lager erstellen" id="add_new_camp"/></td></tr>
        </table>
    </center>
	
</span>