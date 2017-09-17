<span metal:define-macro="dp_border" tal:omit-tag="">
    <div class="d_program_grey bgcolor_dp_bright toggle_border toggle_open">
        <div class="d_program_tag_title textcolor_dp_bright toggle_button">
            <!--
            <img class="d_program_tag_title_close hidden" src="public/application/event/img/close.png" border="0" />
            <img class="d_program_tag_title_open" src="public/application/event/img/open.png" border="0" />
            -->
            <span metal:define-slot="border_title" />
        </div>
        
        <div class="d_program_tag_content toggle_content">
        	<span metal:define-slot="border_content" />
        </div>
    </div>
</span>