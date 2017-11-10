<span metal:define-macro="predefine" tal:omit-tag="">
    <div class="col-xs-12 col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading" tal:content="box_title"></div>
            <div class="panel-body">
                <span metal:use-macro="${box_content}" />
            </div>
        </div>
    </div>
</span>

<span metal:define-macro="slot" tal:omit-tag="">
    <div class="panel panel-default">
        <div class="panel-heading">
        	<span metal:define-slot="box_title" />
        </div>
        <div class="panel-body ">
            <span metal:define-slot="box_content" />
        </div>
    </div>
</span>