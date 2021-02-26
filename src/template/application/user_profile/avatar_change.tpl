<div class="profile_avatar">
    <div class="wait hidden"><img border="0" src="public/global/img/wait.gif" /></div>
    
    <div class="display">
    	<input type="button" class="change_avatar" value="&Auml;ndern" />
    	<form action="index.php" style="display:inline">
        	<input type="submit" class="delete_avatar" value="L&ouml;schen" />
        	<input name="app" value="user_profile" type="hidden" />
            <input name="cmd" value="action_delete_avatar"  type="hidden"/>
        </form>
    </div>
    
    <div class="input hidden">
        <form action="index.php" enctype="multipart/form-data" method="post">
            <input type="file" name="avatar" />
            <br />
            <input type="submit" class="askeditbutton  ok_button" 		value="OK" />
            <input type="button" class="askeditbutton  cancel_button"	value="Abbrechen" />
            <input name="app" value="user_profile" type="hidden" />
            <input name="cmd" value="action_save_change_avatar"  type="hidden"/>
        </form>
    </div>
</div>