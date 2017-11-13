<div class="profile_pw">
    <div class="wait hidden"><img border="0" src="public/global/img/wait.gif" /></div>
    
    <div class="display">
        <input class="btn" type="button" value="Ändern">
    </div>
    
    <div class="input hidden">
        <form onsubmit="return false;">
            <div class="form-group">
                <label for="oldPassword" class="col-sm-2 control-label">Altes Passwort:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control askedit" id="oldPassword" placeholder="Altes passwort" name="old_pw" />
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Neues Passwort:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control askedit" id="inputPassword3" placeholder="Passwort" name="pw1" />
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Neues Passwort wiederholen:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control askedit" id="inputPassword3" placeholder="Passwort wiederholen" name="pw2" />
                </div>
            </div>

            <input type="button" class="btn btn-success askeditbutton  ok_button" value="OK">
            <input type="button" class="btn btn-danger askeditbutton  cancel_button" value="Abbrechen">

            <input name="app" value="user_profile" type="hidden" />
            <input name="cmd" value="action_save_change_pw"  type="hidden"/>
        </form>
    </div>
</div>