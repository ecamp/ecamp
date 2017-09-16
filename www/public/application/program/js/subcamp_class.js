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

var subcamp_class = new Class({
	initialize: function( id, subcamp_nr, length, camp_id )
	{
		this.id = id;
		this.subcamp_nr = subcamp_nr;
		this.length = length;
		this.camp_id = camp_id;
		
		
		this.day = new Hash();
		this.offset = new Hash();
	},
	
	update: function( id, subcamp_nr, length, camp_id )
	{
		this.id = id;
		this.subcamp_nr = subcamp_nr;
		this.length = length;
		this.camp_id = camp_id;
	},
	
	add_day: function( day )
	{
		this.day.include( day.id, day );
		this.offset.include( day.day_nr, day );
	},
	
	remove_day: function( day )
	{
		this.day.erase( day.id );
		this.offset.erase( day.day_nr );
	}
		
});