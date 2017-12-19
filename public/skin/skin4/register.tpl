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
		<script type="text/javascript" src="./public/global/js/mootools1.2.js"></script>
		<script type="text/javascript">
			jQuery.noConflict();
		</script>
		
		<script type="text/javascript" tal:condition="SHOW_MSG" >
			var error = "<tal:block content='MSG' />";
			alert( error );
			window.history.back();
		</script>
	</head>
	<body>
		<div class="space-top"></div>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-8 col-md-offset-2">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="float-left">
								eCamp - Register
							</div>
							<div class="gotologin">
								<a href="login.php" class="float-rigth">Zurück zum Login</a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-body">
							<div class="message" tal:condition="SHOW_MSG" >
								<span tal:content="MSG">TEXT...</span>
							</div>
							<div class="login">
								<form class="form-horizontal" action="register_do.php" method="post">
									<div class="form-group">
										<label for="inputEmail" class="col-sm-2 control-label">E-Mail:</label>
										<div class="col-sm-10">
											<input type="text" tabindex="1" class="form-control" id="Login" placeholder="Email" name="Login" />
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="space-top"></div>
									<div class="space-top"></div>
									<div class="form-group">
										<label for="Passwort1" class="col-sm-2 control-label">Passwort:</label>
										<div class="col-sm-10">
											<input type="password" tabindex="2" class="form-control" id="Passwort1" placeholder="Passwort" name="Passwort1" />
										</div>
									</div>
									<div class="form-group">
										<label for="Passwort2" class="col-sm-2 control-label">Wiederholen:</label>
										<div class="col-sm-10">
											<input type="password" tabindex="3" class="form-control" id="Passwort2" placeholder="Passwort wiederholen" name="Passwort2" />
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="space-top"></div>
									<div class="space-top"></div>
									<div class="form-group">
										<label for="scoutname" class="col-sm-2 control-label">Pfadiname:</label>
										<div class="col-sm-10">
											<input type="text" tabindex="4" class="form-control" id="scoutname" placeholder="Pfadiname" name="scoutname" />
										</div>
									</div>
									<div class="form-group">
										<label for="firstname" class="col-sm-2 control-label">Vorname:</label>
										<div class="col-sm-10">
											<input type="text" tabindex="5" class="form-control" id="firstname" placeholder="Vorname" name="firstname" />
										</div>
									</div>
									<div class="form-group">
										<label for="surname" class="col-sm-2 control-label">Nachname:</label>
										<div class="col-sm-10">
											<input type="text" tabindex="6" class="form-control" id="surname" placeholder="Nachname" name="surname" />
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="space-top"></div>
									<div class="space-top"></div>
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<tal:block content="structure captcha" />
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="space-top"></div>
									<div class="space-top"></div>
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<input type="submit" tabindex="7" class="form-control btn btn-success" id="submit" placeholder="Register" name="submit" value="Register" />
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
