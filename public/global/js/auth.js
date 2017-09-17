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

/** eCampConfig

	<depend on="public/global/js/mootools-core-1.4.js" type="js" /> <depend on="public/global/js/mootools-more-1.4.js" type="js" />

**/

var auth_class = new Class({
	level: 0,
	
	initialize: function( level )
	{
		this.level = level;
	},
	
	access: function( min_level )
	{	return this.level >= min_level;	}
});

if( !$_var_from_php.auth_level )
{	$_var_from_php.auth_level = 0;	}

var auth = new auth_class( $_var_from_php.auth_level );