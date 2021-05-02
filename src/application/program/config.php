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


# Sichheitslevel der einzelnen Aktionen/Dateien
# --> Kommandos/Files die nicht aufgeührt sind, können nicht aufgerufen werden
$security_level = array( 
							'home' 						=> 20,
							'save_past_event'			=> 40,
							'save_move_event'			=> 40,
							'save_zoom_event'			=> 40,
							'save_add_event'			=> 40,
							'save_main_job'				=> 40,
							'copy_event_instance'		=> 20,
							'copy_event'				=> 20,
							'remove_event_instance'		=> 40,
							'change_name'				=> 40,
							'change_category'			=> 40,
							'change_responsible_user'	=> 40,
							'load_gp_data'				=> 20,
							'load_dp_data'				=> 20,
							'lock_event'				=> 40,
							'unlock_event'				=> 40
						);

$css = array(
				"content_template_full.css" => "global",
				"info_display.css" 			=> "global",
				"context_menu_new.css"		=> "app",
				"home.css"					=> "app"
			);

$js  = array(
				"mootools-core-1.4.js" 		=> "global",
				"mootools-more-1.4.js" 		=> "global",
				"popup.js" => "global",
				"other.js" => "global",
				
				"gp_class.js"	=> "app",
				"user_class.js" => "app",
				"category_class.js" => "app",
				"subcamp_class.js" => "app",
				"day_class.js" => "app",
				"event_class.js" => "app",
				"event_instance_class.js" => "app",
				"menu_class.js" => "app",
				
				//"dp_class.js" => "app",
				"config.js" => "app",
				"numbering.js" => "app",
				
				"event.js" => "module",
				"dynamic_input.js" => "global"
			);

$div = array(
				"context_menu.tpl" 	=> "app",
				"d_program.tpl"		=> "app"
			);


# Standardkommando
if( $_page->cmd == "" ) $_page->cmd = "home";



$show_day = 8;

$day_width = 150;

// write session data & release session lock
// after this, changes to $_SESSION variables are not written to DB anymore
session_write_close();


?>