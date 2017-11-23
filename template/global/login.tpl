<html>
	<head>
		<title>eCamp v2</title>
		
        <link rel="stylesheet" type="text/css" href="./public/global/css/color.css" />
        <link rel="stylesheet" type="text/css" href="./public/global/css/global.css" />
        
        
        
		<style>
			
			table
			{ 	font-size:13px;}	
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
		</style>
	</head>
	
	
	<body marginheight="100" marginwidth="0" class="bgcolor_dark">
        <center>
        	<table tal:condition="SHOW_MSG" width="400" class="Login round_corner bgcolor_content" cellpadding="5px">
            	<tr>
                	<td align="center" tal:content="MSG">TEXT...</td>
                </tr>
                
            </table>
            <br />
            <table width="400" height="150" class="Login round_corner bgcolor_bright">
				<tr align="center" height="150">
					<td valign="middle" width="100%">
						<form action="login.php" method="post">
							<table>
								<tr><td colspan="2"><font class="title">Login</font></td></tr>
								<tr height="10"><td> </td></tr>
								<tr><td>E-Mail:</td><td><input tabindex="1" name="Login" type="text" /></td></tr>
								<tr><td>Passwort:</td><td><input tabindex="2" name="Passwort" type="password" /></td></tr>
								<tr><td>Auto-Login:</td><td><input type="checkbox" name="autologin" /></td></tr>
								<tr><td colspan="2" align="right"><input tabindex="3" type="submit" value="Login" /></td></tr>
								<tr><td> </td></tr>
                            </table>
							<input name="Form" value="Login" type="hidden" />
						</form>
					</td>
				</tr>
			</table>
            <br />
            <table width="400" height="30" class="Login round_corner bgcolor_bright">
				<tr align="center" height="30">
					<td valign="middle" width="100%">
						Du hast noch kein Login? <a href="register.php" ><b>Registrieren</b></a><br /><br />
                        <a href="reminder.php" ><b>Passwort vergessen?</b></a>
					</td>
				</tr>
			</table>
		</center>
        
        <center>
        	<table width="250" height="100" class="Login bgcolor_white" style="margin-top:50px">
            	<tr>
                	<td colspan="3" align="center"><b>Unterst&uuml;tzte Browser:</b></td>
                </tr>
                
                <tr>
                	<td align="center"><img src="public/global/img/sa.jpg" height="64" /></td>
                    <td align="center"><img src="public/global/img/ff.jpg" height="64" /></td>
                    <td align="center"><img src="public/global/img/ie.jpg" height="64" /></td>
                </tr>
            </table>
        </center>
        
        
	</body>
</html>
