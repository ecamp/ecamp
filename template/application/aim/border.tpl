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


<!--

	<div style="width=100%; margin-bottom:20px;">
	
      	<span tal:define="global box_title		'Kursziele'" />
        <span tal:define="global box_content	'${tpl_dir}/application/aim/main.tpl/home'" />
        <span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />
    
    </div>
    
    <div style="width:100%; position:absolute; top:240px;">
    
        	
            <div style="position:absolute; left:0px; width:400px; float:left; height:100%;">
                
                <span tal:define="global box_title 		'Leitziele'" />
                <span tal:define="global box_content	'${tpl_dir}/application/aim/main.tpl/level1'" />
        		<span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />
    
            </div>
            

            <div style="position:absolute; left: 400px; width: 100px; vertical-align:middle; text-align:center; float:left; height:400px;">              
              <img src="public/global/img/process_arrow.png" style="margin-left:4px; margin-top:90px;" border="0" />
            </div>
         
            <div style="position:absolute; left: 500px; right: 0px; float:left; height:100%;">
                <span tal:define="global box_title		'Ausbildungsziele'" />
                <span tal:define="global box_content	'${tpl_dir}/application/aim/main.tpl/level2'" />
                <span metal:use-macro="${tpl_dir}/global/content_box_fit.tpl/predefine" />
            </div>
                     
    </div>
-->

</span>