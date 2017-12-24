<span metal:define-macro="dp_main" tal:omit-tag="">
	<div style="display:table; width:100%">
		<div style="display:table-row; width:100%">
			<div id="dp_main_left">
				<span metal:use-macro="dp_header.tpl/dp_header" />
								
				<span metal:use-macro="dp_ablauf.tpl/dp_ablauf" />
                <span metal:use-macro="dp_mat.tpl/dp_mat" />
			</div>
			<div id="dp_main_right">
				<span metal:use-macro="dp_ls_head.tpl/dp_ls_head" tal:condition="php: form_type == 1" />
				<span metal:use-macro="dp_la_head.tpl/dp_la_head" tal:condition="php: form_type == 2" />
				<span metal:use-macro="dp_lp_head.tpl/dp_lp_head" tal:condition="php: form_type == 3" />
				<span metal:use-macro="dp_course_head.tpl/dp_course_head" tal:condition="php: form_type == 4" />

				<span metal:use-macro="dp_siko.tpl/dp_siko" />
				<!-- <span metal:use-macro="dp_pdf.tpl/dp_pdf" /> -->	
				<span metal:use-macro="dp_comment.tpl/dp_comment" />
			</div>
		</div>
	</div>
</span>