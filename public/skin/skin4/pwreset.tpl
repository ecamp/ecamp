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
		<div class="space-top"></div>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-8 col-md-offset-2">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="float-left">
								eCamp - Passwort
							</div>
							<div class="float-rigth">
								<a href="login.php">Zurück zum Login</a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-body">
							<div class="message alert alert-danger" tal:condition="SHOW_MSG" >
								<span tal:content="MSG">TEXT...</span>
							</div>
							<p>Du kannst dir nun ein neues Passwort setzten. Nicht wieder vergessen!</p>
							<div class="login">
								<form class="form-horizontal" action="pwreset_do.php" method="post">
									<div class="form-group">
										<label for="pw1" class="col-sm-2 control-label">Passwort:</label>
										<div class="col-sm-10">
											<input type="password" tabindex="1" class="form-control" id="pw1" placeholder="Passwort" name="pw1" />
										</div>
									</div>
									<div class="form-group">
										<label for="pw2" class="col-sm-2 control-label">Passwort wiederholen:</label>
										<div class="col-sm-10">
											<input type="password" tabindex="2" class="form-control" id="pw2" placeholder="Passwort wiederholen" name="pw2" />
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="space-top"></div>
									<div class="space-top"></div>
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<input type="submit" tabindex="3" class="form-control btn btn-success" id="submit" placeholder="Abschicken" name="submit"  value="Abschicken" />
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
		</div>
	</body>
</html>
