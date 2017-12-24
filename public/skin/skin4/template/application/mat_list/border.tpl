<span metal:define-macro="border" tal:omit-tag="">
	
	<table cellpadding="2" cellspacing="0" width="100%">
		<colgroup>
			<col width="20%" />
			<col width="80%" />
		</colgroup>
		<tr>
			<td rowspan="2">
				<span tal:define="global box_title 		mat_list/select/title" />
		        <span tal:define="global box_content	mat_list/select/macro" />
		        <span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />
			</td>
			<td>
				<span tal:define="global box_title 		mat_list/display/title" />
		        <span tal:define="global box_content	mat_list/display/macro" />
		        <span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />
			</td>
		</tr>
	</table>
</span>