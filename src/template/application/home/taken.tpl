<span metal:define-macro="taken" tal:omit-tag="">
	
	<tal:block condition="feedback">
		<h1>Danke für dein Feedback</h1>
		
		<p>
			Um eCamp immer weiter zu perfektionieren, sind wir jeder Zeit dankbar für dein Feedback.
			<br />
			Danke, das eCamp Team
		</p>
		
	</tal:block>
	
	<tal:block condition="help">
		<h1>Dein Hilferuf ist angekommen</h1>
		
		<p>
			Wir werden versuchen, deinem Hilferuf so schnell wie möglich gerecht zu werden.
			Leider können wir dafür aber keine Garantie abgeben.
			<br />
			Das eCamp Team
		</p>
		
	</tal:block>
	
	<p align="right">
		<button onclick="history.back()">Zurück</button>
	</p>
</span>