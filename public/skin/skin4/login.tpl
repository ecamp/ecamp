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
		<script type="text/javascript">
			jQuery.noConflict();
		</script>

		<script type="text/javascript" src="./public/global/js/mootools1.2.js"></script>
		<script type="text/javascript" src="./public/skin/skin4/js/login.js"></script>
	</head>
	<body>
		<div class="space-top"></div>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-8 col-md-offset-2">
					<div class="panel panel-default">
						<div class="panel-heading">Willkommen beim neuen eCamp</div>
						<div class="panel-body">
							<div class="message alert alert-danger" tal:condition="SHOW_MSG" >
								<span tal:content="structure MSG">TEXT...</span>
							</div>
							<div class="login form-group">
								<h1>eCamp - Login</h1>
								<form class="form-horizontal" action="login.php" method="post">
									<div class="form-group">
										<label for="Login" class="col-sm-2 control-label">E-Mail:</label>
										<div class="col-sm-10">
											<input type="text" tabindex="1" class="form-control" id="Login" placeholder="Email" name="Login" />
										</div>
									</div>
									<div class="form-group">
										<label for="inputPassword" class="col-sm-2 control-label">Passwort:</label>
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
								<div class="form-group">
									<div class="col-sm-offset-2">
										Du hast noch kein Login? <a href="register.php"><b>Registrieren</b></a>
										<br />
										<br />
										<a href="reminder.php" ><b>Passwort vergessen?</b></a>
									</div>
								</div>
							</div>
							<div class="space-top"></div>
							<hr />
							<div class="space-top"></div>
							<div class="browser">
								<table>
									<colgroup>
										<col width="10%" />
										<col width="40%" />
										<col width="10%" />
										<col width="40%" />
									</colgroup>
									<tr id="js_off">
										<td>
											<img src="public/global/img/js.png" height="32px" />
										</td>
										<td colspan="3" style="color: red; font-weight:bold">
											Java Script ist ausgeschaltet. <br />
											Diese Seite macht gebrauch von Java Script.<br />
											Bitte einschalten und Seite neu laden.
										</td>
									</tr>
									<tr class="hidden" id="unknown_browser">
										<td>
											<img src="public/global/img/js.png" height="32px" />
										</td>
										<td style="color: green; font-weight:bold">
											Java Script muss eingeschaltet sein. Bitte so belassen!
										</td>
										<td>
											<img src="public/global/img/question.png" height="32" border="0" />
										</td>
										<td colspan="3" style="color: red; font-weight:bold">
											Unbekannter Browser.<br />
											Bitte unterstützten Browser verwenden.
										</td>
									</tr>
									<tr class="hidden" id="sa_browser">
										<td>
											<img src="public/global/img/js.png" height="32px" />
										</td>
										<td style="color: green; font-weight:bold">
											Java Script muss eingeschaltet sein. Bitte so belassen!
										</td>
										<td>
											<img src="public/global/img/sa.jpg" height="32" border="0" />
										</td>
										<td style="color: green; font-weight:bold;">
											Browser unterstützt.
											<br />
											Browser empfohlen.
										</td>
									</tr>
									<tr class="hidden" id="ff_browser">
										<td>
											<img src="public/global/img/js.png" height="32px" />
										</td>
										<td style="color: green; font-weight:bold">
											Java Script muss eingeschaltet sein. Bitte so belassen!
										</td>
										<td>
											<img id="ff" src="public/global/img/ff.jpg" height="32" border="0" />
										</td>
										<td style="color: green; font-weight:bold">
											Browser unterstützt.
											<br />
											Browser empfohlen.
										</td>
									</tr>
									<tr class="hidden" id="ie_browser">
										<td>
											<img src="public/global/img/js.png" height="32px" />
										</td>
										<td style="color: green; font-weight:bold">
											Java Script muss eingeschaltet sein. Bitte so belassen!
										</td>
										<td>
											<img id="ie" src="public/global/img/ie.jpg" height="32" border="0" />
										</td>
										<td>
											<div style="color: green; font-weight:bold">Browser unterstützt.</div>
											<div style="color: red;">Browser nicht empfohlen.</div>
										</td>
									</tr>
								</table>
							</div>
							<hr />
							<div class="hidden browser" id="recomanded_browser">
								<table width="100%" border="0" class="support">
									<colgroup>
										<col width="10%" />
										<col width="40%" />
										<col width="10%" />
										<col width="40%" />
									</colgroup>
									<tr>
										<td colspan="4" align="center" style="padding-bottom:10px;">
											<b>Empfohlene Browser:</b>
										</td>
									</tr>
									<tr>
										<td>
											<img src="public/global/img/sa.jpg" height="32px" />
										</td>
										<td>
											Safari für Windows und Mac OS X
											<a href="http://www.apple.com/de/safari/download/">
												Herunterladen
											</a>
										</td>
										<td>
											<img src="public/global/img/ff.jpg" height="32px" />
										</td>
										<td>
											Firefox für Windows und Mac OS X
											<a href="http://www.getfirefox.de/">
												Herunterladen
											</a>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
