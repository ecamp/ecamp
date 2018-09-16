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
							'home' => 50,
							'action_add_cat' => 50,
							'is_del_possible' => 50,
							'action_del_cat' => 50,
							
							'action_new_job' => 50,
							'action_change_jobname' => 50,
							'action_change_show_gp' => 50,
							'action_del_job' => 50,
							'action_change_job' => 50,
							'action_change_picasso' => 50,
							
							'action_add_cat' => 50,
							'action_change_cat' => 50,
							
							'action_add_mat_list' => 50,
							'action_change_mat_list' => 50,
							'action_del_mat_list' => 50,
							
							'load_dropdown' => 50
							
						);

$css = array(
				"home.css" 					=> "app",
				"content_template_fit.css" 	=> "global",
				"info_display.css" 			=> "global",
				"calendar.css" 				=> "module",
				"mooRainbow.css"			=> "module"
				//"color.css"					=> "module"
			);

$js = array(
				"mootools-core-1.4.js" 		=> "global",
				"mootools-more-1.4.js" 		=> "global",
				"other.js"					=> "global",
				"popup.js"					=> "global",
				"home.js" 					=> "app",
				"mooRainbow.js"				=> "module"
			);

$div = array(
				"lock.tpl" => "global",
				//"./public_folder/div/message.tpl",
				"busy.tpl" => "global"
			);


# Standardkommando
if ($_page->cmd == "") $_page->cmd = "home";


?>