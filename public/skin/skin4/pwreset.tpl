<!DOCTYPE html>
<html lang="de">
	<head>
		<title>eCamp v2</title>

		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

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
						<div class="panel-heading">eCamp - Passwort</div>
						<div class="panel-body">
							<div tal:condition="SHOW_MSG" class="alert alert-danger col-sm-offset-2">
								<p class="text-center" tal:content="structure MSG">TEXT...</p>
							</div>
							<div class="gotologin">
								<a href="login.php">Zurück zum Login</a>
							</div>
							<p>Du kannst dir nun ein neues Passwort setzten. Nicht wieder vergessen!</p>
							<form class="form-horizontal" action="pwreset_do.php" method="post">
								<div class="form-group">
									<label for="inputPassword1" class="col-sm-2 control-label">Passwort</label>
									<div class="col-sm-10">
										<input type="password" tabindex="2" class="form-control" id="inputPassword1" placeholder="Passwort" name="pw1" />
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword2" class="col-sm-2 control-label">Passwort wiederholen</label>
									<div class="col-sm-10">
										<input type="password" tabindex="2" class="form-control" id="inputPassword2" placeholder="Passwort wiederholen" name="pw2" />
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-default" tabindex="3">Abschicken</button>
									</div>
								</div>

								<input type="hidden" name="user_id" tal:attributes="value user_id" />
								<input type="hidden" name="login" tal:attributes="value login" />
								<input type="hidden" name="acode" tal:attributes="value acode" />
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
