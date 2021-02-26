<html>
	<head>
		<title>File Upload</title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	
	<style>
		*{
			font-family: Arial;
		}
	</style>
	
	<body>
		<center>
			<h2>
				<tal:block content="event/name" />
			</h2>
		
			<form action="index.php" method="post" enctype="multipart/form-data">
				<input type="file" name="upload" style="border: 1px solid black; width: 100%" />
				<br /><br />
				<input type="submit" value="Hinzufügen" style="width: 40%" />
				<input type="button" value="Abbrechen" style="width: 40%" onclick="window.parent.$popup.hide_popup()" />
				
				<input type="hidden" name="app" value="event" />
				<input type="hidden" name="cmd" value="action_file_upload" />
				<input type="hidden" name="event_id" tal:attributes="value event/id" />
			</form>
		</center>
		
		
	</body>
</html>