<!DOCTYPE html>
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
			{ 	font-size:13px;}	
			font.title
			{	font-size: 25px;	}
        	
        	.message, .login, .register
			{
				width:380px;
				padding:30px 10px 10px 10px;
				margin-bottom:20px;
			}
			
			input[type=text], input[type=password]
			{
				width: 100%;
			}
			
			div.login
			{
				position: relative;
			}
			
			div.gotologin
			{
				position: absolute;
				top: 2px;
				right: 4px;
			}
        </style>

		<tal:block content="structure captcha_script" />
		
		<script type="text/javascript" language="javascript"  tal:condition="SHOW_MSG" >
			var error = "<tal:block content='MSG' />";
			alert( error );
			window.history.back();
		</script>
	</head>
	<body marginheight="100" marginwidth="0" class="bgcolor ">
		<center>	
			<div class="message bgcolor_content content_border_fit" tal:condition="SHOW_MSG" >
	        	<span tal:content="MSG">TEXT...</span>
	        </div>
			
			<div class="login bgcolor_content content_border_fit">
	        	<div class="gotologin">
					<a href="login.php">Zurück zum Login</a>
				</div>
	        	
	        	<form action="register_do.php" method="post">
	                <table width="80%">
	                    <tr><td colspan="2"><font class="title">eCamp - Register</font></td></tr>
	                    <tr height="10"><td> </td></tr>
	                    
	                    
	                    <tr><td>E-Mail:</td><td><input tabindex="1" name="Login" type="text" /></td></tr>
	                    <tr height="10"><td> </td></tr>
	                    
	                    <tr><td>Passwort:</td><td><input tabindex="2" name="Passwort1" type="password" /></td></tr>
	                    <tr><td>Wiederholen:</td><td><input tabindex="3" name="Passwort2" type="password" /></td></tr>
	                    <tr height="40"><td> </td></tr>
	                    
	                    <tr><td>Pfadiname:</td><td><input tabindex="4" name="scoutname" type="text" /></td></tr>
	                    <tr><td>Vorname:</td><td><input tabindex="5" name="firstname" type="text" /></td></tr>
	                    <tr><td>Nachname:</td><td><input tabindex="6" name="surname" type="text" /></td></tr>
	                    <tr height="10"><td> </td></tr>
	                    
	                    <tr><td colspan="2"><tal:block content="structure captcha_html" /></td></tr>
	                    
	                    <tr><td colspan="2" align="right"><input tabindex="7" type="submit" value="Register" /></td></tr>

	                    <tr><td> </td></tr>
	                </table>
	            </form>
	        </div>
		</center>
	</body>
</html>
