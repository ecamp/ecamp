<span metal:define-macro="predefine" tal:omit-tag="">
    <div class="content_border_full bgcolor_content">
		<div class="content_box_head" tal:content="box_title"></div>
		<div class="content_box_full">
			<span metal:use-macro="${box_content}" />
		</div>
	</div>
</span>

<span metal:define-macro="slot" tal:omit-tag="">
    <div class="content_border_full bgcolor_content">
        <div class="content_box_head">
        	<span metal:define-slot="box_title" />
        </div>
        <div class="content_box_full">
            <span metal:define-slot="box_content" />
        </div>
    </div>
</span>