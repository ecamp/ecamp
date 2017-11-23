<span metal:define-macro="home" tal:omit-tag="">
	<table width="100%" cellspacing="0" cellpadding="2">
		<colgroup>
			<col width="50%" />
			<col width="50%" />
		</colgroup>
		
		<tr>
			<td colspan="2">
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
				<span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/slot">
		            <span metal:fill-slot="box_title" tal:omit-tag="">Information</span>
		            <span metal:fill-slot="box_content" tal:omit-tag="">
		                <span metal:use-macro="${tpl_dir}/application/home/info.tpl/info" />
		            </span>
		        </span>
			</td>
			<td rowspan="2">
				<span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/slot" tal:condition="false">
		            <span metal:fill-slot="box_title" tal:omit-tag="">Kommentare</span>
		            <span metal:fill-slot="box_content" tal:omit-tag="">
		                <span metal:use-macro="${tpl_dir}/application/home/comment.tpl/main" />
		            </span>
		        </span>
		        
		        <span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/slot" tal:condition="true">
		            <span metal:fill-slot="box_title" tal:omit-tag="">eCamp entwickelt sich weiter</span>
		            <span metal:fill-slot="box_content" tal:omit-tag="">
		                <span metal:use-macro="${tpl_dir}/application/home/team.tpl/team" />
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
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
</span>