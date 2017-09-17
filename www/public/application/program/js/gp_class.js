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

var $h = new Hash(
{
	px2min: function( px, gird, ts )
	{
		gird = gird || 1;
		ts = ts || false;
		
		border_h = $program.picasso_border.getSize().y;
		
		gird_size = border_h / ( 24 * 60 / gird );
		gird_field = ( px / gird_size ).round();
		
		minute = gird_field * gird;
		
		if( ts )
		{
			minute = minute + time_shift;
			minute = minute % (24 * 60);
		}
		
		return minute;
	},
	
	min2px: function( minute, gird, ts )
	{
		gird = gird || 1;
		ts = ts || false;
		
		max_min = 24*60;
		gird_field = ( minute / gird ).round();
		
		minute = gird_field * gird;
		
		if( ts )
		{
			minute = minute - time_shift + 24*60;
			minute = minute % (24 * 60);
		}
		
		border_h = $program.picasso_border.getSize().y;
		
		return border_h / ( 24*60 ) * minute;
	}
});

var $program = new Hash(
{
	user: 			new Hash(),
	category: 		new Hash(),
	subcamp:		new Hash(),
	day: 			new Hash(),
	event: 			new Hash(),
	event_instance:	new Hash(),
	menu:			new Hash(),

	last_update_time: 0,
	picasso_border: $empty,
	picasso_scroll_div: $empty,
	is_shown: "cat",
	
	show_cat: function()
	{	
		this.is_shown = "cat";
		this.event_instance.each(function(item)	{	item.display();	}	);
	},
	
	show_progress: function()
	{
		this.is_shown = "progress";
		this.event_instance.each(function(item)	{	item.display();	}	);
	},
	
	add_user: function( id, scoutname, firstname, surname )
	{	this.user.include( id, new user_class( id, scoutname, firstname, surname ) );	},
	
	add_category: function( id, name, short, count, color )
	{	this.category.include( id, new category_class( id, name, short, count, color ) );	},
	
	add_subcamp: function( id, subcamp_nr, length, camp_id )
	{	this.subcamp.include( id, new subcamp_class( id, subcamp_nr, length, camp_id )	);	},
	
	add_day: function( id, subcamp_id, date, day_nr, day_offset, global_subcamp_offset )
	{	this.day.include( id, new day_class( id, subcamp_id, date, day_nr, day_offset, global_subcamp_offset )	);	},
	
	add_event: function( id, name, category, prog, in_edition_by, in_edition_time, responsible )
	{	this.event.include( id, new event_class( id, name, category, prog, in_edition_by, in_edition_time, responsible ) );		},
	
	add_event_instance: function( id, event_id, day_id, starttime, length, dleft, width )
	{	this.event_instance.include( id, new event_instance_class( id, event_id, day_id, starttime, length, dleft, width ) );	},

	update_user: function( id, scoutname, firstname, surname )
	{
		if( this.user.has( id ) )
		{	this.user.get( id ).update( id, scoutname, firstname, surname );	}
		else
		{	this.add_user( id, scoutname, firstname, surname );	}
	},
	
	update_category: function( id, name, short, count, color )
	{
		if( this.category.has( id ) )
		{	this.category.get( id ).update( id, name, short, count, color );	}
		else
		{	this.add_category( id, name, short, count, color );	}
	},
	
	update_subcamp: function( id, subcamp_nr, length, camp_id )
	{
		if( this.subcamp.has( id ) )
		{	this.subcamp.get( id ).update( id, subcamp_nr, length, camp_id );	}
		else
		{	this.add_subcamp( id, subcamp_nr, length, camp_id );	}
	},
	
	update_day: function( id, subcamp_id, date, day_nr, day_offset, global_subcamp_offset )
	{
		if( this.day.has( id ) )
		{	this.day.get( id ).update( id, subcamp_id, date, day_nr, day_offset, global_subcamp_offset );	}
		else
		{	this.add_day( id, subcamp_id, date, day_nr, day_offset, global_subcamp_offset );	}
	},
	
	update_event: function( id, name, category, prog, in_edition_by, in_edition_time, responsible )
	{
		if( this.event.has( id ) )
		{	this.event.get( id ).update( id, name, category, prog, in_edition_by, in_edition_time, responsible );	}
		else
		{	this.add_event( id, name, category, prog, in_edition_by, in_edition_time, responsible );	}
	},
	
	update_event_instance: function ( id, event_id, day_id, starttime, length, dleft, width )
	{
		if( this.event_instance.has( id ) )
		{	this.event_instance.get( id ).update( id, event_id, day_id, starttime, length, dleft, width );	}
		else
		{	this.add_event_instance( id, event_id, day_id, starttime, length, dleft, width );	}
	},
	
	remove_user: 			function( id ){	this.user.erase( id );				},
	remove_category:		function( id ){	this.category.erase( id );			},
	remove_subcamp:			function( id ){	this.subcamp.erase( id );			},
	remove_day:				function( id ){	this.day.erase( id );				},
	remove_event:			function( id ){	this.event.erase( id );				},
	remove_event_instance:	function( id ){	this.event_instance.get( id ).remove();	},
	
	clear_all: function()
	{
		this.event_instance.each( function( item ){	item.remove();	} );
		
		this.user.empty();
		this.category.empty();
		this.day.empty();
		this.event.empty();
		this.event_instance.empty();
	},
	
	get_update:	function()
	{
		//alert( "get_update" );
		args = new Hash(
		{
			"app":  "program",
			"cmd":  "load_gp_data",
			"time": this.last_update_time
		});
		
		load_url = "index.php?" + args.toQueryString();
		new Request.JSON(
		{
			url: load_url, 
			secure: false,
			async: true,
			onComplete: function(loads)
			{
				this.run_update( loads );
			}.bind(this)
		}).send();
	},
	
	run_update: function( update )
	{
		if( update.users )
		{
			update.users.each(function( user )
			{	this.update_user( user.id, user.scoutname, user.firstname, user.surname );	}.bind(this) );
		}
		
		if( update.categorys )
		{
			update.categorys.each(function( category )
			{	this.update_category( category.id, category.name, category.short_name, category.count, category.color );	}.bind(this) );
		}
		
		if( update.subcamps )
		{
			update.subcamps.each(function( subcamp )
			{	this.update_subcamp( subcamp.id, subcamp.subcamp_nr, subcamp.length, subcamp.camp_id );	}.bind(this) );
		}
		
		if( update.days )
		{
			update.days.each(function( day )
			{	this.update_day( day.id, day.subcamp_id, day.date, day.day_nr, day.day_offset, day.global_subcamp_offset );	}.bind(this) );
		}
		
		if( update.events )
		{
			update.events.each(function( event )
			{	this.update_event( event.id, event.name, event.category_id, event.progress, event.in_edition_by, event.in_edition_time, event.users );	}.bind(this) );
		}
		
		if( update.event_instances )
		{
			update.event_instances.each(function( event_instance )
			{	this.update_event_instance( event_instance.id, event_instance.event_id, event_instance.day_id, event_instance.starttime, event_instance.length, event_instance.dleft, event_instance.width );	}.bind(this) );
		}
		
		if( update.del )
		{
			update.del.each(function( item )
			{
				if( item.type == "event" )			{	$program.remove_event( item.id );	}
				if( item.type == "event_instance" )	{	$program.remove_event_instance( item.id );	}
			});
		}
		
		if( update.days )
		{
			update.days.each(function( day )
			{	$program.day.get( day.id ).renummber_event_instances();	}.bind(this) );
		}

		this.last_update_time = update.time;
	}
});	