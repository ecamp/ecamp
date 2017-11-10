<!DOCTYPE html>
<html lang="de">
	<head>
		<title>eCamp v2</title>
		
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
        <link rel="stylesheet" type="text/css" href="./public/global/css/global.css" />

		<link rel="stylesheet" type="text/css" href="./public/skin/skin4/css/main.css" />
		<link rel="stylesheet" type="text/css" href="./public/skin/skin4/css/color.css" />
		<link rel="stylesheet" type="text/css" href="./public/skin/skin4/css/layout.css" />
		<link rel="stylesheet" type="text/css" href="./public/skin/skin4/css/bootstrap.min.css" />

		<script type="text/javascript" language="javascript" src="./public/global/js/mootools1.2.js"></script>
		<script type="text/javascript" language="javascript" src="./public/skin/skin4/js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" language="javascript" src="./public/skin/skin4/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="space-top"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="panel panel-default">
						<div class="panel-heading">eCamp - Reminder</div>
						<div class="panel-body">
							<div tal:condition="SHOW_MSG" class="alert alert-danger col-sm-offset-2">
								<p class="text-center" tal:content="structure MSG">TEXT...</p>
							</div>
							<div class="gotologin">
								<a href="login.php">Zurück zum Login</a>
							</div>
							<p>
								Wenn du dein Passwort vergessen hast, kannst du hier deine eMail - Adresse eintragen.
								Du erhälst eine Mail mit einem Link, um dir ein neues Passwort zu setzten.
							</p>
							<form class="form-horizontal" action="reminder_do.php" method="post">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
									<div class="col-sm-10">
										<input type="text" tabindex="1" class="form-control" id="Login" placeholder="Email" name="Login" />
									</div>
								</div>
								<div class="form-group">
									<label for="inputCaptcha" class="col-sm-2 control-label">Captcha</label>
									<div class="col-sm-10">
										<tal:block content="structure captcha" />
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-default" tabindex="3">Absenden</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
