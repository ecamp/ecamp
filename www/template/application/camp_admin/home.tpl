<span metal:define-macro="home" tal:omit-tag="">
    
    
    
    <table width="100%" border="0">
		<tr>
			<td>
				<div align="left" width="75%">
			    	Eigene Lager k&ouml;nnen gel&ouml;scht werden. Aus Lagern, in denen man zur Mitarbeit eingeladen wurde, kann man hier wieder austreten.<br />
			    	Durch anklicken des Titels kann sofort zum gewählten Lager gewechselt werden.<br />
			    &nbsp;</div>
			</td>
			<td tal:condition="not: show_list" width="15%" align="center" >
				<a href="index.php?app=camp_admin&show_list=1">Liste zeigen</a>
			</td>
			<td tal:condition="show_list" width="15%" align="center" >
				<a href="index.php?app=camp_admin">Visitenkarten zeigen</a>
			</td>
			<td align="right" width="10%">
				<form action="index.php">
					<input type="submit" value="Neues Lager erstellen" id="add_new_camp" />
					<input type="hidden" name="app" value="camp_admin" />
					<input type="hidden" name="cmd" value="new_camp" />
				</form>
				
				<form action="index.php">
					<input type="submit" value="Neuen Kurs erstellen" id="add_new_camp" />
					<input type="hidden" name="app" value="camp_admin" />
					<input type="hidden" name="cmd" value="new_course" />
				</form>
			</td>
		</tr>
	</table>
	
    <center class="center">
	    <tal:block condition="request_camp_show">
		    <h1 align="center">Einladungen:</h1>
		    <div align="center">
		        <div style="width:280px; display:inline-block; border:1px black solid; margin-right:10px" tal:repeat="request request_camp_list" class="bgcolor_content invention">
		            <form style="width:280px" action="index.php">
		            <table width="280px" cellspacing="20px">
		             <tr align="left">
		                <td width="100%">Du hast eine neue Lager-Einladung von <b tal:content="request/from"></b> erhalten:<br /><br />
		                    <table>
		                    <tr>
		                      <td>Gruppe: </td><td tal:content="request/scout"><!-- scout --></td>
		                    </tr>
		                    <tr>
		                      <td>Lagername: </td><td tal:content="request/name"><!-- name --> </td>
		                    </tr>
		                    <tr>
		                      <td>Motto: </td><td tal:content="request/slogan"><!-- slogan --></td>
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
		        <br />
		        <br />
		    </div>
		</tal:block>
		
	    <h1 align="center">Kommende Lager:</h1>
		<div align="center" tal:condition="not: show_list">
	        <div style=" display:inline-block; margin-right:10px" tal:repeat="camp_detail active_camp_list" class="bgcolor_content invention">
	    		<tal:block condition="not: camp_detail/past">
					<a href="#" tal:attributes="href camp_detail/change_camp">
							<table class="camp camp_frame" width="100%">
								<tr class="camp">
									<td colspan="3">
										<a href="#" tal:attributes="href camp_detail/change_camp" >
											<p class="camp_slogan" tal:content="camp_detail/short_name"></p>
										</a>
									</td>
								</tr>
								<tr>
									<td>Pfadi:</td>
									<td colspan="2" tal:content="camp_detail/group_name"></td>
								</tr>
								<tr>
									<td>Lagername:</td>
									<td colspan="2" tal:content="camp_detail/name"></td>
								</tr>
								<tr>
									<td>Motto:</td>
									<td colspan="2" tal:content="camp_detail/slogan"></td>
								</tr>
								<tr>
									<td>Datum:</td>
									<td colspan="2"><tal:block content="camp_detail/start" /> - <tal:block content="camp_detail/end" /></td>
								</tr>
								<tr>
									<td>Ersteller:</td>
									<td colspan="2" tal:content="camp_detail/creator" ></td>
								</tr>
								<tr><td colspan="3" class="seperator"><p></p></td></tr>
								<tr>
									<td>Meine Funktion:</td>
									<td tal:content="camp_detail/function" ></td>
									<td align="right" class="camp_option">
										<form class="form">
											<input type="hidden" name="camp_id" tal:attributes="value camp_detail/id" />
											<input type="hidden" name="user_camp_id" tal:attributes="value camp_detail/user_camp_id" />
										</form>
										<div tal:condition="camp_detail/delete"><a href="#" class="delete" ><img src="public/application/camp_admin/img/del.png" border="0" class="tooltip" title="L&ouml;schen :: Dieses Lager l&ouml;schen."/></a></div>
										<div tal:condition="camp_detail/exit"><a href="#" class="exit"><img src="public/application/camp_admin/img/exit.png" border="0" class="tooltip" title="Verlassen :: Dieses Lager verlassen" /></a></div>
									</td>
								</tr>
							</table>
					</a>
				</tal:block>
	        </div>
	    </div>
		<div align="center" tal:condition="show_list">
	        <table width="80%" style="border:1px solid black">
	        	<thead align="left">
	        		<tt>
	        			<th>Pfadi:</th>
	        			<th>Lagername:</th>
	        			<th>Motto:</th>
	        			<th>Datum:</th>
	        			<th>Ersteller:</th>
	        			<th>Option:</th>
	        		</tt>
	        	</thead>
	        	<tbody>
	        		<tr tal:repeat="camp_detail active_camp_list" class="camp_frame">
	        			<tal:block condition="not: camp_detail/past">
	        				<td><a href="#" tal:content="camp_detail/group_name" tal:attributes="href camp_detail/change_camp" /></td>
	        				<td><a href="#" tal:content="camp_detail/name" tal:attributes="href camp_detail/change_camp" /></td>
	        				<td><a href="#" tal:content="camp_detail/slogan" tal:attributes="href camp_detail/change_camp" /></td>
	        				<td>
	        					<tal:block content="camp_detail/start" /> - <tal:block content="camp_detail/end" />
	        				</td>
	        				<td tal:content="camp_detail/creator" />
	        				<td class="camp_option">
	        					<form class="form">
									<input type="hidden" name="camp_id" tal:attributes="value camp_detail/id" />
									<input type="hidden" name="user_camp_id" tal:attributes="value camp_detail/user_camp_id" />
								</form>
								<div tal:condition="camp_detail/delete"><a href="#" class="delete" ><img src="public/application/camp_admin/img/del.png" border="0" class="tooltip" title="L&ouml;schen :: Dieses Lager l&ouml;schen."/></a></div>
								<div tal:condition="camp_detail/exit"><a href="#" class="exit"><img src="public/application/camp_admin/img/exit.png" border="0" class="tooltip" title="Verlassen :: Dieses Lager verlassen" /></a></div>
							</td>
	        			</tal:block>
	        		</tr>
	        	</tbody>
	        </table>
	    </div>
		
	    
		<br />
		<br />	
	    
	    <h1 align="center">Vergangene Lager:</h1>
		<div align="center">
	        <table width="80%" style="border:1px solid black">
	        	<thead align="left">
	        		<tt>
	        			<th>Pfadi:</th>
	        			<th>Lagername:</th>
	        			<th>Motto:</th>
	        			<th>Datum:</th>
	        			<th>Ersteller:</th>
	        			<th>Option:</th>
	        		</tt>
	        	</thead>
	        	<tbody>
	        		<tr tal:repeat="camp_detail active_camp_list" class="camp_frame">
	        			<tal:block condition="camp_detail/past">
	        				<td><a href="#" tal:content="camp_detail/group_name" tal:attributes="href camp_detail/change_camp" /></td>
	        				<td><a href="#" tal:content="camp_detail/name" tal:attributes="href camp_detail/change_camp" /></td>
	        				<td><a href="#" tal:content="camp_detail/slogan" tal:attributes="href camp_detail/change_camp" /></td>
	        				<td>
	        					<tal:block content="camp_detail/start" /> - <tal:block content="camp_detail/end" />
	        				</td>
	        				<td tal:content="camp_detail/creator" />
	        				<td class="camp_option">
	        					<form class="form">
									<input type="hidden" name="camp_id" tal:attributes="value camp_detail/id" />
									<input type="hidden" name="user_camp_id" tal:attributes="value camp_detail/user_camp_id" />
								</form>
								<div tal:condition="camp_detail/delete"><a href="#" class="delete" ><img src="public/application/camp_admin/img/del.png" border="0" class="tooltip" title="L&ouml;schen :: Dieses Lager l&ouml;schen."/></a></div>
								<div tal:condition="camp_detail/exit"><a href="#" class="exit"><img src="public/application/camp_admin/img/exit.png" border="0" class="tooltip" title="Verlassen :: Dieses Lager verlassen" /></a></div>
							</td>
	        			</tal:block>
	        		</tr>
	        	</tbody>
	        </table>
	    </div>
	</center>
</span>