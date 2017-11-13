<span metal:define-macro="info_box">
	<div class="menu_title">
		<tal:block content="info_box_title" />
		<img id="info_box_button_down" src="public/module/img/down.png" />
		<img id="info_box_button_up" src="public/module/img/up.png" class="hidden" />
	</div>
	<div class="menu menu_box">
    	<table tal:content="structure info_box_content" width="100%"></table>
    </div>
</span>