<p metal:define-macro="help">
    Wenn du mit etwas auf dieser Seite nicht zu recht kommst, oder sich bei dir grosse Fragezeichen ergeben, so schreib uns. Wir werden dir
    bestimmt weiterhelfen k&ouml;nnen.
    <div class="space-top"></div>
    <b>Noch schneller kannst du unter umständen in den <a href="index.php?app=faq">FAQs</a> Antwort finden. Also schau doch zuerst dort vorbei!</b>
    <div class="space-top"></div>
    <form id="form_feedback">
        <div class="form-group">
            <label for="comment">Deine Frage:</label>
            <textarea name="feedback" id="feedback" class="form-control" rows="10"></textarea>
        </div>

        <input type="button" value="Absenden" onclick="this.form.submit()" />
        <input type="hidden" name="app" value="home" />
        <input type="hidden" name="cmd" value="take_feedback" />
        <input type="hidden" name="type" value="help" />
    </form>
</p>