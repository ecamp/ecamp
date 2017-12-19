<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>eCamp v2</title>

		<link rel="stylesheet" type="text/css" href="./public/global/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="./public/global/css/global.css" />
        
        <link rel="stylesheet" type="text/css" href="./public/skin/skin4/css/main.css" />
        <link rel="stylesheet" type="text/css" href="./public/skin/skin4/css/color.css" />
        <link rel="stylesheet" type="text/css" href="./public/skin/skin4/css/layout.css" />

		<script type="text/javascript" src="./public/global/js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="./public/global/js/bootstrap.min.js"></script>
		<script type="text/javascript" language="javascript" src="./public/global/js/mootools1.2.js"></script>
		<script type="text/javascript">
			jQuery.noConflict();
		</script>
	</head>
	<body>
		<div class="message alert alert-danger" tal:condition="SHOW_MSG" >
			<span tal:content="MSG">TEXT...</span>
		</div>
		<div class="login bgcolor_content content_border_fit">
			<div class="gotologin">
				<a href="login.php">Zurück zum Login</a>
			</div>
			<form action="pwreset_do.php" method="post">
				<table width="80%">
					<tr><td colspan="2"><font class="title">eCamp - Passwort</font></td></tr>
					<tr height="10"><td> </td></tr>
					<tr>
						<td colspan="2">
							Du kannst dir nun ein neues Passwort setzten. Nicht wieder vergessen!
						</td>
					</tr>
					<tr height="10"><td> </td></tr>
					<tr><td>Passwort:</td><td><input tabindex="1" name="pw1" type="password" /></td></tr>
					<tr><td>Wiederholen:</td><td><input tabindex="1" name="pw2" type="password" /></td></tr>
					<tr height="10"><td> </td></tr>
					<tr><td colspan="2" align="right"><input tabindex="7" type="submit" value="Abschicken" /></td></tr>
					<tr><td> </td></tr>
				</table>
				<input type="hidden" name="user_id" tal:attributes="value user_id" />
				<input type="hidden" name="login" tal:attributes="value login" />
				<input type="hidden" name="acode" tal:attributes="value acode" />
			</form>
		</div>
	</body>
</html>
