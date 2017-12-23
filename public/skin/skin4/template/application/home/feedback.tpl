<span metal:define-macro="feedback" tal:omit-tag="">
    Hier kannst du uns R&uuml;ckmeldungen und Verbesserungsvorschl&auml;ge &uuml;ber die Seite schicken. Wenn du Fehler in der Seite findest, w&auml;ren wir auch sehr dankbar
    wenn du uns dies mitteilen k&ouml;nntest. Auch &uuml;ber Lob und Dankensreden w&uuml;rden wir uns freuen ;-)
    <br />
    <br /><br />
    <form id="form_feedback">
        <table width="100%">
            <tr>
                <td align="center"><b>Deine R&uuml;ckmeldung:</b></td>
            </tr>
            <tr>
                <td><textarea name="feedback" id="feedback" style="width:100%" rows="10"></textarea></td>
            </tr>
            
        </table>
        <input type="button" value="Absenden" onclick="this.form.submit()" />
        <input type="hidden" name="app" value="home" />
        <input type="hidden" name="cmd" value="take_feedback" />
        <input type="hidden" name="type" value="feedback" />
    </form>
</span>