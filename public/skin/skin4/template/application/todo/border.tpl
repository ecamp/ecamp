<span metal:define-macro="border" tal:omit-tag="">

        	<div class="todo_left" >
                <span tal:define="global box_title		'Aufgabenliste'" />
                <span tal:define="global box_content	'${tpl_dir}/application/todo/home.tpl/todo_list'" />
                <span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />
            </div>
            <div class="todo_right" >
                <span tal:define="global box_title		'Userliste'" />
                <span tal:define="global box_content	'${tpl_dir}/application/todo/home.tpl/user_list'" />
                <span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />
            </div>
        
       
</span>