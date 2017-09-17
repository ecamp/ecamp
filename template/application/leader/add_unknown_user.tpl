<form>
    <table width="600" height="300" bgcolor="#FFFFFF" style="position:absolute; bottom:10%; right:100px; border-width:2px; border-color:#000000; border-style:solid">
	    <tr valign="top">
        	<td align="center" colspan="4"><b>Person eintragen</b></td>
        </tr>
        
       	<tr>
        	<td>Pfadiname:</td>
            <td><input type="text" name="scoutname" value="<!-- scoutname -->"></td>
            <td>Funktion:</td>
            <td><!-- select_function --></td>
        </tr>
        <tr>
        	<td>Vorname:</td>
            <td><input type="text" name="firstname" value="<!-- firstname -->"></td>
            <td>Nachname:</td>
            <td><input type="text" name="surname" value="<!-- surname -->"></td>
        </tr>
        
        <!-- ########################## -->
        <tr><td height="1" bgcolor="#888888" colspan="4"></td></tr>
        <!-- ########################## -->
        
        <tr>
        	<td>Adresse:</td>
            <td><input type="text" name="street"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
        	<td>PLZ:</td>
            <td><input type="text" name="zipcode"></td>
            <td>Ort:</td>
            <td><input type="text" name="city"></td>
        </tr>
        
        <!-- ########################## -->
        <tr><td height="1" bgcolor="#888888" colspan="4"></td></tr>
        <!-- ########################## -->
        
        <tr>
        	<td>E-Mail:</td>
            <td><input type="text" name="mail" value="<!-- mail -->"></td>
            <td></td>
            <td></td>
        </tr>
		<tr>
        	<td>Mobil Nr.</td>
            <td><input type="text" name="mobilnr"></td>
            <td>Home Nr.</td>
            <td><input type="text" name="homenr"></td>
        </tr>
        
        <!-- ########################## -->
        <tr><td height="1" bgcolor="#888888" colspan="4"></td></tr>
        <!-- ########################## -->
        
        <tr>
        	<td>AHV:</td>
            <td><input type="text" name="ahv"></td>
            <td>Geburtstag:</td>
            <td><input type="text" name="birthday"></td>
        </tr>
        <tr>
        	<td>J&amp;S Ausbildung:</td>
            <td><!-- select_jsedu --></td>
            <td>PBS Ausbildung</td>
            <td><!-- select_pbsedu --></td>
        </tr>
        <tr>
        	<td>J&amp;S Personalnummer:</td>
            <td><input type="text" name="jspersnr"></td>
            <td>Geschlecht:</td>
            <td><!-- select_sex --></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td align="center"><input type="submit" value="Hinzuf&uuml;gen"></td>
        </tr>
        
    </table>
    
    <input type="hidden" name="app" value="leader" />
    <input type="hidden" name="cmd" value="action_save_unknown_user" />
</form>