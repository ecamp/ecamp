<?php
	/**
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
   *
   */

    #############################################################################
    #
    # Filename:     index.php
    # Beschreibung: Startpunkt des Tools. Lädt sich die gewünschen Inhalte zusammen.
    #
    # ToDo: -
    #

	#############################################################################
	//Load composer's autoloader
	require '../../vendor/autoload.php';

    #############################################################################
    # Konfigurationsdatei einbinden
    include("../config/config.php");

    #############################################################################
    # Register Error Handler
    include_once($module_dir . "/error_handling.php");

    #############################################################################
    # Globale Variabeln $_camp, $_user, $_page, $_user_camp
    include("../class.php");
    $_camp = new camp; global $_camp;
    $_user = new user; global $_user;
    $_page = new page; global $_page;
    $_user_camp = new user_camp; global $_user_camp;
    $_js_env = new js_env; global $_js_env;
    $_news = new news; global $_news;

    #############################################################################
    # Libraries einbinden
	include($lib_dir . "/mysql.php"); 			// erstellt die MySQL-Verbindung
	include($lib_dir . "/validation.php");		// Funktionen zum Überprüfen von User-Eingaben
	include($lib_dir . "/sqlqueries.php");		// gepeicherte SQL-Queries
	//	include($lib_dir . "/template.php");	// Funktionen zum Laden von templates
	include($lib_dir . "/functions/error.php");	// Error-Handling
	include($lib_dir . "/functions/date.php");
	include($lib_dir . "/functions/other.php");

	include($lib_dir . "/functions/mail.php");

	// Datenbank verbinden
	db_connect();

	#############################################################################
	# Login überpüfen & Funktion (Sicherheitslevel) bestimmen
	# --> bei Bedarf wird auf login.php weitergeleitet
	include($module_dir . "/auth/check_login.php");
  
    if($debug){echo $_user_camp->auth_level . '<br /><br />';}

    #############################################################################
    # Template-Engine einbinden
    if($_SESSION['skin'] == ""){$_SESSION['skin'] = $GLOBALS['skin'];}
  
    $_page->html = new PHPTAL("public/skin/".$_SESSION['skin']."/main.tpl");
    //$_page->html = new PHPTAL("template/global/main.tpl");
    $_page->html->setEncoding('UTF-8');
    $_page->html->set( 'show_info_box', 0 );
  
    #############################################################################
    # Applikation und Kommando lesen
    //$camp_id = secure_input_nr( $_SESSION[camp_id] );   global $camp_id;
    $_page->app	= secure_input_filename( $_REQUEST['app'] );
    $_page->cmd	= secure_input_filename( $_REQUEST['cmd'] );
  
    include( $GLOBALS['lib_dir'] . "/app_program.php" );
  
    // Liste aller erlaubten Applikationen       z.B. index.php?app=home    (später in DB)
    $valid_app = array(
  	    'invent',
	    'camp',
	    'camp_admin',
	    'day',
	    'db',
	    'event',
	    'home',
	    'leader',
	    'my_resp',
	    'mat_list',
	    'option',
	    'print',
	    'program',
	    'todo',
	    'user_profile',
	    'support',
	    'faq',
	    'impressum',
	    'aim',
	    'course_checklist',
	    'mail'
    );
  
    // Applikation überprüfen
    if( $_page->app == "" )	{	$_page->app = "home";	}
    if( !in_array( $_page->app, $valid_app) ) { error_message("Keine gültige Applikation: " . $_page->app); }
  
    // Erlaubte Kommandos (Files) lesen    z.B. index.php?app=home&cmd=index
    if(is_file($app_dir."/".$_page->app."/config.php")){ include($app_dir."/".$_page->app."/config.php"); }
  
    // Kommando überprüfen & checken, ob Zugriff erlaubt
    if( !isset( $security_level[$_page->cmd] )) 					{ error_message("Keine gültiges Kommando: ".$_page->cmd); }
    if(  $security_level[$_page->cmd] > $_user_camp->auth_level ) { error_message("Keine Berechtigung für ausgewählten Befehl!"); }

    #############################################################################
    # Applikation einbinden
    // Inhalt (index.php; Kommando)
    $index_content['main'] = "";
    if( file_exists( $app_dir."/".$_page->app."/index.php" ) )	{ include($app_dir."/".$_page->app."/index.php"); }
    if( is_file($app_dir."/".$_page->app."/".$_page->cmd.".php"))	{ include($app_dir."/".$_page->app."/".$_page->cmd.".php");	}
    else  { error_message("Datei zum Kommando konnte nicht gefunden werden. Kommando: ".$_page->cmd); }

    #############################################################################
    # Rechte für Darstellung einbinden.
    $_js_env->add( 'auth_level', $_user_camp->auth_level );
    $js['auth.js'] = "global";

    #############################################################################
    # CSS & JS & DIV einbinden
    //$index_content['css_includes'] = "";
    //$index_content['js_includes']  = "";
    //$index_content['div_includes'] = "";

    $includes = array();
  
    if(is_array($css))
    {
        $_page->addCssConfig( $css );
    
  	    $includes['css'] = array();
	
  	    foreach($css as $css_file => $place)
		{
			if($place == "app")
			{	$css_file = $public_app_dir . "/" . $_page->app . "/css/" . $css_file;	}
			elseif($place == "global")
			{	$css_file = $public_global_dir . "/css/" . $css_file;	}
			elseif($place == "module")
			{	$css_file = $public_module_dir . "/css/" . $css_file;	}

			$includes['css'][] = $css_file;
		}
    }
  
    if(is_array($js))
    {
	    $_page->addJsConfig( $js );

	    $includes['js'] = array();
	
	    foreach($js as $js_file => $place)
		{
			if($place == "app")
			{$js_file = $public_app_dir . "/" . $_page->app . "/js/" . $js_file;}
			elseif($place == "global")
			{	$js_file = $public_global_dir . "/js/" . $js_file;	}
			elseif($place == "module")
			{	$js_file = $public_module_dir . "/js/" . $js_file;	}

			$includes['js'][] = $js_file;
		}
    }

  //echo $_camp->category(45);
  
    #############################################################################
    # Menü laden
    include($module_dir."/menu/menu.php");
    $_page->html->set("menu_macro", $GLOBALS['tpl_dir'] . "/module/menu/menu.tpl/menu");

    #############################################################################
    # Seite rendern
    header( "Content-Type: text/html; charset:utf-8" );
    header( 'Cache-Control: no-store, no-cache, must-revalidate' );

    $_page->html->set('app', $_page->app );
    $_page->html->set('cmd', $_page->cmd );
    $_page->html->set('user', $_user );
    $_page->html->set('camp', $_camp );
    $_page->html->set('user_camp', $_user_camp );
	//$_page->html->set('includes', $includes );
	$_page->html->set('jsIncludes', $_page->jsFiles );
    $_page->html->set('cssIncludes', $_page->cssFiles );
    $_page->html->set('js_code', $_js_env->get_js_code() );
  
    $_page->html->set("sys_dir", "../../.." );
    $_page->html->set("tpl_dir", $GLOBALS['tpl_dir'] );
    $_page->html->set("skin", $_SESSION['skin'] );
  
    if( $_REQUEST[ 'phptal' ] == 'debug' )
    {
	    echo "<pre>";
	    print_r( $_page->html->getContext() );
	    echo "</pre>";
	    die();
    }
  
	$output =  $_page->html->execute();
  
    // HTML Tidy
    if( !extension_loaded('tidy') || !$GLOBALS['parse_tidy']  )
    {
  	    echo $output;
    }
    else
    {
		$config_debug = array(
	        'indent'         => true,
		    'indent-spaces'  => 2,
		    'output-xml'     => true,
		    'input-xml'     => true,
		    'wrap'         => '1000'
	    );
				
	    $config_running= array(
	    	'indent'         => false,
		    'output-xml'     => true,
		    'input-xml'     => true,
		    'wrap'         => '0'
	    );
	
		$tidy = new tidy();
		$tidy->parseString($output, $config_debug, 'utf8');
		$tidy->cleanRepair();
		echo tidy_get_output($tidy);
  }
