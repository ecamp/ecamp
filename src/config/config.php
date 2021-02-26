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
    

    $GLOBALS['base_uri']				= getenv('BASE_URI') ?: "http://localhost/";
    
    $GLOBALS['lib_dir'] 				= __DIR__ . "/../lib";
    $GLOBALS['module_dir'] 			    = __DIR__ . "/../module";
    $GLOBALS['app_dir'] 				= __DIR__ . "/../application";
    
    # routes injected into HTML to load static files
    $GLOBALS['public_app_dir']		    = "./public/application";
    $GLOBALS['public_global_dir']	    = "./public/global";
    $GLOBALS['public_module_dir']	    = "./public/module";
    
    $GLOBALS['template_app_dir'] 	= __DIR__ . "/../template/application";
    $GLOBALS['template_global_dir'] 	= __DIR__ . "/../template/global";
    $GLOBALS['template_module_dir']     = __DIR__ . "/../template/module";
    
    $GLOBALS['tpl_dir']                 = __DIR__ . "/../template";
    
    $GLOBALS['captcha_pub'] = getenv('CAPTCHA_PUB') ?: '';
    $GLOBALS['captcha_prv'] = getenv('CAPTCHA_PRV') ?: '';
    
    $GLOBALS['time_shift']              = 300; // Minuten;
    $GLOBALS['news_num']                = 5;
    
    // Layout wählen
    $GLOBALS['skin']                    = "skin3";
    
    $GLOBALS['debug']                   = 0;
    $GLOBALS['register']                = 0;
    
    // Seite mit HTML-Tidy parsen
    $GLOBALS['parse_tidy']              = false;
    
    $GLOBALS['feedback_mail']           = getenv('FEEDBACK_MAIL') ?: "ecamp@pfadiluzern.ch";
    $GLOBALS['support_mail']            = getenv('SUPPORT_MAIL') ?: "ecamp@pfadiluzern.ch";
    
    
    $GLOBALS['host']    = getenv('DB_HOST') ?: "db";
    $GLOBALS['db']	    = getenv('DB_SCHEMA') ?: "ecamp2_dev";
    $GLOBALS['us'] 	    = getenv('DB_USER') ?: "ecamp2";
    $GLOBALS['pw'] 	    = getenv('DB_PASSWORD') ?: "ecamp2";
    $GLOBALS['db_port'] = getenv('DB_PORT') ?: 3306;
    
    
    $GLOBALS['en_to_de'] = array(
            "Monday" 	=> "Montag",
            "Tuesday"	=> "Dienstag",
            "Wednesday"	=> "Mittwoch",
            "Thursday"	=> "Donnerstag",
            "Friday"	=> "Freitag",
            "Saturday"	=> "Samstag",
            "Sunday"	=> "Sonntag",
    
            "Mon"		=> "Mo",
            "Tue"		=> "Di",
            "Wed"		=> "Mi",
            "Thu"		=> "Do",
            "Fri"		=> "Fr",
            "Sat"		=> "Sa",
            "Sun"		=> "So",
    
            "January"	=> "Januar",
            "February"	=> "Februar",
            "March"		=> "März",
            "April"		=> "April",
            "May"		=> "Mai",
            "June"		=> "Juni",
            "July"		=> "Juli",
            "August"	=> "August",
            "September"	=> "September",
            "November"	=> "November",
            "December"	=> "Dezember"
    );
    
    
    $GLOBALS['smtp-config'] = array(
            'host' => getenv('SMTP_HOST') ?: 'localhost',
            'port' => getenv('SMTP_PORT') ?: '465',
            'auth' => getenv('SMTP_AUTH') ?: true,
            'username' => getenv('SMTP_USERNAME') ,
            'password' => getenv('SMTP_PASSWORD') );
    

    // use config.local.php to override any neccessary config parameters
    if (file_exists(__DIR__ . '/config.local.php')) {
        include(__DIR__ . '/config.local.php');
    }
