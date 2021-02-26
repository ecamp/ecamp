<span metal:define-macro="border" tal:omit-tag="">
	
	<table cellpadding="2" cellspacing="0" width="100%">
		<colgroup>
			<col width="30%" />
			<col width="70%" />
		</colgroup>
		<tr>
			<td rowspan="2">
				<span tal:define="global box_title 		option/jobs/title" />
		        <span tal:define="global box_content	option/jobs/macro" />
		        <span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />
			</td>
			<td>
				<span tal:define="global box_title 		option/category/title" />
		        <span tal:define="global box_content	option/category/macro" />
		        <span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />
			</td>
		</tr>
	</table>
</span>