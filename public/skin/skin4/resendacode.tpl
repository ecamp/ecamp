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
		<script type="text/javascript" language="javascript" src="./public/skin/skin4/js/login.js"></script>
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
						<div class="panel-heading">eCamp - Mail erhalten</div>
						<div class="panel-body">
							<div tal:condition="SHOW_MSG" class="alert alert-danger col-sm-offset-2">
								<p class="text-center" tal:content="structure MSG">TEXT...</p>
							</div>
							<div class="gotologin">
								<a href="login.php">Zurück zum Login</a>
							</div>

							<p>
								Mit der Aktivierung stellen wir sicher, dass du die korrekte eMail - Adresse angegeben hast.
								Um dies sicher zu stellen, senden wir per Mail einen Link, welchen du aufrufen musst.
								Wird dieser Link aufgerufen, dann wird auch dein Account aktiviert.
								<br/>
								<br/>
								Wenn du diese Mail nicht erhalten hast, kannst du sie dir noch einmal zuschicken lassen.
								Bitte überprüfe auch, ob die Mail im SPAM Ordner gelandet ist.
							</p>
							<br/>
							<br/>
							<form class="form-horizontal" action="resendacode_do.php" method="post">
								<div class="form-group">
									<label for="inputEmail" class="col-sm-2 control-label">E-Mail:</label>
									<div class="col-sm-10">
										<input type="text" tabindex="1" class="form-control" id="Login" placeholder="Email" name="Login" />
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-default" tabindex="3">Senden</button>
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
