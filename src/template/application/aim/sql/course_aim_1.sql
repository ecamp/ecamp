--
-- Daten für Tabelle `course_aim` (Vorlage Basiskurs 1. Stufe)
--

INSERT INTO course_aim (`id`, `pid`, `camp_id`, `aim`) VALUES 
(NULL, NULL, $camp_id, 'Der Kurs vermittelt den TN die Pfadigrundlagen.');

INSERT INTO course_aim (`id`, `pid`, `camp_id`, `aim`) VALUES 
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN wissen, was die Pfadigrundlagen sind und erkennen deren Bezug zu ihrem Pfadialltag.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN kennen das Stufenmodell der Pfadibewegung und können die Wolfsstufe von der Biber- und der Pfadistufe abgrenzen.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN kennen den Entwicklungsstand und die Bedürfnisse der Kinder der Wolfsstufe.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN wissen, wie die sieben Pfadimethoden auf der Wolfsstufe gelebt werden.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN kennen und vertiefen die Wolfsstufensymbolik.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN setzen sich persönlich mit dem Gesetz und dem Versprechen der Roverstufe auseinander.');

INSERT INTO course_aim (`id`, `pid`, `camp_id`, `aim`) VALUES
(NULL, NULL, $camp_id, 'Der Kurs bildet die TN aus, ein Programm für die Wolfsstufe zu planen, durchzuführen und auszuwerten.');

INSERT INTO course_aim (`id`, `pid`, `camp_id`, `aim`) VALUES
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN kennen Methoden zur Planung, Durchführung und Auswertung von Programmen und wissen, was sie bei den einzelnen Schritten besonders beachten müssen.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN können Aktivitäten und Quartalsprogramme der Wolfsstufe stufengerecht einkleiden.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN können ein Quartalsprogramm für die Wolfsstufe planen.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN wissen, worauf sie bei der Planung eines Weekends für die Wolfsstufe achten müssen.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN kennen das Abenteuer als Form der Mitbestimmung auf der Wolfsstufe sowie Möglichkeiten, dieses ins Programm zu integrieren.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN können sportliche Aktivitäten für die Wolfsstufe planen, durchführen und auswerten.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN können Wanderungen für die Wolfsstufe planen, durchführen und auswerten.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN können zu einem Programmteil für die Wolfsstufe eine relevante und konstruktive Rückmeldung geben.');

INSERT INTO course_aim (`id`, `pid`, `camp_id`, `aim`) VALUES 
(NULL, NULL, $camp_id, 'Der Kurs bildet die TN zu verantwortungsbewussten Mitgliedern eines Leitungsteams aus.');

INSERT INTO course_aim (`id`, `pid`, `camp_id`, `aim`) VALUES 
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN kennen ihre Funktion sowie ihre Rechte und Pflichten als Mitglieder eines Leitungsteams der Wolfsstufe.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN kennen die Rolle der Leitwölfe und wissen, wie sie diese betreuen müssen.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN kennen Strategien zum Umgang mit Wölfen mit herausforderndem Verhalten.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN kennen den Begriff der sexuellen Ausbeutung und wissen, wo in ihrer Pfadiarbeit heikle Situationen entstehen können.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN kennen die Grundgedanken der Gesundheitsförderung und wissen, wie sie das psychische, physische und soziale Wohlbefinden ihrer Wölfe positiv beeinflussen können.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN können für sicherheitsrelevante Aktivitäten auf der Wolfsstufe ein Sicherheitskonzept erstellen und wissen, wie sie sich bei Notfällen verhalten müssen.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN kennen Anlaufstellen und Angebote ihres Kantonalverbands / ihrer Region sowie das kantonale Krisenkonzept.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN setzen sich mit ihrer Leitungspersönlichkeit und ihrer Rolle im Team auseinander.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN kennen Regeln für ein konstruktives Gespräch und können diese anwenden.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN kennen Möglichkeiten der Aus- und Weiterbildung.');

INSERT INTO course_aim (`id`, `pid`, `camp_id`, `aim`) VALUES 
(NULL, NULL, $camp_id, 'Der Kurs befähigt die TN, Aktivitäten wolfsstufengerecht zu gestalten.');

INSERT INTO course_aim (`id`, `pid`, `camp_id`, `aim`) VALUES 
(NULL, LAST_INSERT_ID(), $camp_id, 'Die TN kennen die Pfadimethode „Persönlichen Fortschritt fördern“ sowie Möglichkeiten, diese in ihren Aktivitäten umzusetzen.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'kennen das Wolfsgesetz sowie Möglichkeiten zur Arbeit mit Gesetz und Versprechen auf der Wolfsstufe.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'kennen verschiedene Formen von Lagerfeuern auf der Wolfsstufe und wissen, worauf sie bei deren Gestaltung achten müssen.'),
(NULL, LAST_INSERT_ID(), $camp_id, 'verfügen über vertiefte Kenntnisse der Wolfsstufentechnik und können diese stufengerecht vermitteln.');
