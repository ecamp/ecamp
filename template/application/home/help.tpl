<span metal:define-macro="help" tal:omit-tag="">
    Wenn du mit etwas auf dieser Seite nicht zu recht kommst, oder sich bei dir grosse Fragezeichen ergeben, so schreib uns. Wir werden dir
    bestimmt weiterhelfen k&ouml;nnen.
    <br />
    <br />
    <b>Noch schneller kannst du unter umständen in den <a href="index.php?app=faq">FAQs</a> Antwort finden. 
    Also schau doch zuerst dort vorbei!</b>
    <br />
    <br /><br />
    <form id="form_feedback">
        <table width="100%">
            <tr>
                <td align="center"><b>Deine Frage:</b></td>
            </tr>
            <tr>
                <td><textarea name="feedback" id="feedback" style="width:100%" rows="10"></textarea></td>
            </tr>
            
        </table>
        <input type="button" value="Absenden" onclick="this.form.submit()" />
        <input type="hidden" name="app" value="home" />
        <input type="hidden" name="cmd" value="take_feedback" />
        <input type="hidden" name="type" value="help" />
    </form>
</span>