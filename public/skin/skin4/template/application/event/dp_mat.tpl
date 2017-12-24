<span metal:define-macro="dp_mat" tal:omit-tag="">
    <span metal:use-macro="dp_border.tpl/dp_border">
    	<span metal:fill-slot="border_title" tal:omit-tag="">Material:</span>
    	
		<span metal:fill-slot="border_content" tal:omit-tag="">
			<table width="100%">				
				<tr>
					<td><b>Vorhandenes Material:</b></td>
				</tr>
				<tr>
					<td valign="top">
						<table width="100%" cellpadding="0" cellspacing="0" >
							<tr>
								<td width="10%">Menge:</td>
								<td width="90%">Artikel:</td>
							</tr>
						</table>
						<table width="100%" cellpadding="0" cellspacing="0" id="mat_available_table">
							<tal:block repeat="mat_stuff_stocked mat_stuff_stocked_list">
								<tr tal:attributes="id mat_stuff_stocked/id">
									<td width="15%"><tal:block content="mat_stuff_stocked/quantity" /></td>
									<td><tal:block content="mat_stuff_stocked/article_name" /></td>
								</tr>
							</tal:block>
						</table>
					</td>
				</tr>

				<tr>
					<td><b>Zu organisierendes Material:</b></td>
				</tr>
				<tr>
					<td valign="top">
						<table width="100%" cellpadding="0" cellspacing="0" >
							<tr>
								<td width="10%">Menge:</td>
								<td width="90%">Artikel:</td>
							</tr>
						</table>
						<table width="100%" cellpadding="0" cellspacing="0" id="mat_organize_table">
							<tal:block repeat="mat_article_event mat_article_event_list">
								<tr tal:attributes="id mat_article_event/id">
									<td width="15%"><tal:block content="mat_article_event/quantity" /></td>
									<td><tal:block content="mat_article_event/list_name" /></td>
									<td><tal:block content="mat_article_event/resp_str" /></td>
								</tr>
							</tal:block>
						</table>
					</td>
				</tr>
				
			</table>
		</span>
	</span>
</span>