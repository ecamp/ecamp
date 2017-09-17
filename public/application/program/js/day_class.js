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

var day_class = new Class({
	initialize: function( id, subcamp_id, date, day_nr, day_offset, global_subcamp_offset )
	{
		this.id 					= id;
		this.subcamp_id				= subcamp_id;
		this.date 					= date;
		this.day_nr 				= day_nr;
		this.day_offset				= day_offset;
		this.global_subcamp_offset 	= global_subcamp_offset || 0;
		
		this.event_instance 	= new Array();

		this.subcamp = $program.subcamp.get( this.subcamp_id );
		this.subcamp.add_day( this );
		
		if( this.subcamp.subcamp_nr <= 1 )
		{	this.global_day_offset = this.day_offset.toInt();	}
		else
		{	this.global_day_offset = this.global_subcamp_offset.toInt() + this.day_offset.toInt();	}

		this.day_div			= $( 'day_id_' + this.id );
		this.day_body_div		= this.day_div.getElement('.day_body');
		this.left_offset		= this.global_day_offset * day_width; //this.day_div.getStyle('left').toInt();
		
		this.day_div.addEvent('contextmenu', function(e)	{	ee = new Event(e).stop();	this.menu(ee);	}.bind(this) );
		this.day_body_div.addEvent('mousedown', function(e)	{	ee = new Event(e).stop();	this.new_event_size(ee);	}.bind(this) );

		//	var args = new Hash({ "app": "program", "cmd": "action_change_resp_main_job" });
		//	new DI_SELECT( this.day_div.getElement('.select_main_job_resp'), { 'args': args } );
		if( $_var_from_php.EnableMainJobResp )
		{	new DI_SELECT( this.day_div.getElement( '.select_main_job_resp' ), { args: { 'app': 'program', 'cmd':'save_main_job', 'day_id': this.id }, 'min_level':40 } );	}
		else
		{	this.day_div.getElement( '.select_main_job_resp' ).set( 'disabled', 'disabled' );	}
		
		this.display();
	},
	
	update: function( id, subcamp_id, date, day_nr, day_offset, global_subcamp_offset )
	{
		this.id 					= id;
		this.subcamp_id				= subcamp_id;
		this.date 					= date;
		this.day_nr 				= day_nr;
		this.day_offset				= day_offset;
		this.global_subcamp_offset 	= global_subcamp_offset || 0;
		
		this.display();
	},
	
	show: function()
	{
		this.day_div.removeClass( 'hidden' );
		this.display();
		
		this.event_instance.each( function( event_instance )
		{	event_instance.show();	});
	},
	
	hide: function()
	{
		this.day_div.addClass( 'hidden' );
		
		this.event_instance.each( function( event_instance )
		{	event_instance.hide();	});
	},
	
	display: function()
	{
		this.day_div.setStyles({
									'position': 'absolute', 
									'left': this.left_offset + 'px', 
									'width': day_width + 'px', 
									'top': '0px', 
									'height': '100%',
									'z-index': '1'
								});
	},
	
	new_event_size: function(ee)
	{
		if( !auth.access( 40 ) )
		{	return;	}

		dy = this.day_body_div.getPosition().y;
		sy = ee.page.y;
		
		var top = (( sy - dy ) / ( this.day_body_div.getSize().y / ( 24 * 4 ) )).round() * ( this.day_body_div.getSize().y / ( 24 * 4 ) ) ;
		
		b = new Element('div').setStyles({ 'position': 'absolute', 'top': top , 'left': '0px', 'right': '0px', 'border': '1px dashed white' }).inject( this.day_body_div );
		s = new Element('div').setStyles({ 'position': 'absolute', 'top': '0px', 'left': '0px', 'bottom': '0px', 'right': '0px', 'background-color': '#dddddd' }).inject(b);
		b.addClass( 'new_event_size' );
		s.setStyle( 'opacity', 0.3 ).setStyle( 'z-index', 5000 ).setStyle('text-align', 'center');
		
		this.day_div.addEvent('mousemove', function(e)
		{
			height = Math.abs((( e.page.y - sy ) / ( this.day_body_div.getSize().y / ( 24 * 4 ) )).round() * ( this.day_body_div.getSize().y / ( 24 * 4 ) ) )  ;
			
			if( e.page.y > sy )	{	b.setStyles({ 'height': height - 2, 'top': top 				});	}
			else				{	b.setStyles({ 'height': height - 2, 'top': top - height	});	}
			
			start = 	$h.px2min( b.getPosition(this.day_body_div).y, 15, true );
			end = 		$h.px2min( b.getPosition(this.day_body_div).y + b.getSize().y, 15, true );
			
			start_h = ( start / 60 ).toInt();
			start_m = start - start_h * 60;
			
			end_h = ( end / 60 ).toInt();
			end_m = end - end_h * 60;
			
			if( start_h < 10 )	{ start_h = "0" + start_h;	}
			if( start_m < 10 )	{ start_m = "0" + start_m;	}
			if( end_h < 10 )	{ end_h = "0" + end_h;	}
			if( end_m < 10 )	{ end_m = "0" + end_m;	}
			
			s.set('html', start_h + ':' + start_m + " - " + end_h + ":" + end_m);
		}.bind(this) );

		this.day_div.addEvent('mouseup', function(e)
		{	
			var start = 	$h.px2min( b.getPosition(this.day_body_div).y, 15, true );
			var length = 	$h.px2min( b.getSize().y, 15 );
			
			if( length > 0)	{	this.save_add_event( start, length );	}
			
			this.day_div.removeEvents('mousemove');
			this.day_div.removeEvents('mouseup');
			
			$$('.new_event_size').destroy();
			
		}.bind(this) );
		this.day_div.addEvent('mouseleave', function(e)
		{
			this.day_div.removeEvents('mousemove');
			this.day_div.removeEvents('mouseup');
			
			$$('.new_event_size').destroy();
		}.bind(this) );
	},
	
	menu: function(ee)
	{
		dy = this.day_body_div.getPosition().y;
		sy = ee.page.y;
		
		var top = (( sy - dy ) / ( this.day_body_div.getSize().y / ( 24 * 4 ) )).round() * ( this.day_body_div.getSize().y / ( 24 * 4 ) ) ;
		this.new_event_start_time = $h.px2min( top, 15, true );
		
		$program.menu.day_cm.show( ee, this );
	},
	
	add_event_instance: function( event_instance )
	{	
		this.event_instance.include( event_instance );
		this.renummber_event_instances();
	},
	
	remove_event_instance: function( event_instance )
	{
		this.event_instance.erase( event_instance );
		this.renummber_event_instances();
	},
	
	renummber_event_instances: function()
	{
		count = 1;
		zindex = 1;
		this.event_instance.sort( function(a, b)
			{
				if(a.time == b.time) 
				{	
					if(a.left == b.left)
					{   return a.id - b.id; } 
					else
					{	return a.left - b.left	}
				}
				else 
				{	return a.time - b.time; }	
			}).each( function(item)
				{
					if(item.event.category.count)
					{
						item.nr_div.set('html', "(" + ( this.global_subcamp_offset.toInt() + this.day_nr.toInt() ) + "." + item.event.category.get_numbering( count ) + ") ");
						count = count + item.event.category.count;
					}
					else
					{	item.nr_div.set('html', "");	}
					
					item.update_zindex( zindex );
					zindex = zindex + 1;
				}.bind(this) );
	},
	
	save_add_event: function( start, length )
	{
		if( !$defined(start) )	{	start = this.new_event_start_time;	}
		start_h = ( start / 60 ).toInt();
		start_m = ( start - 60 * start_h );
		
		if( !$defined(length) )	{	length = 120;	}
		length_h = ( length / 60 ).toInt();
		length_m = ( length - 60 * length_h );
		
		popup_input_cat = new Element('select').setStyles({'position': 'absolute', 'left': '270px', 'top': '55px', 'width': '200px', 'font-size': '11px'});
		$program.category.each(	function(item)	{	new Element('option').set('html', escapeHTML(item.short + item.name)).set('value', item.id).inject(popup_input_cat);	}.bind(this) );
		
		popup_input_start_h = new Element('select').setStyles({'position': 'absolute', 'left': '270px', 'top': '80px', 'width': '50px',  'font-size': '11px'});
		(24).times(function(h){	new Element('option').set('html', h).set('value', h).inject(popup_input_start_h);	});
		popup_input_start_h.set( 'value', start_h );
		
		popup_input_start_min = new Element('select').setStyles({'position': 'absolute', 'left': '330px', 'top': '80px', 'width': '50px',  'font-size': '11px'});
		(4).times(function(h){	new Element('option').set('html', (15 * h)).set('value', (15*h) ).inject(popup_input_start_min);	});
		popup_input_start_min.set( 'value', start_m );
		
		popup_input_length_h = new Element('select').setStyles({'position': 'absolute', 'left': '270px', 'top': '105px', 'width': '50px',  'font-size': '11px'});
		(24).times(function(h){	new Element('option').set('html', h).set('value', h).inject(popup_input_length_h);	});
		popup_input_length_h.set( 'value', length_h );
		
		popup_input_length_min = new Element('select').setStyles({'position': 'absolute', 'left': '330px', 'top': '105px', 'width': '50px',  'font-size': '11px'});
		(4).times(function(h){	new Element('option').set('html', (15 * h)).set('value', (15*h) ).inject(popup_input_length_min);	});
		popup_input_length_min.set( 'value', length_m );
		
		resp_user = new Element('ul');
		user_pool = new Element('ul');
		
		$program.user.each(function(user)
		{	new Element('li').inject(user_pool).set('html', escapeHTML(user.get_name()) ).set('id', user.id).setStyles( {'cursor': 'move', 'display': 'inline', 'margin': '2px'} );	} );
		
		new Sortables([resp_user, user_pool], { 'clone': true } );

		var content = {
			'popup_image': new Element('img').setStyles({'position': 'absolute', 'left': '25px', 'top': '35px', 	'width': '100px', 'height': '100px'}).set('src', 'public/global/img/question.png'),
			'popup_div_name': new Element('div').setStyles({'position': 'absolute', 'left': '150px', 'top': '30px', 'width': '150px',  'font-size': '11px'}).set('html', "Blockname:"),
			'popup_input_name': new Element('input').setStyles({'position': 'absolute', 'left': '270px', 'top': '30px', 'width': '200px',  'font-size': '11px'}).set('type', 'text').set('value', this.name),
			'popup_div_cat': new Element('div').setStyles({'position': 'absolute', 'left': '150px', 'top': '55px', 'width': '150px',  'font-size': '11px'}).set('html', "Kategorie:"),
			'popup_input_cat': popup_input_cat,
			'popup_div_start_h':  new Element('div').setStyles({'position': 'absolute', 'left': '150px', 'top': '80px', 'width': '150px',  'font-size': '11px'}).set('html', "Startzeit: (h:min)"),
			'popup_input_start_h': popup_input_start_h,
			'popup_input_start_min': popup_input_start_min,
			'popup_div_length_h':  new Element('div').setStyles({'position': 'absolute', 'left': '150px', 'top': '105px', 'width': '150px',  'font-size': '11px'}).set('html', "Zeitdauer: (h:min)"),
			'popup_input_length_h': popup_input_length_h,
			'popup_input_length_min': popup_input_length_min,
					
			'popup_div_user_pool': new Element('div').setStyles({'position': 'absolute', 'left': '150px', 'top': '130px', 'width': '150px',  'font-size': '11px'}).set('html', "Leiter:"),
			'popup_div_resp_user': new Element('div').setStyles({'position': 'absolute', 'left': '150px', 'top': '185px', 'width': '150px',  'font-size': '11px'}).set('html', "Verantwortliche:"),
					
			'popup_user_pool': user_pool.setStyles({'position': 'absolute', 'left': '270px', 'top': '130px', 'width': '200px', 'height': '50px', 'font-size': '11px', 'list-style-type': 'none', 'border': '1px solid black'}),
			'popup_resp_user': resp_user.setStyles({'position': 'absolute', 'left': '270px', 'top': '185px', 'width': '200px', 'height': '50px', 'font-size': '11px', 'list-style-type': 'none', 'border': '1px solid black'}),
					
			'popup_save_button': new Element('input').setStyles({'position': 'absolute', 'right': '180px', 'bottom': '10px', 'width': '100px'}).set('type', 'button').set('value', 'Sichern'),
			'popup_abort_button': new Element('input').setStyles({'position': 'absolute', 'right': '50px', 'bottom': '10px', 'width': '100px'}).set('type', 'button').set('value', 'Abbrechen')
		};
		var events 	= { 
			'popup_abort_button': 	function(){	$popup.hide_popup();	},
			'popup_save_button': 	function(){
				resp_user = "";
				$$('#popup_resp_user li').each(function(item){	resp_user = resp_user + item.id + "_";	});
							
				args = new Hash({
					"day_id":		this.id,
					"name": 		$('popup_input_name').get('value'),
					"category":		$('popup_input_cat').get('value'),
					"starttime_h":	$('popup_input_start_h').get('value'),
					"starttime_min":$('popup_input_start_min').get('value'),
					"length_h":		$('popup_input_length_h').get('value'),
					"length_min":	$('popup_input_length_min').get('value'),
					"resp_user":	resp_user,
					"time":			$program.last_update_time
				});
				load_url = "index.php?app=program&cmd=save_add_event&" + args.toQueryString();
							
				$popup.hide_popup();
							
				new Request.JSON({
					url: load_url,
					onComplete: $program.run_update.bind($program)
				}).send();
			}.bind(this)
		};
		
		keyevents = {	"enter": events['popup_save_button'], "esc": events['popup_abort_button'] };
		
		fokus	= 'popup_input_name';
		lock	= true;
		width	= 500;
		height	= 280;
		
		$popup.popup_HTML( "Neuer Block:", content, events, keyevents, lock, width, height );
		content['popup_input_name'].focus();
	},
	
	save_past_event: function( event )
	{
		var dy = this.day_body_div.getPosition().y;
		var sy = event.page.y;
		
		var top = (( sy - dy ) / ( this.day_body_div.getSize().y / ( 24 * 4 ) )).round() * ( this.day_body_div.getSize().y / ( 24 * 4 ) ) ;
		var start = $h.px2min( top, 15, true );
		
		args = new Hash(
		{
			"day_id":	this.id,
			"start": 	start,
			"app":		"program",
			"cmd":		"save_past_event",
			"time":		$program.last_update_time
		});
		load_url = "index.php?" + args.toQueryString();

		new Request.JSON({
			url: load_url,
			onComplete: function( ans )
			{	$program.run_update( ans );	}
		}).send();
	}
});