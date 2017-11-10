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

 	var day_width = 150;
	var time_shift = 300;
	var update_time = 5000; //msec
	
	
	event_cm_struct = 
	[
		{ "id": "edit_event", 	"img": "public/application/program/img/dp.png", 	"text": "Block editieren",	"click": function(){	$event.edit( this.event.id );	}, "min_level": 0, 	"content": [] },
		{ "id": "edit",			"img": "public/application/program/img/edit.png",	"text": "Bearbeiten",		"click": $empty, "min_level": 40, 	"content":
		[
			{ "id":	"change_name",	"img":	"public/application/program/img/rename.png", 	"text": "Namen ändern",		"click": function(){	this.event.save_change_name();	}, "min_level": 40, 				"content": [] },
			{ "id":	"change_resp",	"img":	"public/application/program/img/resp.png", 		"text": "Verant. ändern",	"click": function(){	this.event.save_change_responsible_user();	}, "min_level": 40, 	"content": [] },
			{ "id":	"change_type",	"img":	"public/application/program/img/type.png", 		"text": "Type ändern",		"click": function(){	this.event.save_change_category();	}, "min_level": 40, 			"content": [] }
		]},
		{ "id": "option",		"img": "public/application/program/img/option.png",	"text": "Optionen", 		"click": $empty, "min_level": 40, 	"content":
		[
			//	{ "id":	"event_split",	"img":	"public/application/program/img/split.png", 	"text": "Block spliten",	"click": function(){	this.save_copy_event_instance();	}, "min_level": 40,	"content": [] },
			//	{ "id":	"event_copy",	"img":	"public/application/program/img/copy.png",	 	"text": "Block kopieren",	"click": function(){	this.save_copy_event();	}, "min_level": 40, 			"content": [] },
			{ "id":	"event_copy",	"img":	"public/application/program/img/copy.png",	 	"text": "Block kopieren",	"click": function(){	this.copy_dialog();	}, "min_level": 40, 			"content": [] },
			{ "id":	"event_del",	"img":	"public/application/program/img/del.png", 		"text": "Block löschen",	"click": function(){	this.save_remove();	}, "min_level": 40, 				"content": [] }
		]}//,
		//{ "id": "print_event",	"img": "public/application/program/img/print.png",	"text": "Drucken", 			"click": $empty, "min_level": 100, 	"content":[] }
	];
	
	day_cm_struct = 
	[
		{ "id": "new_event", 	"img": "public/application/program/img/new.png", 	"text": "Neuer Block",		"click": function(){	this.save_add_event();	}, "min_level": 40, 	"content": [] },
		{ "id": "event_past", 	"img": "public/application/program/img/copy.png", 	"text": "Block einfügen",	"click": function(ee){	this.save_past_event(ee);	}, "min_level": 40, 	"content": [] },
		{ "id": "display",		"img": "public/application/program/img/option.png",	"text": "Darstellung",		"click": $empty, "min_level": 0, 	"content":
		[
			{ "id":	"show_type",		"img":	"public/application/program/img/type.png", 		"text": "Blocktype",	"click": function(){	$program.show_cat();		}, "min_level": 0, "content": [] },
			{ "id":	"show_progress",	"img":	"public/application/program/img/progress.gif", 	"text": "Fortschritt",	"click": function(){	$program.show_progress();	}, "min_level": 0, "content": [] }
		]}
	];
	
	
	document.oncontextmenu = function()	{	return	false; 	};
	
	
	
	window.addEvent('load', function()
	{
		
		$program.picasso_border = $('events');
		$program.picasso_scroll_div = $('g_program_scroll_div');
		$program.menu.event_cm 	= new menu_class( event_cm_struct );
		$program.menu.day_cm 	= new menu_class( day_cm_struct );
		
		$program.get_update();
		$program.get_update.periodical(update_time, $program);	//clearInterval();
		
		
		
		$('program_update_button').addEvent( 'click', function( event )
		{
			new Event( event ).stop();
			if( $program.is_shown == "cat" )	{	$program.show_progress();	}
			else								{	$program.show_cat();		}
		});
		
		
		
		$program.picasso_border_scroller = new Fx.Scroll( 'g_program_div'  );
		$program.picasso_scroll_div.addEvent( 'mousewheel', function(e)
		{
			e = new Event(e).stop();
			x = $('g_program_div').getScroll().x.toInt();
			$program.picasso_border_scroller.set(x - e.wheel * 25, 0);
		});
		
		
		$event.update_background = $program.get_update.bind( $program );
		
		
		// if Firefox, Grobprogramm-Verzerrung vermeiden
		if( Browser.Engine.gecko & Browser.Engine.version == 19 )
		{
			$('g_program_div').setStyle("padding-bottom", $('g_program_outer_div').clientHeight - $('g_program_div').clientHeight );
		}
		
	});
	
	window.addEvent( 'resize', function()
	{	if( $event.id == 0 )
		{	window.location.reload();	}
	});
	
	window.addEvent( 'keydown', function( key )
	{
		if( key.key == "space" && $event.id == 0 && $popup.actuall_popup == $empty )
		{
			if( $program.is_shown == "cat" )	{	$program.show_progress();	}
			else								{	$program.show_cat();		}
		}
	});