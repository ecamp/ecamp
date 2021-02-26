<span metal:define-macro="home" tal:omit-tag="" >
	<p>
		Häufig gestellte Fragen werden hier beantwortet. Bevor ihr also den Support anfragt, solltet ihr hier schauen, ob ihr
		an dieser Stelle schneller Antwort finden könnt.
	</p>
	<p>
		Ist eure Frage an dieser Stelle nicht beantwortet, so können wir dir auf Anfrage weiterhelfen. Stell deine Frage am 
		besten gleich im <a href="index.php?app=home&cmd=help">Hilfe-Formular</a>.
	</p>
	
	<div id="accordion">
		
		<tal:block repeat="faq faqs">
			
			<h3 class="question" tal:content="faq/question" />
			<div class="answer">
				<p tal:content="structure faq/answer" />
			</div>
			
		</tal:block>
		
	</div>
</span>