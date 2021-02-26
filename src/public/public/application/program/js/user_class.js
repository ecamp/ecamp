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

var user_class = new Class({
	initialize: function(id, scoutname, firstname, surname)
	{
		this.id = id;
		this.scoutname = scoutname;
		this.firstname = firstname;
		this.surname = surname;
	},
	
	update: function( id, scoutname, firstname, surname )
	{
		this.id = id;
		this.scoutname = scoutname;
		this.firstname = firstname;
		this.surname = surname;
	},
	
	get_name: function()
	{
		if(this.scoutname == "")
		{	return this.firstname + " " + this.surname;	}
		else
		{	return this.scoutname;		}
	}
});