<span metal:define-macro="border" tal:omit-tag="">
	<table style="position:absolute; left:0px; width:100%;" border="0">
		<colgroup>
			<col width="50%" />
			<col width="50px" />
			<col width="50%" />
		</colgroup>

		<tr>
			<td colspan="3" >
				<span tal:define="global box_title		'Kursziele'" />
				<span tal:define="global box_content	'${tpl_dir}/application/aim/main.tpl/home'" />
				<span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />
			</td>
		</tr>

		<tr tal:condition="not:overview">
			<td>
				<span tal:define="global box_title 		'Leitziele'" />
				<span tal:define="global box_content	'${tpl_dir}/application/aim/main.tpl/level1'" />
				<span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />
			</td>
			<td align="center">
				<img src="public/global/img/process_arrow.png" style="margin-left:4px; margin-top:90px;" border="0" />
			</td>
			<td >
				<span tal:define="global box_title		'Ausbildungsziele'" />
				<span tal:define="global box_content	'${tpl_dir}/application/aim/main.tpl/level2'" />
				<span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />
			</td>
		</tr>

		<tr tal:condition="overview">
			<td colspan="3">
				<span tal:define="global box_title 		'Zielübersicht'" />
				<span tal:define="global box_content	'${tpl_dir}/application/aim/main.tpl/overview'" />
				<span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />
			</td>
		</tr>
	</table>
</span>