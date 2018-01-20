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

	if( $_camp->type>0 && $_camp->type<=4 ){
		/* Verknüpfungen zur aktuellen Checkliste wechseln */
		$query = "DELETE event_checklist.* FROM event_checklist INNER JOIN event ON event.id=event_checklist.event_id WHERE event.camp_id=".$_camp->id;
		mysqli_query($GLOBALS["___mysqli_ston"], $query);
		
		$query = "UPDATE camp SET type=".($_camp->type+10)." WHERE id=".$_camp->id." LIMIT 1";
		mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	}
	header("Location: index.php?app=course_checklist");
	die();
