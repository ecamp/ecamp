<span metal:define-macro="main" tal:omit-tag="">
	<table>
		<tal:block tal:repeat="new news">
			<tr>
				<td class="news_title" tal:content="new/title" />
				<td class="news_date" tal:content="new/date" />
			</tr>
			<tr>
				<td class="news_text" colspan="2" tal:content="structure new/text" />
			</tr>
			<tr class="news_option">
				<td colspan="2">
					<form action="index.php">
						<input type="button" onclick="this.form.submit()" value="Nachricht nicht mehr anzeigen" />

						<input type="hidden" name="app" value="home" />
						<input type="hidden" name="cmd" value="action_del_news" />
						<input type="hidden" name="date" tal:attributes="value new/key" />
					</form>

				</td>
			</tr>
		</tal:block>
		<tr tal:condition="no_news">
			<td><i>[Keine News vorhanden]</i></td>
		</tr>
	</table>
</span>