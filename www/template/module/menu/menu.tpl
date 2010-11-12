<span metal:define-macro="menu" tal:omit-tag="">
    <!--
    <form action="index.php" style="margin-bottom:4px;" class="admin_menu hidden">
        <select onChange="this.form.submit()" name="skin">
            <option></option>
			<option value="skin1">skin1</option>
            <option value="skin2">skin2</option>
            <option value="skin3">skin3</option>
		</select>
        <input type="hidden" name="app" value="home" />
        <input type="hidden" name="cmd" value="action_change_skin" />
    </form>
    -->
    
    
    
    <span tal:condition="user/admin" tal:omit-tag="" >
        <div class="menu hidden menu_box admin_menu" align="left">
          <a  href="index.php?app=db&cmd=statistics">Statistik</a><br />
          <a  href="index.php?app=db&cmd=integrity">Integrit&auml;t</a><br />
          <a  href="index.php?app=support">Support</a><br />
          <a  href="https://admin.hostpoint.ch/phpMyAdmin/?db=pfadiluz_ecamp2&server=164" target="_blank">phpMyAdmin</a><br />
        </div>
	</span>
	
	
	
    <div class="menu menu_box" align="left">
          <a href="index.php" tal:attributes="class php: app=='home' && cmd=='home'?'actual_menu':''">Home</a><br />
          <a href="index.php?app=invent" tal:attributes="class php: app=='invent'?'actual_menu':''">Einladen</a><br />
          <a href="index.php?app=user_profile" tal:attributes="class php: app=='user_profile'?'actual_menu':''">Mein Profil</a><br />
          <a href="index.php?app=camp_admin" tal:attributes="class php: app=='camp_admin'?'actual_menu':''">Meine Lager</a><br />
          <a href="index.php?app=home&cmd=feedback" tal:attributes="class php: app=='home' && cmd=='feedback'?'actual_menu':''">Feedback</a><br />
          <a href="index.php?app=home&cmd=help" tal:attributes="class php: app=='home' && cmd=='help'?'actual_menu':''">Hilfe</a>
    </div>
    
    <form action="index.php" style="margin-top: 20px; margin-bottom:4px;">
        <select onChange="this.form.submit()" name="camp" style="width:100%">
			<option tal:condition="php: camp.id == 0" value="0" selected="selected" >Lager w&auml;hlen</option>
	        <tal:block repeat="optgroup menu_dropdown">
	            <optgroup tal:attributes="label optgroup/group_name" tal:condition="optgroup/child_num">
	            	<tal:block repeat="option optgroup/camp_list">
	                	<tal:block condition="not: option/past">
	                		<option tal:condition="not: option/selected" tal:content="option/short_name" tal:attributes="value option/id">Lagername</option>
	                	</tal:block>
	                	<option tal:condition="option/selected" tal:content="option/short_name" tal:attributes="value option/id" selected="selected">Lagername</option>
	                </tal:block>
	            </optgroup>
            </tal:block>
            
            <optgroup label="______________">
            	<option value="old_camp">ältere Lager</option>
            </optgroup>
            
		</select>
        <input type="hidden" name="app" value="camp" />
        <input type="hidden" name="cmd" value="action_change_camp" />
    </form>
    
    <span tal:condition="php: camp.id > 0" tal:omit-tag="">
        <div class="menu_title">Lager-/Kursplanung:</div>
        <div class="menu menu_box" align="left">
            <div class="menu_group">
	            <a href="index.php?app=camp" tal:attributes="class php: app=='camp'?'actual_menu':''">Infos zum Lager</a><br />
	            
	            <span tal:condition="php: user_camp.auth_level >= 50" tal:omit-tag="">
	            	<a href="index.php?app=option" tal:attributes="class php: app=='option'?'actual_menu':''">Einstellungen</a><br />
	            </span>
            </div>
            
	        <div class="menu_group" tal:condition="php: camp.is_course > 0">
		        <a href="index.php?app=aim" tal:attributes="class php: app=='aim'?'actual_menu':''">Kurs Ziele</a><br />
	            <a href="index.php?app=course_checklist" tal:attributes="class php: app=='course_checklist'?'actual_menu':''">Kurs Checkliste</a><br />
	        </div>
            
            <div class="menu_group">
		        <a href="index.php?app=leader" tal:attributes="class php: app=='leader'?'actual_menu':''">Leiterliste</a><br />
	            <a href="index.php?app=todo" tal:attributes="class php: app=='todo'?'actual_menu':''">Aufgabenliste</a><br />
	            <a href="index.php?app=mat_list" tal:attributes="class php: app=='mat_list'?'actual_menu':''">Materiallisten</a><br />
	        </div>
            
            <div class="menu_group">
		        <a href="index.php?app=day" tal:attributes="class php: app=='day'?'actual_menu':''">Tages&uuml;bersicht</a><br />
	            <a href="index.php?app=program" tal:attributes="class php: app=='program'?'actual_menu':''">Programm</a><br />
	        </div>
	        
            <div class="menu_group">
		        <a href="index.php?app=my_resp" tal:attributes="class php: app=='my_resp'?'actual_menu':''">Meine Verantwortung</a><br />
				<a href="index.php?app=print" tal:attributes="class php: app=='print'?'actual_menu':''">PDF Drucken</a><br />
        	</div>
        </div>
<!--        
        <div class="menu_title">PDF/Drucken:</div>
        <div class="menu menu_box" align="left">
			<a  href="index.php?app=print&cmd=g_program">Grobprogramm</a><br />
			<a  href="#">Materialliste</a>  
        </div>
-->
    </span>
</span>