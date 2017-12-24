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
	</head>
	<body>
		<div class="space-top"></div>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-8 col-md-offset-2">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="float-left">
								eCamp - Mail erhalten
							</div>
							<div class="float-rigth">
								<a href="login.php">Zurück zum Login</a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-body">
							<div class="login">
								<p>
									Mit der Aktivierung stellen wir sicher, dass du die korrekte eMail - Adresse angegeben hast.
									Um dies sicher zu stellen, senden wir per Mail einen Link, welchen du aufrufen musst.
									Wird dieser Link aufgerufen, dann wird auch dein Account aktiviert.
									<br />
									<br />
									Wenn du diese Mail nicht erhalten hast, kannst du sie dir noch einmal zuschicken lassen.
									Bitte überprüfe auch, ob die Mail im SPAM Ordner gelandet ist.
								</p>
								<br />
								<form class="form-horizontal" action="resendacode_do.php" method="post">
									<div class="form-group">
										<label for="Login" class="col-sm-2 control-label">E-Mail:</label>
										<div class="col-sm-10">
											<input type="email" tabindex="1" class="form-control" id="Login" placeholder="Email" name="Login" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<input type="submit" tabindex="2" class="form-control btn btn-success" id="Senden" placeholder="Senden" name="senden" value="Senden" />
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
