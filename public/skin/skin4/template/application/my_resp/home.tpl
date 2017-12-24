<span metal:define-macro="home" tal:omit-tag="">
    <!-- 
    	day_jobs
    	events
    	todo's
    	mat_list
    -->
    <center>
		<p >Hier werden ausschliesslich Daten angezeigt, für welche <small style="font-size: 9px">(auch)</small> du verantwortlich bist.</p>
		
		<table width="90%">
    		<tr>
				<td width="50%" valign="top">
					<div align="left">
						<h2><a href="index.php?app=program">Blöcke</a></h2>
						
						<ul align="left">
							<tal:block repeat="date events">
								<li class="top">
									(<tal:block content="date/day_offset" />)
									<tal:block content="date/date" />
								</li>
								<ul tal:repeat="event date/data">
									<li class="bottom">
										<a href="#" tal:attributes="onClick event/link">
											<tal:block condition="event/show_event_nr">
												(<tal:block content="event/day_offset" />.<tal:block content="event/event_nr" />)
											</tal:block>
											
											<tal:block condition="event/short_name">
												<b tal:attributes="style event/color_str" class="short_name">
													<tal:block content="event/short_name" />:
												</b>
											</tal:block>
											<font tal:attributes="color event/prog_color">
												<tal:block content="event/name" />
											</font>
										</a>
									</li>
								</ul>
							</tal:block>
						</ul>
					</div>
					
				</td>
    			<td width="50%" valign="top">
    				<div align="left">
						<h2><a href="index.php?app=todo">Aufgaben</a></h2>
						
						<ul align="left">
							<li tal:repeat="todo todos">
								<font color="red" tal:condition="not: todo/done">
									<tal:block content="todo/date_string" /> - 
									<tal:block content="todo/title" />
								</font>
								
								<font color="green" tal:condition="todo/done">
									<tal:block content="todo/date_string" /> - 
									<tal:block content="todo/title" />
								</font>
							</li>
						</ul>
						
					</div>
					
					<div align="left">
						<h2><a href="index.php?app=day">Tagesaufgaben</a></h2>
						
						<ul align="left">
							<tal:block repeat="day_job day_jobs">
								<li class="top">
									<a tal:attributes="href day_job/link">
										(<tal:block content="day_job/day_offset" />)
										<tal:block content="day_job/date" />
									</a>
								</li>
								<ul tal:repeat="date day_job/data">
									<li tal:content="date/job_name"></li>
								</ul>
							</tal:block>
						</ul>
						
					</div>
				</td>
			</tr>
		</table>
	</center>
    
        
</span>