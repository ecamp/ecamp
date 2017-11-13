<p metal:define-macro="main" tal:omit-tag="">
	<tal:block tal:repeat="new news">
		<p class="news_title" tal:content="new/title" />
		<p class="news_date" tal:content="new/date" />

		<p class="news_text" colspan="2" tal:content="structure new/text" />
		<form action="index.php">
			<input type="button" onclick="this.form.submit()" value="Nachricht nicht mehr anzeigen" />

			<input type="hidden" name="app" value="home" />
			<input type="hidden" name="cmd" value="action_del_news" />
			<input type="hidden" name="date" tal:attributes="value new/key" />
		</form>
		<div class="space-top"></div>
	</tal:block>

	<p tal:condition="no_news">
		<i>[Keine News vorhanden]</i>
	</p>
</p>