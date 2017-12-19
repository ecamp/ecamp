<?php
/*
 * Copyright (C) 2010 Urban Suppiger, Pirmin Mattmann
 *
 * This file is part of eCamp.
 *
 * eCamp is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * eCamp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with eCamp.  If not, see <http://www.gnu.org/licenses/>.
 */

	$_page->html->set('main_macro', $GLOBALS['tpl_dir'].'/global/content_box_fit.tpl/predefine');
	$_page->html->set('box_content', $GLOBALS['tpl_dir'].'/application/faq/home.tpl/home');
	$_page->html->set('box_title', 'FAQ');

	$faq = array(
		array(
			"question" => "Wie kann ich meine Mitleiter zu meinem Lager einladen?",
			"answer" => "Wichtig ist, dass deine Mitleiter bereits bei eCamp sind. Sollte das nicht der Fall sein, muss du sie 
							als erstes zu eCamp einladlen. Dies kannst du am besten hier erledigen:
							<a href='index.php?app=invent'>Einladen</a>
							<br /><br />
							Sind deine Mitleiter bei eCamp angemeldet, kannst du diese zur Mitarbeit in deinem Lager einladen. Dazu
							musst du im Menupunkt <a href='index.php?app=leader'>Leiterliste</a> auf <b>neuer Leiter </b> klicken.
							Mit dem Formular, welches erscheint, kannst du nun nach deinen Mitleiter suchen."
		),
		array(
			"question" => "Im Grobprogramm ist unten rechts ein Knopf. Wozu dient dieser?",
			"answer" => "Mit diesem Knopf <button>Darstellung</button> kannst du die Darstellung umstellen. Dabei werden im normalen Modus die Blöcke nach 
							deren Kategorie eingefärbt. Wechselt man den Modus, so werden die Blöcke nach derem Fortschritt 
							eingefärbt. Dabei steht rot für 0%, grün für 90% und weiss für 100% fortgeschritten. Alternativ dazu
							kannst du auch einfach die <b>Leertaste</b> drücken. Diese sollte den selben Effekt haben."
		),
		array(
			"question" => "Sind die Daten auf dem Server sicher?",
			"answer" => "Die Daten in der Datenbank werden alle 3 Stunden gesichert. Sollte also einmal etwas geschehen, kann 
							eine sehr aktuelle Version wieder hergestellt werden.
							<br /><br />
							Sicherheit gegen Unseriöse Nutzer des Internets ist schwer zu garantieren. Jedoch halten wir uns an die
							gängigsten Prinzipien um die Seite so sicher wie uns nur möglich ist zu gestallten."
		),
		array(
			"question" => "Wie kann ich in die Profile meiner Mitleiter einsehen?",
			"answer" => "Die Profile von Mitleitern können nicht eingesehen werden. Jedoch kann von den Mitleitern eine 
							digitale Visitenkarte heruntergeladen werden. Outlook und jedes Adressbuch kann diese lesen.
							So kannst du die Kontaktmöglichkeiten zu deinen Mitleitern zu deinem Adressbuch sichern."
		),
		array(
			"question" => "Kann für die Kursanmeldung eine Zusammenstellung aller Blöcke mit deren Inhalte und Zielen 
							heruntergeladen werden?",
			"answer" => "Ja, auf jeden Fall. Versuche dein Glück unter <a href='index.php?app=aim'>Kurs Ziele</a>. 
							Oben rechts unter <b>Blockübersicht</b> kannst du diese Liste herunterladen."
		)
	);
	
	$_page->html->set( 'faqs', $faq );
