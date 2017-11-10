<span metal:define-macro="home" tal:omit-tag="" >
	<p>
		Um einen Kollegen auf diese Homepage aufmerksam zu machen, kannst du ihm eine Einladung schicken.
	</p>
	<form accept="index.php">
		<textarea class="col-sm-12 form-control" rows="20" name="text">
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
		<div class="clearfix"></div>
		<div class="space-top"></div>
		<div class="form-group">
			<label for="inputEmailSent" class="col-sm-2 control-label">E-Mail Adresse des Absenders:</label>
			<div class="col-sm-10">
				<select name="from" class="form-control">
					<option value="user" tal:content="user/mail" selected="selected"></option>
					<option value="support">ecamp@pfadiluzern.ch</option>
				</select>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="space-top"></div>
		<div class="form-group">
			<label for="inputEmailReceave" class="col-sm-2 control-label">E-Mail Adresse des Empfängers:</label>
			<div class="col-sm-10">
			  	<input type="email" class="form-control" id="inputEmailReceave" placeholder="Empfänger" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default" tabindex="3">Abschicken</button>
			</div>
		</div>

		<input type="hidden" name="app" value="invent" />
		<input type="hidden" name="cmd" value="send" />
	</form>
</span>