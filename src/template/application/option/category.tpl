<span metal:define-macro="category" tal:omit-tag="" >
    <center>
	    <div style="width:90%; font-style:italic" align="left">
			Alle Programmblöcke eines Lagers müssen einer Block - Kategorie zugeordnet sein. Diese Kategorien werden hier 
			definiert. Wenn beim Erstellen des Lagers 'J&S - Lager' gewählt wurde, so wurden hier automatisch die 4 Hauptkategorien
			von J&S - Lagern eingetragen. Typische Erweiterungen wären Kategorien wie 'TABS' oder 'Leiterhöck'.
		</div>
		<br />
		<div style="width:90%; font-style:italic" align="left" tal:condition="camp/is_course">
			Für Ausbildungskurse empfehlen wird, überwiegend den Blocktypen "Ausbildungsblock" zu verwenden. Der Grund dafür ist, dass nur
			diesen Blöcken Kursziele sowie Punkte aus der J+S- oder PBS-Checkliste zugewiesen werden können.
		</div>
		<br />
        <table width="90%" border="0" id="category_list" cellspacing="0">
            <tr>
                <td align="left"><b>Name</b></td>
                <td align="left"><b>Abk&uuml;rzung</b></td>
                <td align="left"><b>Detailprogramm-Typus</b></td>
                <td>&nbsp;</td>
            </tr>    
            

            <tr tal:repeat="category option/category_list" tal:attributes="bgcolor string:#${category/color}" class="category">
                <td align="left" class="name" tal:content="category/name"></td>
                <td align="left" class="short" tal:content="category/short_name"></td>
                <td align="left" class="type" tal:content="category/form_type"></td>
                <td align="right">
                    <a href="#" class="edit"><img src="public/global/img/edit.png" border="0" /></a>
                    <a href="#" class="del" ><img src="public/global/img/del.png" border="0" /></a>
                    <input type="hidden" class="category_id" tal:attributes="value category/id" />
                </td>
            </tr>
            
            
        </table>
        <table width="90%" border="0">
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td align="right">
                    <img src="public/global/img/wait.gif" id="new_category_wait" class="hidden" />
                    <input type="button"  value="Neue Kategorie" id="new_category" />
                </td>
            </tr>
        </table>
    </center>
</span>