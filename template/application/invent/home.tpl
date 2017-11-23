<span metal:define-macro="home" tal:omit-tag="" >
	
	<h1>Einladung verschicken</h1>
	
	<p style="margin-bottom:30px;">
		Um einen Kollegen auf diese Homepage aufmerksam zu machen, kannst du ihm eine Einladung schicken.
	</p>
	
	<p>
		Als Text für die Einladung werden folgende Zeilen vorgeschlagen:
	</p>
	
	<form accept="index.php">
	
		<textarea style="width:90%" rows="20" name="text">
Hallo ...

Ich habe eine Homepage entdeckt, welche für dich von interesse sein könnte. 
Diese Homepage ermöglicht es einem, J&S-Lager gemeinsam auf dem Internet zu planen.

Dies ist vorallem aus 2 Gründen sehr interessant. Zum einen können alle Mitleiter jederzeit auf die aktuellste Version der Lagerplanung zugreifen.
Zudem lassen sich so auch Lager organisieren, auch wenn man sich nicht jeden Tag treffen kann.

Du findest das Portal auf dem Server der Pfadi Luzern.
Hier die Adresse: 

http://ecamp.pfadiluzern.ch


Viel Spass!

Gruss	
		</textarea>
		
		<p>
			<table width="90%">
				<tr>
					<td width="200px">E-Mail Adresse des Absenders:</td>
					<td>
						<select name="from" style="width:100%">
							<option value="user" tal:content="user/mail" selected="selected"></option>
							<option value="support">ecamp@pfadiluzern.ch</option>
						</select>
					</td>
					<td></td>
				</tr>
				<tr>
					<td>E-Mail Adresse des Empfängers:</td>
					<td><input type="text" name="email" style="width:100%" /></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td align="right">
						<input type="submit" value="Abschicken" />
					</td>
				</tr>
			</table>
				
			
		
		</p>
		
		<input type="hidden" name="app" value="invent" />
		<input type="hidden" name="cmd" value="send" />
	</form>
</span>