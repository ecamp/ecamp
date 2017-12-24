<div class="profile_pw">
    <div class="wait hidden"><img border="0" src="public/global/img/wait.gif" /></div>
    
    <div class="display">
        <input type="button" value="Ändern">
    </div>
    
    <div class="input hidden">
        <form onsubmit="return false;">
            <table width="100%">
                <tr>
                    <td>Altes Passwort:</td>
                    <td><input name="old_pw" type="password" class="askedit " value="" style="width:100%;"></td>
                </tr>
                <tr>
                    <td>Neues Passwort:</td>
                    <td><input name="pw1" type="password" class="askedit " value="" style="width:100%;"></td>
                </tr>
                <tr>
                    <td>Neues Passwort:</td>
                    <td>
                        <input name="pw2" type="password" class="askedit " value="" style="width:100%;">
                        </td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                        <input type="button" class="askeditbutton  ok_button" value="OK" style="width:10%;">
                        <input type="button" class="askeditbutton  cancel_button" value="Abbrechen" style="width:20%;">
                    </td>
                </tr>
            </table>
            <input name="app" value="user_profile" type="hidden" />
            <input name="cmd" value="action_save_change_pw"  type="hidden"/>
        </form>
    </div>
</div>