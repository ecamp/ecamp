<span metal:define-macro="todo_list" tal:omit-tag="" >
	<table class="todo_table" cellspacing="0px" cellpadding="2px">
		
        <tal:block tal:repeat="month todo_list" >
            <tbody class="todo_month_title_tbody">
				<tr class="todo_month_title_row"><td colspan="6">&nbsp;</td></tr>
				<tr class="todo_month_title_row">
					<td class="todo_month_title" colspan="4" tal:content="month/name">Titel</td>
					<td class="todo_month_title" colspan="2" align="right">
						<!--<input type="button" value="Neue Aufgabe" class="todo_new_todo" />-->
					</td>
				</tr>
				<tr class="todo_month_title_row"><td colspan="6">&nbsp;</td></tr>
				
				<tal:block tal:repeat="day month/todos" >
					<tal:block tal:repeat="entry day">
						<tal:block condition = "entry/today">
							<tr class="todo_entry todo_today" style="background-color:#000000; color:#ffffff">
								<td class="todo_done">	</td>
								<td class="todo_date">	<b tal:content="entry/date" /></td>
								<td class="todo_title">	Heute</td>
								<td class="todo_short">	</td>
								<td class="todo_resp">	</td>
								<td class="todo_option"></td>
							</tr>
						</tal:block>
						
						<tal:block condition = "entry/camptime">
							<tr class="todo_entry todo_today" style="background-color:#335588; color:#ffffff">
								<td class="todo_done">	</td>
								<td class="todo_date">	<b tal:content="entry/date" /></td>
								<td class="todo_title">Lager</td>
								<td class="todo_short"> <b tal:content="entry/short" /> </td>
								<td class="todo_resp">	</td>
								<td class="todo_option"></td>
							</tr>
						</tal:block>
						
						<tal:block condition = "entry/entry">
							<tr class="todo_entry">
								<td class="todo_done">
									<tal:block condition="entry/done" >
										<input type="checkbox" checked="checked" class="" />
										<img src="./public/application/todo/img/green.png" class="green" />
										<img src="./public/application/todo/img/red.png" class="red hidden" />
									</tal:block>
									<tal:block condition="not: entry/done" >
										<input type="checkbox" class="" />
										<img src="./public/application/todo/img/green.png" class="green hidden" />
										<img src="./public/application/todo/img/red.png" class="red" />
									</tal:block>
								</td>
								<td class="todo_date" style="vertical-align:middle">
									<tal:block content="entry/date">Datum</tal:block>
									<input type="hidden" class="todo_date_value" tal:attributes="value entry/date_value" />
								</td>
								<td class="todo_title" style="vertical-align:middle" tal:content="entry/title">Title</td>
								<td class="todo_short" style="vertical-align:middle" tal:content="entry/short">Kurzbeschrieb</td>
								<td class="todo_resp">
									<select name="user" tal:attributes="class entry/resp_class; disabled entry/disabled" >
										<tal:block repeat="resp entry/resp">
											<option tal:attributes="value resp/id" tal:condition="resp/resp" mselected="true" tal:content="resp/name" />
											<option tal:attributes="value resp/id" tal:condition="not: resp/resp" tal:content="resp/name" />
										</tal:block>
									</select>
										
										<!--
										<div tal:attributes="class resp/class" style="display:inline; position:relative">
											<tal:block content="resp/name" />
											<input type="hidden" class="user_id" tal:attributes="value resp/id" />
											<img src="public/global/img/del.png" class="img del_user"/>
										</div>
										-->
									
								</td>
								<td class="todo_option" style="vertical-align:middle">
									<tal:block condition="not: entry/done" >
										<a href="#" class="img todo_edit"><img src="./public/global/img/edit.png" border="0" /></a>
										<a href="#" class="img todo_del" ><img src="./public/global/img/del.png" border="0" /></a>
									</tal:block>
									<tal:block condition="entry/done" >
										<a href="#" class="img todo_edit"><img src="./public/global/img/edit.png" class="hidden" border="0" /></a>
										<a href="#" class="img todo_del" ><img src="./public/global/img/del.png" class="hidden" border="0" /></a>
									</tal:block>
									<input class="todo_id" type="hidden" tal:attributes="value entry/id" />
								</td>
							</tr>
						
						</tal:block>
					</tal:block>
				</tal:block>
            </tbody>
        </tal:block>
        
        <tr height="40px"><td> </td></tr>
        
        <tr>
        	<td colspan="6" align="right" class="new_todo ">
            	<input type="button" value="Neue Aufgabe" class="todo_new_todo" />
            </td>
        </tr>
    </table>
</span>



<span metal:define-macro="user_list" tal:omit-tag="" >
	<p align="left">
		Durch das an- und abw&auml;hlen der Personen werden die entsprechenden Aufgaben eingeblendet.<br />
    </p>    
    <table>
    	<tr>
        	<td colspan="2"><p><b>Zeige Aufgaben:</b></p></td>
        </tr>
        
        <tr class="show_todo all_todo">
        	<td><input name="show_todo" id="all_todo" type="radio" class="all_user" checked="checked" /></td>
            <td><label for="all_todo" style="cursor:pointer"><b>Alle</b></label></td>
        </tr>
        
        <tr class="show_todo my_todo">
        	<td>
            	<input name="show_todo" id="my_todo" type="radio" class="user" />
            	<input type="hidden" class="user_id" tal:attributes="value user/id" />
            </td>
            <td><label for="my_todo" style="cursor:pointer"><b>Meine</b></label></td>
        </tr>
        
        <tr class="show_todo no_user_todo">
        	<td><input name="show_todo" id="no_todo" type="radio" class="user" /></td>
            <td><label for="no_todo" style="cursor:pointer"><b>Nicht zugeteilte</b></label></td>
        </tr>
        
        <tr class="show_todo selectiv_todo">
        	<td><input name="show_todo" id="selectiv_todo" type="radio" class="user" /></td>
            <td><label for="selectiv_todo" style="cursor:pointer"><b>Gemäss auswahl</b></label></td>
        </tr>
        
        <tr><td colspan="2" style="border-bottom:2px black solid"></td></tr>
        
		<tal:block repeat="user user_list">
            <tr class="user_list_item real_user" >
                <td><input type="checkbox" class="user" checked="checked"/></td>
                <td>
                    <div class="drag_user">
                        <tal:block condition="user/scoutname">
                            <b><tal:block content="user/scoutname" /></b> / 
                        </tal:block>
                        <tal:block content="user/firstname" /> 
                        <tal:block content="user/surname" />
                    	<input type="hidden" class="user_id" tal:attributes="value user/id" />
                        <input type="hidden" class="user_name" tal:attributes="value user/name" />
                    </div>
                </td>
            </tr>
        </tal:block>
        
        <tr class="user_list_item no_user_todo_checkbox" >
			<td><input type="checkbox" class="user" checked="checked"/></td>
			<td><div><b>Nicht zugeteilte</b></div></td>
		</tr>
    </table>
</span>