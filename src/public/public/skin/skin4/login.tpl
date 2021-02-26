<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>eCamp v2</title>
		
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
        <link rel="stylesheet" type="text/css" href="./public/global/css/global.css" />       
        
        <link rel="stylesheet" type="text/css" href="./public/skin/skin3/css/main.css" />
        <link rel="stylesheet" type="text/css" href="./public/skin/skin3/css/color.css" />
        <link rel="stylesheet" type="text/css" href="./public/skin/skin3/css/layout.css" />
        
		<style>
			
			table
			{ 	font-size:13px;	}	
			font.title
			{	font-size: 25px;	}
			div.menu
			{	width: 180px;
				background-color: #2288ff;
				border-width: 1px;
				border-color: #000000;
				border-style: solid;	
				position: relative;
				top: 30px;
				text-align: left;
			}
			a.menu
			{	color: #000000;	
				text-decoration: none;	}
			table.Login
			{
				border-width: 1px;
				border-color: #000000;
				border-style: solid;	
			}
			
			body{ text-align:center; } 
			
			
			.message, .register, .login, .browser
			{
				width:380px;
				padding: 10px;
				margin-bottom:20px;
			}
			
			table.support td
			{
				vertical-align: middle;
			}
			
			/*
			.browser
			{
				width:280px;
				padding:10px;
				margin-bottom:20px;
				background-color:white;
			}
			*/
			
			.hidden
			{
				display: none;
			}
			
			input[type=text], input[type=password]
			{
				width: 100%;
			}
		</style>
	
		<script type="text/javascript" language="javascript" src="./public/global/js/mootools1.2.js"></script>
		<script type="text/javascript" language="javascript" src="./public/skin/skin3/js/login.js"></script>
	</head>
	
	
	<body marginheight="100" marginwidth="0" class="bgcolor ">
	<center>	
        <div class="message bgcolor_content content_border_fit" tal:condition="SHOW_MSG" >
          <span tal:content="structure MSG">TEXT...</span>
        </div>
        
        <div class="register bgcolor_content content_border_fit">
        	<b>Willkommen beim neuen eCamp</b>
        	<br />
        	<br />
        	Es konnten keine Registrationen des alten eCamps übernommen werden.
        	Es müssen sich also alle Benutzer neu registrieren.
        	<br />
        	<br />
        	Wer noch ein Lager im alten eCamp laufen hat, kann sich weiterhin unter folgender Adresse anmelden:
        	<br />
        	<br />
        	<a href="http://oldecamp.pfadiluzern.ch">http://oldecamp.pfadiluzern.ch</a>
        </div>
        
        <div class="login bgcolor_content content_border_fit">
        	<form action="login.php" method="post">
                <table width="80%">
                    <tr><td colspan="2"><font class="title">eCamp - Login</font></td></tr>
                    <tr height="10"><td> </td></tr>
                    <tr><td>E-Mail:</td><td><input tabindex="1" name="Login" type="text" id="Login" /></td></tr>
                    <tr><td>Passwort:</td><td><input tabindex="2" name="Passwort" type="password" /></td></tr>
					
					<tr>
						<td align="right"><input type="checkbox" name="autologin" id="autologin" /></td>
						<td><label for="autologin">Beim nächsten Besuch von eCamp automatisch an mich erinnern.</label></td>
					</tr>
					
                    <tr><td colspan="2" align="right"><input tabindex="3" type="submit" value="Login" /></td></tr>
                    <tr><td> </td></tr>
                </table>
                <input name="Form" value="Login" type="hidden" />
            </form>
        </div>
        
        <div class="register bgcolor_content content_border_fit">
        	Du hast noch kein Login? <a href="register.php" ><b>Registrieren</b></a><br /><br />
            <a href="reminder.php" ><b>Passwort vergessen?</b></a>
        </div>
        
        
        <div class="browser content_border_fit">
        	<table width="100%" border="0" class="support">
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
        
        <div class="hidden browser content_border_fit" id="recomanded_browser">
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
        
        
        <!--
        <div id="js_false" class="browser content_border_fit" style="background-color:#ff0000">
        	<b>
        		Diese Seite macht gebrauch von JavaScript. <br />
        		Bitte schalte JavaScript für diese Seite ein!
        	</b>
        </div>
        <div id="js_true" class="browser content_border_fit hidden" style="background-color:#00ff00">
        	<b>
        		Diese Seite macht gebrauch von JavaScript. <br />
        		Bitte schalte JavaScript nicht aus!
        	</b>
        </div>
        
        <div class="browser content_border_fit">
			<b>Unterst&uuml;tzte Browser:</b><br /><br />
            	<a href="http://www.apple.com/de/safari/download/">
            		<img id="sa" src="public/global/img/sa.jpg" height="64" border="0" />
            	</a>
            	<a href="http://www.getfirefox.de/">
					<img id="ff" src="public/global/img/ff.jpg" height="64" />
                </a>
                <a href="http://browsehappy.com/">
                	<img id="ie" src="public/global/img/ie.jpg" height="64" />
            	</a>
            <br />
            <h2 id="supported_browser">Dein Browser wird nicht unterstützt! Unterstützte Browser herunterladen!</h2>
            <h2 id="ie_support" style="color: red" class="hidden">Der InternetExplorer wird nur teilweise unterstützt! <br /> Unterstützte Browser herunterladen!</h2>
        </div>
        -->
	</center>
	</body>
</html>
