<span metal:define-macro="welcome" tal:omit-tag="">
    Diese Webapplikation soll dazu dienen, ein Lagerprogramm einfach und gem&auml;ss J&amp;S - Vorschriften zu erstellen. Es erm&ouml;glicht das gemeinsame Erarbeiten des Programms auf grosse Distanzen. So eignet es sich unter anderem speziell f&uuml;r Leitungsteams, die nicht jedes Wochenende zusammen im Ausgang sind, auch wenn sie dies gerne so pflegen w&uuml;rden.
    <br />
    <br />
    <tal:block condition="inventions">
        <br />
        <b>Du hast <span tal:content="num_inventions" tal:omit-tag="">
            </span> neue Lagereinladungen. <a href="index.php?app=camp_admin">Einladungen ansehen...</a>
        </b>
        <br />
        <br />
    </tal:block>
</span>
