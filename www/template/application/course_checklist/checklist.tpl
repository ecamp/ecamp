<span metal:define-macro="checklist" tal:omit-tag="">
     <span tal:repeat="level1 list">
     
         <div style="font-weight:bold; margin-bottom:4px;">${level1/short} ${level1/name}</div>
         
        <span tal:repeat="level2 level1/level2">
        
            <div style="margin-left:10px; margin-bottom:15px;">
            	<div style="display:table-cell; width:20px;">${level2/short} </div>
                <div style="display:table-cell;">${level2/name}</div>
                
 		        <ul tal:condition="not:level2/no_events" style="margin-left:-6px; margin-top:2px;">
                	<span tal:repeat="event level2/events">
                  		<li class="green" style="padding-bottom:2px;"> <a href="#" onclick="$event.edit(${event/id})" class="green">(${event/nr}) ${event/short_name} ${event/name} &nbsp;&nbsp;<span style="font-size:0.8em;">[${event/date}]</span></a></li>
                  	</span>
                </ul>
                
                <span tal:condition="level2/no_events" class="red" style="margin-left:20px;">[kein Block gefunden]</span>
                
            </div>
            
        </span>
        
        <hr tal:condition="not:repeat/level1/end" style="margin-top:10px; margin-bottom:10px;"/>
        
     </span>
</span>