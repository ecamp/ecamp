<span metal:define-macro="home" tal:omit-tag="">
	<table width="100%" cellspacing="0" cellpadding="2">
		<colgroup>
			<col width="100%" />
		</colgroup>
		<tr>
			<td>
				<span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/slot">
		            <span metal:fill-slot="box_title" tal:omit-tag="">Willkommen bei eCamp2</span>
		            <span metal:fill-slot="box_content" tal:omit-tag="">
		                <span metal:use-macro="${tpl_dir}/application/home/welcome_msg.tpl/welcome" />
		            </span>
		        </span>
			</td>
		</tr>
		<tr>
			<td>
				<span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/slot" tal:condition="false">
		            <span metal:fill-slot="box_title" tal:omit-tag="">Kommentare</span>
		            <span metal:fill-slot="box_content" tal:omit-tag="">
		                <span metal:use-macro="${tpl_dir}/application/home/comment.tpl/main" />
		            </span>
		        </span>  
			</td>
		</tr>
		<tr>
			<td>
				<span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/slot">
		            <span metal:fill-slot="box_title" tal:omit-tag="">News</span>
		            <span metal:fill-slot="box_content" tal:omit-tag="">
		                <span metal:use-macro="${tpl_dir}/application/home/news.tpl/main" />
		            </span>
		        </span>
			</td>
		</tr>
	</table>
</span>
