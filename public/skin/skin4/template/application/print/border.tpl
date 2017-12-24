<span metal:define-macro="border" tal:omit-tag="">
	
	<table cellpadding="2" cellspacing="0" width="100%">
		<colgroup>
			<col width="*" />
			<col width="200px" />
		</colgroup>
		<tr>
			<td rowspan="2">
				<span tal:define="global box_title 		print/view/title" />
		        <span tal:define="global box_content	print/view/macro" />
		        <span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />
			</td>
			<td>
				<span tal:define="global box_title 		print/libary/title" />
		        <span tal:define="global box_content	print/libary/macro" />
		        <span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />
			</td>
		</tr>
		<tr>
			<td>
				<span tal:define="global box_title 		print/bin/title" />
		        <span tal:define="global box_content	print/bin/macro" />
		        <span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />
		    </td>
		</tr>
	</table>
</span>