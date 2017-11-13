<div metal:define-macro="delprofile" tal:omit-tag="" >
	<tal:block condition="not: profiledelable">
		<img src="public/global/img/warning.png" height="200" />
		<h1 class="alert alert-danger">
			Das Profil kann nicht gelöscht werden?
		</h1>
		<h2 class="alert alert-danger">
			Bevor du dein Profil löschen kannst, musst du alle deine Lager löschen
			respektive die Mitarbeit künden!
		</h2>
		<h3>
			<a href="index.php?app=camp_admin">Meine Lager</a>
		</h3>
	</tal:block>
	<tal:block condition="profiledelable">
		<img src="public/global/img/warning.png" height="200" />
		<h1 class="alert alert-danger">
			Möchtest du dein Profil wirklich löschen?
		</h1>
		<h2 class="alert alert-danger">
			Dein Login und alle deine Daten werden unwiderruflich gelöscht. <br />
			Um die Dienste von eCamp erneut nutzen zu können, <br />
			wirst du dich erneut registrieren müssen!
		</h2>
		<button class="btn btn-success float-left" onclick="window.history.back()"><h1>Nicht löschen</h1></button>
		<form action="index.php">
			<button class="btn btn-danger float-right"><h1>Löschen</h1></button>
			<input type="hidden" name="app" value="user_profile" />
			<input type="hidden" name="cmd" value="action_del_profile" />
		</form>
	</tal:block>
</div>