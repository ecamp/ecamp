<span metal:define-macro="home" tal:omit-tag="">
	
	<center class="list_container">
		<h1 align="left" style="padding-left:3%">Suche:</h1>
		
		<form accept="index.php">
			<table width="90%" cellspacing="2px">
				<colgroup>
					<col width="20%" />
					<col width="30%" />
					<col width="50%" />
				</colgroup>
				<tr>
					<td>Camp Id:</td>
					<td><input name="s_camp_id" type="text" style="width:100%" /></td>
					<td rowspan="6">
						<div tal:condition="query" tal:content="query" style="margin-left: 20px" />
					</td>
				</tr>
				<tr>
					<td>Camp Bezeichnung:</td>
					<td><input name="s_camp_desc" type="text" style="width:100%" /></td>
				</tr>
				<tr><td colspan="3" height="10px"></td></tr>
				<tr>
					<td>Ersteller Id:</td>
					<td><input name="s_user_id" type="text" style="width:100%" /></td>
				</tr>
				<tr>
					<td>Ersteller Name:</td>
					<td><input name="s_user_desc" type="text" style="width:100%" /></td>
				</tr>
				<tr><td colspan="3" height="10px"></td></tr>
				<tr>
					<td> </td>
					<td align="right"><input type="submit" value="Suchen" /></td>
				</tr>
				
				<tr><td colspan="2" height="10px"></td></tr>
			</table>
			
			<input type="hidden" name="app" value="support" />
			<input type="hidden" name="cmd" value="home" />
			<input type="hidden" name="search" value="1" />
		</form>
		
		
		
		<h1 align="left" style="padding-left:3%">Anzeige:</h1>
        <div id="list_container">
	        <table width="90%" border="0" id="camp_list" cellspacing="2px">
		        <thead>
		            <tr>
		            	<td></td>
		                <td><b>Camp - ID</b></td>
		                <td><b>Pfadi / Gruppenname</b></td>
		                <td><b>Lagername</b></td>
		                <td><b>Kurzname</b></td>
		                <td><b>Ersteller/Admin.</b></td>
		                <td>&nbsp;</td>
		            </tr>    
		        </thead>
	            
	            <tbody class="support_list">
		            <tr tal:repeat="camp_detail camp_list" class="camp_col">
		            	<td>
		                	<tal:block condition="camp_detail/supported" >
		                    	<img src="public/application/support/img/green.png" />
		                    </tal:block>
		                	<tal:block condition="not: camp_detail/supported" >
		                    	<img src="public/application/support/img/red.png" />
		                    </tal:block>
		                </td>
		            	
		            	<td tal:content="camp_detail/id"><!-- camp_id --></td>
		                <td tal:content="camp_detail/group_name" ><!-- group_name --></td>
		                <td tal:content="camp_detail/name" ><!-- name --></td>
		                <td tal:content="camp_detail/short_name" ><!-- short_name --></td>
		                <td tal:content="camp_detail/creator" ><!-- creator --></td>
		                <td class="camp_option">
		                	<tal:block condition="not: camp_detail/supported" >
		                        <form class="form">
		                            <input type="submit" value="Support starten" />
		                            <input type="hidden" name="camp_id" tal:attributes="value camp_detail/id" />
		                            <input type="hidden" name="app" value="support" />
		                            <input type="hidden" name="cmd" value="support" />
		                            
		                            <input type="hidden" name="support" value="1" />
		                        </form>
		                    </tal:block>
		                    
		                    <tal:block condition="camp_detail/supported" >
		                        <form class="form">
		                            <input type="submit" value="Support beenden" />
		                            <input type="hidden" name="camp_id" tal:attributes="value camp_detail/id" />
		                            <input type="hidden" name="app" value="support" />
		                            <input type="hidden" name="cmd" value="support" />
		                            
		                            <input type="hidden" name="support" value="0" />
		                        </form>
		                    </tal:block>
		                </td>
		            </tr>
		        </tbody>
	        </table>
        </div>
    </center>
	
</span>