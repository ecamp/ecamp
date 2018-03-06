INSERT INTO user ( `active`, `mail`, `pw`, `scoutname`, `firstname`, `surname`, `acode` )
          VALUES ( '1', 'test@test.ch', '098f6bcd4621d373cade4e832627b4f6', 'Albis', 'Alfred', 'Alther', '00000000000000000000000000000000' );
SET @albis = LAST_INSERT_ID();
INSERT INTO user ( `active`, `mail`, `pw`, `scoutname`, `firstname`, `surname`, `acode` )
          VALUES ( '1', 'test2@test.ch', '098f6bcd4621d373cade4e832627b4f6', 'Boa', 'Bettina', 'Bodmer', '00000000000000000000000000000000' );
SET @boa = LAST_INSERT_ID();
INSERT INTO user ( `active`, `mail`, `pw`, `scoutname`, `firstname`, `surname`, `acode` )
          VALUES ( '1', 'test3@test.ch', '098f6bcd4621d373cade4e832627b4f6', 'Chnuschti', 'Christoph', 'Carozzi', '00000000000000000000000000000000' );
SET @chnuschti = LAST_INSERT_ID();
INSERT INTO user ( `active`, `mail`, `pw`, `scoutname`, `firstname`, `surname`, `acode` )
          VALUES ( '1', 'test4@test.ch', '098f6bcd4621d373cade4e832627b4f6', 'Dorie', 'Diana', 'Dillier', '00000000000000000000000000000000' );
SET @dorie = LAST_INSERT_ID();
INSERT INTO user ( `active`, `mail`, `pw`, `scoutname`, `firstname`, `surname`, `acode` )
          VALUES ( '1', 'test5@test.ch', '098f6bcd4621d373cade4e832627b4f6', 'Echo', 'Egon', 'Engelberger', '00000000000000000000000000000000' );
SET @echo = LAST_INSERT_ID();


INSERT INTO `camp` (`group_id`, `name`, `group_name`, `slogan`, `short_name`, `is_course`, `jstype`, `type`, `type_text`, `creator_user_id`, `ca_name`, `ca_street`, `ca_zipcode`, `ca_city`, `ca_tel`, `ca_coor`, `t_created`, `t_edited`)
            VALUES (0,'Testkurs','Testpfadi','Kursmotto','CH-TST-18',1,53,14,'Kursart-Freitext',@albis,'Kursadresse-Name','Kursadresse-Strasse','6666','Kursadresse-Ort','Kursadresse-Telefon','000.111/222.333',1514764800,'2018-01-01 00:00:00');
SET @course = LAST_INSERT_ID();

INSERT INTO `subcamp` (`camp_id`, `start`, `length`, `t_edited`)
               VALUES (@course,6629,8,'2018-01-01 00:00:00');
SET @subcourse = LAST_INSERT_ID();

INSERT INTO `category` ( `camp_id`, `name`, `short_name`, `color`, `form_type`, `t_edited` )
                VALUES (@course,'Ausbildung','A','548dd4',4,'2018-01-01 00:00:00'),(@course,'Pfadi erleben','P','ffa200',4,'2018-01-01 00:00:00'),(@course,'Roter Faden','RF','14dd33',4,'2018-01-01 00:00:00'),(@course,'Gruppestunde','GS','99ccff',4,'2018-01-01 00:00:00'),(@course,'Essen','','bbbbbb',0,'2018-01-01 00:00:00'),(@course,'Sonstiges','','FFFFFF',0,'2018-01-01 00:00:00');

INSERT INTO `day` (`subcamp_id`, `day_offset`, `story`, `notes`, `t_edited`)
           VALUES (@subcourse,0,'','','2018-01-01 00:00:00'),(@subcourse,1,'','','2018-01-01 00:00:00'),(@subcourse,2,'','','2018-01-01 00:00:00'),(@subcourse,3,'','','2018-01-01 00:00:00'),(@subcourse,4,'','','2018-01-01 00:00:00'),(@subcourse,5,'','','2018-01-01 00:00:00'),(@subcourse,6,'','','2018-01-01 00:00:00'),(@subcourse,7,'','','2018-01-01 00:00:00');

INSERT INTO `job` (`camp_id`, `job_name`, `show_gp`, `t_edited`)
           VALUES (@course,'Tageschef',1,'2018-01-01 00:00:00');

INSERT INTO `mat_list` (`camp_id`, `name`, `t_edited`)
                VALUES (@course,'Lebensmittel','2018-01-01 00:00:00'),(@course,'Baumarkt','2018-01-01 00:00:00');

INSERT INTO `todo` (`camp_id`, `title`, `short`, `date`, `done`)
            VALUES (@course,'Kursanmeldung','Anmeldung an LKB (Picasso, Blockübersicht, Checklisten)',6573,0),(@course,'Detailprogramm einreichen','Definitives Detailprogramm an LKB.',6615,0),(@course,'Kursabschluss','TN-Liste, Kursbericht',6657,0),(@course,'J+S-Material/Landeskarten','J+S-Material und Landeskarten bestellen.',6587,0);

INSERT INTO `user_camp` (`user_id`, `camp_id`, `function_id`, `invitation_id`, `active`, `t_edited`)
                 VALUES (@albis,@course,48,0,1,'2018-01-01 00:00:00'),(@boa,@course,49,@albis,1,'2018-01-01 00:00:00'),(@chnuschti,@course,50,@albis,1,'2018-01-01 00:00:00');

UPDATE user SET `last_camp`=@course WHERE `id` IN (@albis,@boa,@chnuschti);


INSERT INTO `camp` (`group_id`, `name`, `group_name`, `slogan`, `short_name`, `is_course`, `jstype`, `type`, `type_text`, `creator_user_id`, `ca_name`, `ca_street`, `ca_zipcode`, `ca_city`, `ca_tel`, `ca_coor`, `t_created`, `t_edited`)
            VALUES (0,'Testlager','Testpfadi','Lagermotto','So-La',0,52,0,'Kursart-Freitext',@albis,'Lageradresse-Name','Lageradresse-Strasse','6666','Lageradresse-Ort','Lageradresse-Telefon','000.111/222.333',1514764800,'2018-01-01 00:00:00');
SET @camp = LAST_INSERT_ID();

INSERT INTO `subcamp` (`camp_id`, `start`, `length`, `t_edited`)
               VALUES (@camp,6777,7,'2018-01-01 00:00:00');
SET @subcamp = LAST_INSERT_ID();

INSERT INTO `category` ( `camp_id`, `name`, `short_name`, `color`, `form_type`, `t_edited` )
                VALUES (@camp,'Essen','ES','bbbbbb',0,'2018-01-01 00:00:00'),(@camp,'Lagerprogramm','LP','99ccff',3,'2018-01-01 00:00:00'),(@camp,'Lageraktivität','LA','ffa200',2,'2018-01-01 00:00:00'),(@camp,'Lagersport','LS','14dd33',1,'2018-01-01 00:00:00');

INSERT INTO `day` (`subcamp_id`, `day_offset`, `story`, `notes`, `t_edited`)
           VALUES (@subcamp,0,'','','2018-01-01 00:00:00'),(@subcamp,1,'','','2018-01-01 00:00:00'),(@subcamp,2,'','','2018-01-01 00:00:00'),(@subcamp,3,'','','2018-01-01 00:00:00'),(@subcamp,4,'','','2018-01-01 00:00:00'),(@subcamp,5,'','','2018-01-01 00:00:00'),(@subcamp,6,'','','2018-01-01 00:00:00');

INSERT INTO `job` (`camp_id`, `job_name`, `show_gp`, `t_edited`)
           VALUES (@camp,'Tageschef',1,'2018-01-01 00:00:00');

INSERT INTO `mat_list` (`camp_id`, `name`, `t_edited`)
                VALUES (@camp,'Lebensmittel','2018-01-01 00:00:00'),(@camp,'Baumarkt','2018-01-01 00:00:00');

INSERT INTO `todo` (`camp_id`, `title`, `short`, `date`, `done`)
            VALUES (@camp,'Lagerhaus/Lagerplatz reservieren','Das Lagerhaus/Lagerplatz definitiv reservieren.',6537,0),(@camp,'Küchenteam suchen','Das Küchenteam zusammenstellen.',6597,0),(@camp,'Picasso zusammenstellen','Ersten Entwurf des Picassos zusammenstellen.',6597,0),(@camp,'PBS - Lageranmeldung','PBS - Lageranmeldung ausfüllen und an Coach schicken.',6687,0),(@camp,'J&S - Materialbestellung','J&S - Materialbestellung ausfüllen und an Coach schicken',6687,0),(@camp,'Landeskartenbestellung','Landeskartenbestellung ausfüllen und an Coach schicken',6687,0),(@camp,'J&S - Lageranmeldung','Sicherstellen, dass Coach das Lager unter J&S anmeldet (online).',6717,0),(@camp,'Spendenaufrufe verschicken','Spendenaufrufe an regionale Firmen verschicken.',6717,0),(@camp,'Lageranmeldung verschicken','Lageranmeldung an alle TN verschicken.',6717,0),(@camp,'Programmabgabe','Fertiges Programm an Coach abgeben.',6735,0),(@camp,'Siebdruck anfertigen','Siebdruck / Lagerdruck anfertigen.',6749,0),(@camp,'Regaversicherung','Für alle TN eine gratis - Regaversicherung abschliessen.',6763,0),(@camp,'Letzte Infos verschicken','Letzte Infos für TNs verschicken',6763,0);

INSERT INTO `user_camp` (`user_id`, `camp_id`, `function_id`, `invitation_id`, `active`, `t_edited`)
                 VALUES (@albis,@camp,1,0,1,'2018-01-01 00:00:00'),(@dorie,@camp,46,@albis,1,'2018-01-01 00:00:00'),(@echo,@camp,2,@albis,1,'2018-01-01 00:00:00'),(@chnuschti,@camp,3,@albis,1,'2018-01-01 00:00:00');

UPDATE user SET `last_camp`=@camp WHERE `id` IN (@dorie,@echo);
