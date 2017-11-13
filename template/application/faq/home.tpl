<p metal:define-macro="home">
	<p>
		Häufig gestellte Fragen werden hier beantwortet. Bevor ihr also den Support anfragt, solltet ihr hier schauen, ob ihr
		an dieser Stelle schneller Antwort finden könnt.
		<br/>
		<br/>
		Ist eure Frage an dieser Stelle nicht beantwortet, so können wir dir auf Anfrage weiterhelfen. Stell deine Frage am 
		besten gleich im <a href="index.php?app=home&cmd=help">Hilfe-Formular</a>.
	</p>
	<div class="panel-group" id="accordion">
		<div class="panel panel-default">
			<tal:block repeat="faq faqs">
				<div class="panel-heading">
					<h3 class="question panel-title" tal:content="faq/question" />
				</div>
				<div class="answer panel-collapse">
					<p tal:content="structure faq/answer" />
				</div>
			</tal:block>
		</div>
	</div>
</p>