<p metal:define-macro="feedback" tal:omit-tag="">
    Hier kannst du uns R&uuml;ckmeldungen und Verbesserungsvorschl&auml;ge &uuml;ber die Seite schicken. Wenn du Fehler in der Seite findest, w&auml;ren wir auch sehr dankbar
    wenn du uns dies mitteilen k&ouml;nntest. Auch &uuml;ber Lob und Dankensreden w&uuml;rden wir uns freuen ;-)
    <div class="space-top"></div>
    <form id="form_feedback">
        <div class="form-group">
            <label for="comment">Deine Rückmeldung:</label>
            <textarea name="feedback" id="feedback" class="form-control" rows="10"></textarea>
        </div>

        <input type="button" value="Absenden" onclick="this.form.submit()" />
        <input type="hidden" name="app" value="home" />
        <input type="hidden" name="cmd" value="take_feedback" />
        <input type="hidden" name="type" value="feedback" />
    </form>
</p>