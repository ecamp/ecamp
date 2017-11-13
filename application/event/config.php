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
							'home' => 20,
							'action_change_resp' => 40,
							'action_change_progress' => 40,
							'action_change_place' => 40,
							'action_change_aim' => 40,
							'action_change_story' => 40,
							'action_change_method' => 40,
							'action_change_detail' => 40,
							'action_delete_detail' => 40,
							'action_add_detail' => 40,
							'action_change_siko' => 40,
							'action_change_notes' => 40,
							'action_change_topics' => 40,
							'action_move_detail' => 40,
							
							'action_add_comment' => 20,
							'action_del_comment' => 20,
							
							'action_change_mat_buy' => 40,
							'action_change_mat_stocked' => 40,
							'action_change_mat_nonstocked' => 40,
							
							'action_change_mat_available' => 40,
							'action_change_mat_organize' => 40,
							
							'action_change_course_aim' => 40,
							'action_change_course_checklist' => 40,
							
							'file_download' => 20,
							'file_upload_form' => 40,
							'file_upload_done' => 40,
							'action_file_upload' => 40,
							'action_file_delete' => 40,
							'action_file_print' => 40
						);

$css = array(
				"d_program.css"				=> "app"
			);

$js  = array(
			);

# Standardkommando
if( $_page->cmd == "" ) {	$_page->cmd = "home";	}
?>