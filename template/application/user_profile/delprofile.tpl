<span metal:define-macro="delprofile" tal:omit-tag="" >
	
	<center>
	
	<tal:block condition="not: profiledelable">
		<table width="80%" border="0">
			<tr>
				<td align="center">
					<img src="public/global/img/warning.png" height="200" />
				</td>
				<td align="center" colspan="2">
					<h1 style="font-size:30px; color:red">
						Das Profil kann nicht gelöscht werden?
					</h1>
					<h2 style="font-size:20px; color:red">
						Bevor du dein Profil löschen kannst, musst du alle deine Lager löschen 
						respektive die Mitarbeit künden!
					</h2>
					
					<h3>
						<a href="index.php?app=camp_admin" style="font-size:20px">Meine Lager</a>
					</h3>
				</td>
			</tr>
		</table>
		
	</tal:block>
	
	
	<tal:block condition="profiledelable">
		<table width="90%" border="0">
			<tr>
				<td align="center">
					<img src="public/global/img/warning.png" height="200" />
				</td>
				<td align="center" colspan="2">
					<h1 style="font-size:30px; color:red">
						Möchtest du dein Profil wirklich löschen?
					</h1>
					<h2 style="font-size:20px; color:red">
						Dein Login und alle deine Daten werden unwiderruflich gelöscht. <br />
						Um die Dienste von eCamp erneut nutzen zu können, <br />
						wirst du dich erneut registrieren müssen!
					</h2>
					
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="center">
					<button style="width:250px; height:100px; font-size:20px"
					onclick="window.history.back()">Nicht löschen</button>
				</td>
				<td align="center">
					<form action="index.php">
						<button style="width:250px; height:100px; font-size:20px">Löschen</button>
						<input type="hidden" name="app" value="user_profile" />
						<input type="hidden" name="cmd" value="action_del_profile" />
					</form>
				</td>
			
			</tr>
		</table>
	</tal:block>
	
	</center>
	
</span>