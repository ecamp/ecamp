<!-- Home -->
<span metal:define-macro="home" tal:omit-tag="" >
    <table width="100%" cellspacing="5px">
    	<tr>
        	<td style="border-right:1px black dotted;">
                Ausbildungskurse können hier ihre Leit- und Ausbildungsziele gemäss dem Ausbildungsmodell der PBS erfassen. Dies führt zu zwei Vereinfachungen:
                <ul>
                  <li>Im Detailprogramm können die Ausbildungsziele per Mausklick übernommen werden.<br />&nbsp;</li>
                  <li>Es kann automatisch eine Blockübersicht für die Kursanmeldung gedruckt werden.</li>
                </ul>
                
				<span tal:condition="overview" tal:omit-tag="">               
                    <a  href="?app=aim">
                      <span class="action-button-left" style="background:url(public/skin/skin2/img/button_1.gif);"></span>
                      <span class="action-button-text" style="background:url(public/skin/skin2/img/button_2.gif);">Ziele erfassen</span>
                      <span class="action-button-right" style="background:url(public/skin/skin2/img/button_3.gif);"></span>
                    </a>   
                    
                    <span class="action-button-left" style="margin-left:10px; background:url(public/skin/skin2/img/button_1_gray.gif);"></span>
                    <span class="action-button-text-gray" style="background:url(public/skin/skin2/img/button_2_gray.gif);">Zielübersicht</span>
                    <span class="action-button-right" style="background:url(public/skin/skin2/img/button_3_gray.gif);"></span>
                </span>
                
				<span tal:condition="not:overview" tal:omit-tag="">
                  <span class="action-button-left" style="background:url(public/skin/skin2/img/button_1_gray.gif);"></span>
                  <span class="action-button-text-gray" style="background:url(public/skin/skin2/img/button_2_gray.gif);">Ziele erfassen</span>
                  <span class="action-button-right" style="background:url(public/skin/skin2/img/button_3_gray.gif);"></span>
                  
                  <a href="?app=aim&overview=1">
                      <span class="action-button-left" style="margin-left:10px; background:url(public/skin/skin2/img/button_1.gif);"></span>
                      <span class="action-button-text" style="background:url(public/skin/skin2/img/button_2.gif);">Zielübersicht</span>
                      <span class="action-button-right" style="background:url(public/skin/skin2/img/button_3.gif);"></span>
                  </a>
                </span>
                
            </td>
            <td style="border-right:1px black dotted;">
            	<b>Ziele von PBS importieren</b><br />
                Um die Schreibarbeit zu minimieren, können die vorgeschlagenenen Ziele der PBS (aus "Ausbildungsmodell der Pfadibewegung Schweiz") importiert werden.<br /> <br />
                Bitte wähle einen Kurstyp:<br />	<br />
                <form action="index.php" onsubmit="if(this.type.get('value') == '') alert('Bitte einen Kurstyp wählen.'); else return confirm('Du bist dabei, die vordefinierten Ziele des gewählten Kurstyps in deinen Kurs zu kopieren. Weiterfahren?');">
                    <select name="type" id="type">
                        <option></option>
                        <option value="1">Basiskurs Wolfsstufe</option>
                        <option value="2">Basiskurs Pfadistufe</option>
                        <option value="3">Aufbaukurs Wolfsstufe</option>
                        <option value="4">Aufbaukurs Pfadistufe</option>
                    </select>
                    <input type="submit" value="Jetzt importieren" />
                    <input type="hidden" name="app" value="aim" />
                    <input type="hidden" name="cmd" value="action_import" />
                    <br />&nbsp;
                </form>
            </td>
            <td>
                <b>Blockübersicht</b><br />
                Wenn die Ziele mit den Programmblöcken verknüpft sind, kann automatisch eine Blockübersicht ausgedruckt werden.<br />
                Diese Übersicht ist kompatibel mit den Anforderungen von J+S/PBS und kann zur Kursanmeldung verwendet werden.
                <br /><br />
                <center>
                    <a href="?app=aim&cmd=action_generate_xls"><img src="public/global/img/icon_xls.png" /></a>
                 </center>
            </td>
        </tr>
     </table>
</span>


<!-- Leitziele -->
<span metal:define-macro="level1" tal:omit-tag="" >
   <div style="margin-bottom:30px;"  tal:condition="php: user_camp.auth_level >= 40">  
      <input id="add_new_aim1" type="button" value="Neues Leitziel" onclick="javascript:new_aim1();" style="float:left;"/>
      
      <form action="index.php" style="width:130px; float:right;">
        <input type="button" value="Alle Ziele löschen" onclick="javascript:if(confirm('Willst du wirklich alle Leit- und Ausbildungsziele löschen?')){this.form.submit();};"/>
        <input type="hidden" name="app" value="aim"  />
        <input type="hidden" name="cmd" value="action_del_all" />
      </form>  
  </div>
    
  <div id="list_aim1">    
  
    <span tal:repeat="aim1 aim_level1" tal:omit-tag=""> 
    
        <div class="aim1 aim1_default" id="aim1_${aim1/id}" onclick="javascript:select_aim1(${aim1/id});" ondblclick="javascript:edit_aim1(${aim1/id});">
          <img src="public/global/img/del.png" onclick="delete_aim1(${aim1/id});" class="del" tal:condition="php: user_camp.auth_level >= 40"/>
          <img src="public/global/img/edit.png" onclick="edit_aim1(${aim1/id});" class="edit" tal:condition="php: user_camp.auth_level >= 40"/>
          &nbsp;
          <span id="aim1_${aim1/id}_value">${aim1/text}</span>
        </div>
        
    </span>
    
  </div>
</span>


<!-- Ausbildungsziele -->
<span metal:define-macro="level2" tal:omit-tag="" >
	<div id="aim1_default" class="aim1_box">
      <i>[Klicke auf ein Leitziel, um die dazugehörigen Ausbildungsziele anzuzeigen.]</i>
    </div>
    
    <div id="list_aim2_full">
    
    <!-- eine Box pro Leitziel -->
	<span tal:repeat="aim1 aim_level1" tal:omit-tag="">
      <div id="aim1_box_${aim1/id}"  class="aim1_box hidden" >
      
        <input type="button" value="Neues Ausbildungsziel" style="margin-bottom:15px" onclick="javascript:new_aim2();"  tal:condition="php: user_camp.auth_level >= 40" />
        
        <div tal:condition="aim1/hasNoChildren" id="aim1_hasnochild_${aim1/id}"><i>[keine Ausbildungsziele zu diesem Leitziel]</i></div>

        <!-- Ausbildungsziele auflisten -->
        <span tal:repeat="aim2 aim1/aim_level2" tal:omit-tag="">
            <div class="aim2 aim2_default" id="aim2_${aim2/id}" onclick="javascript:select_aim2(${aim2/id});" ondblclick="javascript:edit_aim2(${aim2/id});">
                <img src="public/global/img/del.png" onclick="delete_aim2(${aim2/id});" class="del" tal:condition="php: user_camp.auth_level >= 40"/>
                <img src="public/global/img/edit.png" onclick="edit_aim2(${aim2/id});" class="edit" tal:condition="php: user_camp.auth_level >= 40"/>
                &nbsp;
                <span id="aim2_${aim2/id}_value">${aim2/text}</span>
            </div>
        </span>
       
        
      </div>
    </span>    
    
    </div>
</span>

<!-- Zielübersicht -->
<span metal:define-macro="overview" tal:omit-tag="" >
	<span tal:repeat="aim1 aim_level1">
     
        <div style="font-weight:bold; margin-bottom:4px;">${aim1/text}</div>
       		  
        <span tal:repeat="aim2 aim1/aim_level2">
        
            <div style="margin-left:10px; margin-bottom:15px;">
        
                <div>${aim2/text}</div>
                
 		        <ul tal:condition="not:aim2/hasNoChildren" style="margin-left:-6px; margin-top:2px;">
                	<span tal:repeat="event aim2/event">
                  		<li class="green" style="padding-bottom:2px;"> <a href="#" onclick="$event.edit(${event/id})" class="green">${event/nr} ${event/short_name} ${event/name} &nbsp;&nbsp;<span style="font-size:0.8em;">[${event/date}]</span></a></li>
                  	</span>
                </ul>
                
                <span tal:condition="aim2/hasNoChildren" class="red" style="margin-left:20px;">[kein Block gefunden]</span>
                
            </div>
            
        </span>
        
        <hr tal:condition="not:repeat/aim1/end" style="margin-top:10px; margin-bottom:10px;"/>
        
     </span>
</span>

<!-- mit Ausbildungszielen verknüpfte Programmblöcke -->
<span metal:define-macro="events" id="event_box" >

	<div id="aim2_default" class="aim2_box">
      <i>[Klicke auf ein Ausbildungsziel, um die damit verknüpften Programmblöcke anzuzeigen.] </i>
    </div>
    
    <span tal:repeat="aim1 aim_level1" tal:omit-tag="">
      <span tal:repeat="aim2 aim1/aim_level2" tal:omit-tag="">
        <div id="aim2_box_${aim2/id}" class="aim2_box hidden">
        
            <div tal:condition="aim2/hasNoChildren"><i>[keine verknüpften Programmblöcke]</i></div>
            
            <ul>
            <div tal:repeat="event aim2/event" class="event">
               <li><a href="#" onclick="$event.edit(${event/id});">${event/text}</a></li>
            </div>
            </ul>
        
        </div>
      </span>
    </span> 
</span>