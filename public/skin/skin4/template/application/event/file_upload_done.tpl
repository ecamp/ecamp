<html>
	<head>
		<title>File Uploaded</title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	
	<style>
		*{
			font-family: Arial;
		}
	</style>
	
	<script tal:content="structure js_code" type="text/javascript" language="javascript"></script>
	
	<script type="text/javascript" language="javascript">
		window.parent.$event.$file_upload.add_file( $_var_from_php.file );
	</script>
	
	<body>
		<center>
			<h2>
				File added
			</h2>
		
			<p>
				Datei erfolgreich hinzugefügt: <br />
				<b><tal:block content="file/filename" /></b>
			</p>
			
			<form action="index.php">
				<input type="submit" value="Neue Datei hinzufügen" style="width: 40%" />
				<input type="button" value="Fenster schliessen" style="width: 40%" onclick="window.parent.$popup.hide_popup()" />
				
				<input type="hidden" name="app" value="event" />
				<input type="hidden" name="cmd" value="file_upload_form" />
				<input type="hidden" name="event_id" tal:attributes="value event_id" />
			</form>
		</center>
		
		
	</body>
</html>