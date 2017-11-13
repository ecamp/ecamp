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
	
		<script type="text/javascript" language="javascript" src="./public/global/js/mootools-core-1.4.js"></script>
		<script type="text/javascript" language="javascript" src="./public/skin/skin4/js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" language="javascript" src="./public/skin/skin4/js/bootstrap.min.js"></script>
		<script type="text/javascript" language="javascript">
			jQuery.noConflict();
		</script>
	</head>
	<body>
		<div class="space-top"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="panel panel-default">
						<div class="panel-heading">Willkommen beim neuen eCamp</div>
						<div class="panel-body">
							<div tal:condition="SHOW_MSG" class="alert alert-danger col-sm-offset-2">
								<p class="text-center" tal:content="structure MSG">TEXT...</p>
							</div>
							<form class="form-horizontal" action="login.php" method="post">
								<div class="form-group">
									<label for="Login" class="col-sm-2 control-label">Email</label>
									<div class="col-sm-10">
										<input type="text" tabindex="1" class="form-control" id="Login" placeholder="Email" name="Login" />
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
									<div class="col-sm-10">
										<input type="password" tabindex="2" class="form-control" id="inputPassword3" placeholder="Password" name="Passwort" />
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="autologin" id="autologin" /> Beim nächsten Besuch von eCamp automatisch an mich erinnern.
											</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-default" tabindex="3">Login</button>
									</div>
								</div>
								<input name="Form" value="Login" type="hidden" />
							</form>
							<div class="col-md-offset-2">
								Du hast noch kein Login? <a href="register.php"><b>Registrieren</b></a>
								<br />
								<br />
								<a href="reminder.php" ><b>Passwort vergessen?</b></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
