<span metal:define-macro="select" tal:omit-tag="">
	<div style="width:90%; font-style:italic" align="left">
	    	Material, welches für das Lager organisiert werden muss, kann einem Leiter oder 
	    	einer Einkaufsliste zugeordnet werden. Welche Einkaufslisten existieren sollen, wird 
	    	hier definiert.
	    	Beispiele: Lebensmittel, Baumarkt
	    </div>
	    
	<ul type="none">
		<li><h1>Leiter:</h1></li>
		<ul type="none">
			<tal:block repeat="user mat_list/users">
				<li>
					<a tal:attributes="href user/href">
						<tal:block content="user/display_name" />
					</a>
				</li>
			</tal:block>
		</ul>
		<li><h1>Einkaufslisten:</h1></li>
		<ul class="mat_list" type="none" style="position:relative; left:-20px;">
			<tal:block repeat="mat_list mat_list/mat_lists">
				<li>
					<a href="#" class="edit hidden"><img src="public/global/img/edit.png" /></a>
	    			<a href="#" class="del"><img src="public/global/img/del.png" /></a>
	    				
					<a tal:attributes="href mat_list/href">
						<tal:block content="mat_list/name" />
					</a>
					
					<input type="hidden" class="mat_list_id" tal:attributes="value mat_list/id" />
				</li>
			</tal:block>
			
			<li class="hidden" id="mat_list_example">
	    		<a href="#" class="edit hidden"><img src="public/global/img/edit.png" /></a>
    			<a href="#" class="del"><img src="public/global/img/del.png" /></a>
    				
				<a class="mat_list_name" />
				
				<input type="hidden" class="mat_list_id" />
	    	</li>
		</ul>
	</ul>
	
	
	<div>
		<input type="button" id="mat_list_add" value="Neue Einkaufsliste" />
	</div>
	
</span>