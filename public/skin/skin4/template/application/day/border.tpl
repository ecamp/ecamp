<span metal:define-macro="border" tal:omit-tag="">

    <div class="day_left">
        <span tal:define="global box_title 		day/list_border/title" />
        <span tal:define="global box_content	day/list_border/macro" />
        <span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />
    </div>
    
    <div class="day_right">
        <span tal:define="global box_title 		day/day_border/title" />
        <span tal:define="global box_content	day/day_border/macro" />
        <span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />
    </div>

</span>