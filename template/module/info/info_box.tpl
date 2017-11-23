<span metal:define-macro="info_box" tal:omit-tag="">
	
	<div class="menu_title">
		<tal:block content="info_box_title" />
		<div style="position:absolute; right:4px; top:0px">
			<img id="info_box_button_down" src="public/module/img/down.png" />
			<img id="info_box_button_up" src="public/module/img/up.png" class="hidden" />
		</div>
	</div>
	<div id="info_box_border" class="menu menu_box" align="left">
    	<table tal:content="structure info_box_content" width="100%">
    		
    	</table>
    </div>
	
</span>