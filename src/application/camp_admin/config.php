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
# --> Kommandos/Files die nicht aufge�hrt sind, k�nnen nicht aufgerufen werden
$security_level = array( 
							'home' => 10,
							'new_camp' => 10,
							'new_course' => 10,
							'action_new_camp' => 10,
							'action_del_camp' => 10,
							"action_save_camp" => 10,
							"action_inventation" => 10,
							"action_exit_camp" => 10,
							"load_dropdown" => 10,
							"load_select" => 10
						);

$css = array(
				"home.css" => "app",
				"calendar.css" => "module",
				"content_template_fit.css" => "global",
				"tips.css" => "global"
			);

$js  = array(
				"mootools-core-1.4.js" 		=> "global",
				"mootools-more-1.4.js" 		=> "global",
				"popup.js" => "global",
				"calendar.js" => "module",
				"calendar-setup.js" => "module",
				"calendar-de.js" => "module",
				"home.js" => "app",
				"new_camp.js" => "app"
			);

$div = array(
				"lock.tpl" => "global",
				//"./public_folder/div/message.tpl",
				"busy.tpl" => "global"
			);

# Standardkommando
if( $_page->cmd == "" ) {	$_page->cmd = "home";	}


?>