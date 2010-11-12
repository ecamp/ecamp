	<script tal:content="structure js_code" type="text/javascript" language="javascript"></script>
    
	
	<script tal:content="structure observer" 		type="text/javascript" language="javascript"></script>
	<script tal:content="structure autocompleter" 	type="text/javascript" language="javascript"></script>
	
	
	<script tpye="text/javascript">
		/*
		Asset.css( "public/application/event/css/home.css" );
		Asset.css( "public/application/event/css/autocompliter.css" );
		Asset.css( "public/global/css/tips.css" );
		*/
	</script>
	
	

	<div id="d_program" class="d_program">
    	<div class="d_program_transp"></div>
        <div class="d_program_border bgcolor_dp_dark">
            <div class="d_program_content" id="d_program_content">
            	
                <div class="d_program_white">
                    <table width="100%">
                    	<tr>
                    		<td>
			                	<div style="font-size:20px; font-weight:bold; margin:0px; display:inline" id="dp_nr" tal:content="event_nr"></div>
			                    <div style="font-size:20px; font-weight:bold; margin:0px; display:inline" id="dp_nr" tal:content="category_short"></div>
			                    <div style="font-size:20px; font-weight:bold; margin:0px; display:inline" id="dp_name" tal:content="name"></div>
			                </td>
                    		<td>
                    			<div style="font-size:15px; font-weight:bold; text-align: right">Fortschritt:</div>
                    		</td>
                    		<td width="50px">
			                    <select name="event_progress" id="event_progress" tal:attributes="initvalue event_progress">
		                    		<option value="0">0%</option>
		                    		<option value="10">10%</option>
		                    		<option value="20">20%</option>
		                    		<option value="30">30%</option>
		                    		<option value="40">40%</option>
		                    		<option value="50">50%</option>
		                    		<option value="60">60%</option>
		                    		<option value="70">70%</option>
		                    		<option value="80">80%</option>
		                    		<option value="90">90%</option>
		                    		<option value="100">100%</option>
		                    	</select>
                    		</td>
                    	</tr>
                    </table>
                    
                    
                    
                </div>
                
				<span metal:use-macro="dp_main.tpl/dp_main" />
				
            </div>
            	
        </div>
        
        <div class="d_program_title">
            Detailprogramm:
        </div>
        
        <div class="d_program_close">
            <a href="#" onclick="$event.close()" >Schliessen [X]</a>
        </div>
    </div>