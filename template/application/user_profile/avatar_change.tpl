<div class="profile_avatar">
    <div class="wait hidden"><img border="0" src="public/global/img/wait.gif" /></div>
    
    <div class="display">
    	<input type="button" class=" btn change_avatar" value="Ändern" />
    	<form action="index.php">
        	<input type="submit" class=" btn delete_avatar" value="Löschen" />
        	<input name="app" value="user_profile" type="hidden" />
            <input name="cmd" value="action_delete_avatar"  type="hidden"/>
        </form>
    </div>
    
    <div class="input hidden">
        <form action="index.php" enctype="multipart/form-data" method="post">
            <input type="file" name="avatar" />
            <br />
            <input type="submit" class="btn btn-default askeditbutton  ok_button" value="OK" />
            <input type="button" class="btn btn-default askeditbutton  cancel_button" value="Abbrechen" />
            <input name="app" value="user_profile" type="hidden" />
            <input name="cmd" value="action_save_change_avatar"  type="hidden"/>
        </form>
    </div>
</div>