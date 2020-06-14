<span metal:define-macro="border" tal:omit-tag="">
	
	<div style="position:relative; ">
		<table width="100%">
			<colgroup>
				<col width="50%" />
				<col width="50%" />
			</colgroup>
			<tr>
				<td colspan="2">
					<div style="position:relative; width:100%; float:left;">
						<span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/slot">
				            <span metal:fill-slot="box_title" tal:omit-tag="">Checklisten (PBS / J+S)</span>
				            <span metal:fill-slot="box_content" tal:omit-tag="">
				               <!--  <span metal:use-macro="${tpl_dir}/application/aim/main.tpl/home" /> -->
				               Hier werden die vorgegebenen Checklisten von PBS und J+S übersichtlich dargestellt.
				               <br />
				               Du siehst zu jedem Punkt gleich, ob dieser durch einen deiner Blöcke abgedeckt ist.
				               
				               <br/><br/>
				               <div tal:condition="new_checklist">
				               		Für die Kurssaison 2012 sind von der PBS neue Checklisten veröffentlicht worden. Du kannst die neuen Checklisten übernehmen. Die Verknüpfungen mit der alten Checkliste werden dabei gelöscht.
				               		
				               		<form action="index.php">
										<input type="submit" value="Neue Checkliste übernehmen" id="new_checklist" />
										<input type="hidden" name="app" value="course_checklist" />
										<input type="hidden" name="cmd" value="action_new_checklist" />
									</form>
				       
				               </div>
				               
				            </span>
				        </span>
			        </div>
				</td>
			</tr>
			
			<tr>
				<td>
					<div style="position:relative; width:100%;">
						<span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/slot">
				    
				            <span metal:fill-slot="box_title" tal:omit-tag="">Checkliste PBS:</span>
				            <span metal:fill-slot="box_content" tal:omit-tag="">
				
				              	<span tal:define="list pbs_list" metal:use-macro="${tpl_dir}/application/course_checklist/checklist.tpl/checklist" />
				            </span>
				        </span>
			        </div>
				</td>
				<td style="position:relative">
					<div style="position:relative; width:100%;">
				        <span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/slot">
				    
				            <span metal:fill-slot="box_title" tal:omit-tag="">Checkliste J+S:</span>
				            <span metal:fill-slot="box_content" tal:omit-tag="">
				
				              	<span tal:define="list js_list" metal:use-macro="${tpl_dir}/application/course_checklist/checklist.tpl/checklist" />
				            </span>
				        </span>
			        </div>
				</td>
			</tr>
		</table>
    </div>
</span>