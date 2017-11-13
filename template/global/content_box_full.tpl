<p metal:define-macro="predefine" tal:omit-tag="">
    <div>
		<div class="" tal:content="box_title"></div>
		<div class="content_box_full">
			<span metal:use-macro="${box_content}" />
		</div>
	</div>
</p>
<p metal:define-macro="slot" tal:omit-tag="">
    <div class="">
        <div class="content_box_head">
        	<span metal:define-slot="box_title" />
        </div>
        <div class="content_box_full">
            <span metal:define-slot="box_content" />
        </div>
    </div>
</p>