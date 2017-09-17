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
				"home" => 20,
				'action_add_mat_list' => 50,
				'action_change_mat_list' => 50,
				'action_del_mat_list' => 50,
			    'action_generate_xls' => 20,
			    'action_change_organized' => 20
				);

$css = array(
				"content_template_fit.css" => "global",
				"main.css" 					=> "app",
			);

$js  = array(
				"mootools-core-1.4.js" 		=> "global",
				"mootools-more-1.4.js" 		=> "global",
				"popup.js"					=> "global",
				"home.js" 					=> "app"
			);

# Standardkommando
if( $_page->cmd == "" ) {	$_page->cmd = "home";	}


?>