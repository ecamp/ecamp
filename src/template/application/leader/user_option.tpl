	<table width="400" height="150" bgcolor="#FFFFFF" style="position:absolute; bottom:10%; right:100px; border-width:2px; border-color:#000000; border-style:solid">
	    <tr valign="top">
        	<td align="center"><b>Optionen</b></td>
        </tr>
        
       	<tr>
        	<td align="center">
            	<form>
                	<input type="submit" value="Informationen von <!-- scoutname --> herunterladen (vCard)" />
            		<input type="hidden" name="app" value="leader" />
                    <input type="hidden" name="cmd" value="action_csv" />
                    <input type="hidden" name="id" value="<!-- id -->" />
                </form>
            </td>
        </tr>
        
        <tr>
        	<td align="center">
            	<form>
                	<input type="submit" value="Daten von <!-- scoutname --> editieren" />
            		<input type="hidden" name="app" value="leader" />
                    <input type="hidden" name="cmd" value="home" />
                    <input type="hidden" name="menu" value="edit_user" />
                    <input type="hidden" name="id" value="<!-- id -->" />
                </form>
            </td>
        </tr>
        
        <tr>
        	<td align="center">
            	<form>
                	<input type="submit" value="<!-- scoutname --> von diesem Lager entfernen" />
            		<input type="hidden" name="app" value="leader" />
                    <input type="hidden" name="cmd" value="action_del_user" />
                    <input type="hidden" name="id" value="<!-- id -->" />
                </form>
            </td>
            
        </tr>
        <tr>
        	<td align="center">
            	<form>
                	<input type="submit" value="Abbrechen" />
            		<input type="hidden" name="app" value="leader" />
                </form>
            </td>
            
        </tr>
    </table>