<script type="text/javascript">
	function new_event()
	{
		var error=0;
		var error_msg = "Folgende Fehler sind aufgetreten:\n\n";
		
		if( $('menu_add_event').event_name.value == "" )
		{
			error = 1;
			error_msg = error_msg + "- Gib einen Blocknamen ein.\n\n";
		}
		
		if( $('menu_add_event').event_start_hour.value== "" )
		{
			error = 1;
			error_msg = error_msg + "- Gib eine Startzeit ein.\n\n";
		}
		
		if( error == 1 )
		{
			alert( error_msg );
		}
		else
		{
			document.location.href = "index.php?" + Form.serialize('menu_add_event');		
		}
	}
	
	function cancel_new_event()
	{
		Element.addClassName('menu_add_event','hidden');
		
		$('menu_add_event').event_name.value = "";
		$('menu_add_event').event_start_hour.value = "";
		$('menu_add_event').event_start_min.value = "";
		$('menu_add_event').event_length_hour.value = "";
		$('menu_add_event').event_length_min.value = "";
		
		$('menu_add_event').event_category.selectedIndex = "";
		$('menu_add_event').event_responsible.value = "";
	}
</script>

<form class="hidden" id="menu_add_event" onsubmit="this.ok.click(); return false;">
    <table width="400" height="130" bgcolor="#FFFFFF" style="position:absolute; top:20%; left:40%; border-width:2px; border-color:#000000; border-style:solid; z-index:1002">
	    <tr valign="top">
        	<td align="center" colspan="4"><b>Neuer Block</b></td>
        </tr>
        
       	<tr>
        	<td>&nbsp;</td>
        	<td>Blockname: </td>
            <td><input type="text" name="event_name" style="width:100%"></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        	<td>Kategorie: </td>
            <td>
            	<select name="event_category" style="width:100%">
                	<!-- event_category -->
                </select>
            </td>
            <td>&nbsp;</td>
        </tr>
		<tr>
        	<td>&nbsp;</td>
            <td>Blockstart (Uhrzeit):</td>
            <td>
            	<input type="text" name="event_start_hour" style="width:30px" maxlength="2" />:
                <input type="text" name="event_start_min" style="width:30px" maxlength="2" />            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
            <td>Blockl&auml;nge:</td>
            <td>
            	<input type="text" name="event_length_hour" style="width:30px" maxlength="2" />h&nbsp;
                <input type="text" name="event_length_min" style="width:30px" maxlength="2" />min            
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
            <td>Verantwortlicher:</td>
            <td><input type="text" name="event_responsible" style="width:100%" /></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
        	<td></td>
            <td></td>
        	<td align="right">
                <input type="button" value="Anlegen" id="ok" onclick="javascript:new_event();" />&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" value="Abbrechen" onclick="javascript:unlock_screen(); cancel_new_event();" /></td>
          <td>&nbsp;</td>
        </tr>    
    </table>
    
    <input type="hidden" name="app" value="day" />
    <input type="hidden" name="cmd" value="action_add_event" />
    <input type="hidden" name="day_id" id="day_id" value="<!-- day_id -->"/>
</form>