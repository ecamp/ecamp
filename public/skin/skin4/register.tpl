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
		
		<script type="text/javascript" language="javascript"  tal:condition="SHOW_MSG" >
			var error = "<tal:block content='MSG' />";
			alert( error );
			window.history.back();
		</script>
	</head>
	<body>
		<div class="space-top"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="panel panel-default">
					<div class="panel-heading">eCamp - Register</div>
						<div class="panel-body">
                            <div tal:condition="SHOW_MSG" class="alert alert-danger col-sm-offset-2">
                                <p class="text-center" tal:content="structure MSG">TEXT...</p>
                            </div>
                            <div class="gotologin">
                                <a href="login.php">Zurück zum Login</a>
                            </div>
                            <form class="form-horizontal" action="register_do.php" method="post">
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">E-Mail:</label>
                                    <div class="col-sm-10">
                                        <input type="text" tabindex="1" class="form-control" id="Login" placeholder="Email" name="Login" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword1" class="col-sm-2 control-label">Passwort</label>
                                    <div class="col-sm-10">
                                        <input type="password" tabindex="2" class="form-control" id="inputPassword1" placeholder="Passwort" name="Passwort1" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword2" class="col-sm-2 control-label">Passwort wiederholen</label>
                                    <div class="col-sm-10">
                                        <input type="password" tabindex="2" class="form-control" id="inputPassword2" placeholder="Passwort wiederholen" name="Passwort2" />
                                    </div>
                                </div>
                                <div class="space-top"></div>
                                <div class="form-group">
                                    <label for="inputPfadiname" class="col-sm-2 control-label">Pfadiname</label>
                                    <div class="col-sm-10">
                                        <input type="text" tabindex="2" class="form-control" id="inputPfadiname" placeholder="Pfadiname" name="scoutname" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputVorname" class="col-sm-2 control-label">Vorname</label>
                                    <div class="col-sm-10">
                                        <input type="text" tabindex="2" class="form-control" id="inputVorname" placeholder="Vorname" name="firstname" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputNachname" class="col-sm-2 control-label">Nachname</label>
                                    <div class="col-sm-10">
                                        <input type="text" tabindex="2" class="form-control" id="inputNachname" placeholder="Nachname" name="surname" />
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
                                        <button type="submit" class="btn btn-default" tabindex="3">Registrieren</button>
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
