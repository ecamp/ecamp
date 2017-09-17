<html>
	<head>
		<title>eCamp v2</title>
		
        <link rel="stylesheet" type="text/css" href="./public/global/css/color.css" />
        <link rel="stylesheet" type="text/css" href="./public/global/css/global.css" />
        
		<style>
			table{font-size:13px;}
			font.title{font-size: 25px;}
			div.menu {
				width: 180px;
				background-color: #2288ff;
				border-width: 1px;
				border-color: #000000;
				border-style: solid;	
				position: relative;
				top: 30px;
				text-align: left;
			}
			a.menu {
                color: #000000;
				text-decoration: none;	}
			table.Login{
				border-width: 1px;
				border-color: #000000;
				border-style: solid;	
			}
		</style>
	</head>
	
	<script type="text/javascript" language="javascript" src="./public/global/js/mootools1.2.js"></script>
	
	<script type="text/javascript" language="javascript">
		window.addEvent( 'load', function()
		{
			$('js_false').addClass('hidden');
			$('js_true').removeClass('hidden');
		});
	</script>
	
	
	<body marginheight="100" marginwidth="0" class="bgcolor">
        <center>
        	<table tal:condition="SHOW_MSG" width="400" class="Login round_corner bgcolor_content" cellpadding="5px">
            	<tr>
                	<td align="center" tal:content="MSG">TEXT...</td>
                </tr>
                
            </table>
            <br />
            <table width="400" height="150" class="Login round_corner bgcolor_content">
				<tr align="center" height="150">
					<td valign="middle" width="100%">
						<form action="login.php" method="post">
							<table>
								<tr><td colspan="2"><font class="title">Login</font></td></tr>
								<tr height="10"><td> </td></tr>
								<tr><td>E-Mail:</td><td><input tabindex="1" name="Login" type="text" /></td></tr>
								<tr><td>Passwort:</td><td><input tabindex="2" name="Passwort" type="password" /></td></tr>
								<tr><td colspan="2" align="right"><input tabindex="3" type="submit" value="Login" /></td></tr>
								<tr><td> </td></tr>
                            </table>
							<input name="Form" value="Login" type="hidden" />
						</form>
					</td>
				</tr>
			</table>
            <br />
            <table width="400" height="30" class="Login round_corner bgcolor_content">
				<tr align="center" height="30">
					<td valign="middle" width="100%">
						Du hast noch kein Login? <a href="register.php" ><b>Registrieren</b></a><br /><br />
                        <a href="reminder.php" ><b>Passwort vergessen?</b></a>
					</td>
				</tr>
			</table>
		</center>
        
        <center>
        	<table width="400" height="100" class="Login bgcolor_white" style="margin-top:50px">
            	<tr>
                	<td colspan="3" align="center"><b>Unterst&uuml;tzte Browser:</b></td>
                </tr>
                
                <tr>
                	<td align="center"><img src="public/global/img/sa.jpg" height="64" /></td>
                    <td align="center"><img src="public/global/img/ff.jpg" height="64" /></td>
                    <td align="center"><img src="public/global/img/ie.jpg" height="64" /></td>
                </tr>
            </table>
            <table width="400" height="50" class="Login bgcolor_white" style="margin-top:20px">
                <tr id="js_false">
                	<td colspan="3" style="background-color:#ff0000">
                		<center>
                			<b style="font-size:16px">
                				Diese Seite macht gebrauch von JavaScript. <br />
                				Bitte schalte JavaScript f&uuml;r diese Seite ein!
                			</b>
                		</center>
                	</td>
                </tr>
                
                <tr class="hidden" id="js_true">
                	<td colspan="3" style="background-color:#00ff00">
                		<center>
                			<b style="font-size:16px">
                				Diese Seite macht gebrauch von JavaScript. <br />
                				Bitte schalte JavaScript nicht aus!
                			</b>
                		</center>
                	</td>
                </tr>
            </table>
        </center>
	</body>
</html>
