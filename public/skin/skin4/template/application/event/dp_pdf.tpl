<span metal:define-macro="dp_pdf" tal:omit-tag="">
    <span metal:use-macro="dp_border.tpl/dp_border">
    	<span metal:fill-slot="border_title" tal:omit-tag="">PDF Hochladen:</span>
    	
    	<span metal:fill-slot="border_content" tal:omit-tag="">
   			<table width="100%">
				<tr>
					<td width="50%" valign="top">
						<b>PDF:</b>
					</td>
					<td width="50%" valign="top">
						<div id="dp_pdf_button"><input type="button" value="Neues PDF hochladen" /></div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%" border="0">
							<colgroup>
								<col width="20px;" />
								<col width="*" />
								<col width="20px;" />
								<col width="20px;" />
								<col width="20px;" />
							</colgroup>
							
							<tbody class="event_document_list">
								<tr tal:repeat="document documents">
									<td>
										<img class="file_icon" tal:attributes="src document/type_img_src" />
									</td>
									<td tal:content="document/filename">
										name
									</td>
									<td >
										<img class="file_del" style="cursor: pointer;" src="public/global/img/del.png" />
									</td>
									<td>
										<a class="download_link" tal:attributes="href document/download_link"><img class="file_download" style="cursor: pointer;" src="public/global/img/download.png" /></a>
									</td>
									<td>
										<input type="checkbox" class="file_print" style="height: 16px;" />
										<input type="hidden" class="file_id" tal:attributes="value document/id" />
									</td>
									
								</tr>
							</tbody>
							<tr class="hidden event_document_sample">
								<td class="icon">
									<img class="file_icon" />
								</td>
								<td class="name">
									name
								</td>
								<td>
									<img class="file_del" style="cursor: pointer;" src="public/global/img/del.png" />
								</td>
								<td>	
									<a class="download_link"><img class="file_download" style="cursor: pointer;" src="public/global/img/download.png" /></a>
								</td>
								<td>
									<input type="checkbox" class="file_print" style="height: 16px;" />
									<input type="hidden" class="file_id" />
								</td>
								
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</span>
	</span>
</span>