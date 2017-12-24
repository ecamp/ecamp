<form>
    <table width="400" height="180" bgcolor="#FFFFFF" style="position:absolute; bottom:10%; right:100px; border-width:2px; border-color:#000000; border-style:solid">
	    <tr valign="top">
        	<td align="center" colspan="3"><b>Personensuche</b></td>
        </tr>
        
       	<tr>
        	<td> </td>
            <td>Pfadiname:</td>
            <td> <input type="text" name="scoutname" style="width:90%" /></td>
        </tr>
        <tr>
        	<td> </td>
        	<td>Vorname:</td>
            <td> <input type="text" name="firstname" style="width:90%" /></td>
        </tr>
        <tr>
        	<td> </td>
        	<td>Nachname:</td>
            <td> <input type="text" name="surname" style="width:90%" /></td>
        </tr>
        <tr>
        	<td> </td>
        	<td>E-Mail:</td>
            <td> <input type="text" name="mail" style="width:90%" /></td>
        </tr>
        
        <tr>
        	<td colspan="3" align="right">
            	<input type="submit" value="Suchen" />
            </td>
        </tr>
    </table>
    
    <input type="hidden" name="app" value="leader" />
    <input type="hidden" name="cmd" value="home" />
    <input type="hidden" name="menu" value="add_search_result" />
    <input type="hidden" name="std" value="<!-- std -->" />
</form>