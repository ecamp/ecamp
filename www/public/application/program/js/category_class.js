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

var category_class = new Class({
	initialize: function( id, name, short, count, color )
	{
		this.id 		= id;
		this.name		= name;
		this.c_name		= "cat" + id;
		this.short		= ( short == "" ) ? "" : short + ": ";
		this.count		= count.toInt();
		this.color		= '#' + color;
		this.numbering 	= "num";
	},
	
	update: function( id, name, short, count, color )
	{
		this.id 	= id;
		this.name	= name;
		this.c_name	= "cat" + id;
		this.short	= ( short == "" ) ? "" : short + ": ";
		this.count	= count.toInt();
		this.color	= '#' + color;
	},
	
	get_numbering: function( num )
	{
		if( this.numbering == "roman_small" )
		{	return dectorom( num ).toLowerCase();	}
		
		if( this.numbering == "roman_big" )
		{	return dectorom( num ).toUpperCase();	}
		
		if( this.numbering == "alpha_small" )
		{	return String.fromCharCode( 64 + num ).toLowerCase();	}
		
		if( this.numbering == "alpha_big" )
		{	return String.fromCharCode( 64 + num ).toUpperCase();	}
		
		if( this.numbering == "num" )
		{	return num;	}
	}
});
