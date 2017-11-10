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

var event_instance_class = new Class({
	initialize: function( id, event, day, time, length, left, width )
	{
		this.id 	= id.toInt();
		this.event 	= event;
		this.day	= day;
		this.time 	= time.toInt();
		this.length	= length.toInt();
		this.left	= left.toFloat();
		this.width	= width.toFloat();
		this.scroll_left = 0;
		this.waiting = false;
		this.zindex	= 1;
		
		if( $type(this.event) == "number" || $type(this.event) == "string" )	{	this.event	= $program.event.get( this.event.toInt() );	}
		if( $type( this.day ) == "number" || $type( this.day ) == "string" )	{	this.day	= $program.day.get( this.day.toInt() );		}
		
		
		
		this.frame_div	= new Element('div').setStyle( 'position', 'absolute');
		this.frame_div_fx = new Fx.Elements( this.frame_div, { duration: 500 } );
		
		this.border_div	= new Element('div').inject(this.frame_div).setStyles( { 'position': 'absolute', 'left': '0px', 'right': '0px', 'top': '0px', 'bottom': '0px', 'border': '1px solid black', 'text-align': 'center', 'overflow': 'hidden', 'opacity': '0.7' } );
		this.border_div.setStyles( { '-moz-border-radius': '5px', '-khtml-border-radius': '5px', 'cursor': 'move', 'padding': '0px', 'margin': '1px' } );
		this.border_div_fx = new Fx.Elements( this.border_div, { duration: 300 } );
		
		this.nr_div		= new Element('div').inject(this.border_div).setStyle('display', 'inline');
		this.cat_div	= new Element('div').inject(this.border_div).setStyle('display', 'inline');
		this.name_div	= new Element('div').inject(this.border_div).setStyle('display', 'inline');
		this.resp_div	= new Element('div').inject(this.border_div).setStyle('font-size', '9px');
		this.wait_div	= new Element('div').inject(this.border_div).setStyles({'position': 'absolute', 'left': '0px', 'right': '0px', 'top': '0px', 'bottom': '0px', 'background-position': 'center', 'background-repeat': 'no-repeat', 'background-image': 'url(public/application/program/img/wait.gif)'}).addClass('hidden');
		this.lock_div	= new Element('div').inject(this.border_div).setStyles({'position': 'absolute', 'left': '0px', 'right': '0px', 'top': '0px', 'bottom': '0px', 'background-position': 'center', 'background-repeat': 'no-repeat', 'background-image': 'url(public/application/program/img/lock.png)'}).addClass('hidden');
		this.zoom_div	= new Element('img').inject(this.border_div).setStyles({'position': 'absolute', 'right': '0px', 'bottom': '0px', 'width': '10px', 'height': '10px', 'cursor': 'se-resize'}).set('src', 'public/application/program/img/ecke.gif');
		
		this.border_div.addEvent('mouseover', 	function()
		{
			this.event.highlight();
			this.border_div.setStyle( 'z-index', '200' );
		}.bind(this) );
		
		this.border_div.addEvent('mouseout', function(){	this.event.lowlight();	}.bind(this) );
		
		this.lock_div.addEvent('click', function(){	this.event.save_force_unlock()	}.bind(this) );
		
		if( auth.access( 40 ) )
		{
			this.drag_handle = this.frame_div.makeDraggable( 
					{ 
						onComplete: function(div)
							{	this.save_move( div.getStyle('left'), div.getStyle('top') );	}.bind(this),
						onDrag: function(div)
							{
								this.highlight();
								this.border_div.setStyle( 'z-index', '102' );
								
								div.setStyle('left', day_width / 10 * (div.getStyle('left').toInt() / (day_width / 10 ) ).round() );
								if( (div.getStyle('left').toInt() / day_width).toInt() < ( ( div.getStyle('left').toInt() + div.getStyle('width').toInt() - 1  ) / day_width ).toInt() )
								{
									if( ( div.getStyle('left').toInt() + div.getStyle('width').toInt() / 2 ) % day_width > day_width / 2 )
									{	div.setStyle('left', day_width * ( 1 + div.getStyle('left').toInt() / day_width ).toInt() - div.getStyle('width').toInt() );	}
									else
									{	div.setStyle('left', day_width * (div.getStyle('left').toInt() / day_width ).round() );	}
								}
								
								div.setStyle('top', $program.picasso_border.getSize().y / (24 * 4) * ( div.getStyle('top').toInt() / ( $program.picasso_border.getSize().y / (24 * 4) ) ).round() );
							}.bind(this),
						onStart: function()
							{	if(this.event.waiting || this.event.locked || this.waiting)	{	this.drag_handle.stop();	}	}.bind(this),
						container: $program.picasso_border
					});
			
			this.zoom_handle = this.frame_div.makeResizable(
					{ 
						onComplete: function(div)
							{	this.save_zoom( div.getStyle('width'), div.getStyle('height') ); }.bind(this),
						onDrag: function(div)
							{	
								div.setStyle('width', (day_width / 10 * (div.getStyle('width').toInt() / (day_width / 10 ) ).round() ).limit(0.3 * day_width, day_width) );
								if( day_width - ( div.getStyle('left').toInt() % day_width ) < div.getStyle('width').toInt() )
								{	div.setStyle('width', day_width - ( div.getStyle('left').toInt() % day_width ) );	}
								
								div.setStyle('height', $program.picasso_border.getSize().y / (24 * 4) * ( div.getStyle('height').toInt() / ( $program.picasso_border.getSize().y / (24 * 4) ) ).round().limit(1, 24*24) );
								if( $program.picasso_border.getSize().y - div.getStyle('top').toInt() < div.getStyle('height').toInt() )
								{	div.setStyle('height', $program.picasso_border.getSize().y - div.getStyle('top').toInt() );	}
							}.bind(this),
						onStart: function()
							{	if(this.event.waiting || this.event.locked || this.waiting){	this.zoom_handle.stop();	}	}.bind(this),
						handle: this.zoom_div
					});
		}
		
		this.zoom_div.addEvent(	'mousedown',	function(e){	new Event(e).stop(); 	});
		this.frame_div.addEvent('contextmenu',	function(e){	ee = new Event(e).stop();	this.menu(ee);	return false;	}.bind(this) );
		
		this.frame_div.addEvent( 'dblclick', function()
		{
			$event.edit(this.event.id);
			this.event.lowlight();
		}.bind(this) );
		
		this.event.add_event_instance(this);
		this.day.add_event_instance(this);
		
		this.frame_div.inject($program.picasso_border);
		
		if( this.event.in_edition_by != 0 )	{	this.lock_div.removeClass('hidden');	this.event.locked = true;	}
		
		this.display();
	},
	
	update: function( id, event, day, time, length, left, width )
	{
		new_day = ( day != this.day.id );
		
		if( new_day )	{	this.day.remove_event_instance(this);	}
		
		this.id 	= id.toInt();
		this.event 	= event;
		this.day	= day;
		this.time 	= time.toInt();
		this.length	= length.toInt();
		this.left	= left.toFloat();
		this.width	= width.toFloat();
		
		if( $type(this.event) == "number" || $type(this.event) == "string" )	{	this.event	= $program.event.get( this.event.toInt() );	}
		if( $type( this.day ) == "number" || $type( this.day ) == "string" )	{	this.day	= $program.day.get( this.day.toInt() );		}
		
		if( new_day )	{	this.day.add_event_instance(this);	}
		
		this.display();
	},
	
	display: function()
	{
		//	Position:
		// ===========
		
			this.left	= this.left.limit( 0, 0.7 );
			this.time	= this.time.limit( 0, 24 * 60 + time_shift );
			this.width 	= this.width.limit( 0.3, 1 - this.left );
			this.length	= this.length.limit( 15, 24 * 60 - this.time + time_shift );
			
			s_left 	= this.day.left_offset + day_width * this.left + 'px';
			s_width	= day_width * this.width + 'px';
			
			s_top 	= $h.min2px( this.time, 15, true ) + 'px';
			s_height= $h.min2px( this.length, 15 ) + 'px';
			
			
			if( this.frame_div.getCoordinates().width == 0 && this.frame_div.getCoordinates().height == 0 )
			{
				this.frame_div.setStyles({
					'left': 	s_left,	 'top':		s_top,
					'width':	s_width, 'height':	s_height,
					'opacity': 0
				});
				this.frame_div_fx.start( { '0': { 'opacity': [0, 1] } } );
			}
			else
			{
				this.frame_div_fx.start(
				{	'0': {	'left': s_left,	 'top':		s_top,
							'width':s_width, 'height': 	s_height
				}		});
			}

		
		//	Display Text:
		// ===============
			resp_text = "[";
			this.event.responsible.each(function( user )
			{
				if( $type(user) )
				{
					if(resp_text != "[")	{	resp_text = resp_text + "; ";	}
					resp_text = resp_text + user.get_name();
				}
			});
			resp_text = resp_text + "]";
			if(resp_text == "[]")	{	resp_text = "";	}
			
			var name = escapeHTML( this.event.name);
			resp_text = escapeHTML(resp_text);
			
			this.cat_div.set(	'html', this.event.category.short );
			this.name_div.set( 	'html', name + " " );
			this.resp_div.set(	'html', resp_text );
		
		//	Color:
		// ========
			if( $program.is_shown == "cat" )
			{	this.border_div_fx.start( { '0': { 'background-color': this.event.category.color } } );	}
			else
			{	this.border_div_fx.start( { '0': { 'background-color': this.event.progress_color().rgbToHex() } } );	}
	},
	
	save_move: function( x, y )
	{
		this.wait();
		
		x = x.toInt();	y = y.toInt();
		
		day_offset = ( x / day_width ).toInt();
		$program.day.each(function(item, key){	if(item.global_day_offset == day_offset){	new_day = item;	} });
		
		start = $h.px2min( y, 15, true );
			
		args = new Hash(
		{
			"app":					"program",
			"cmd":					"save_move_event",
			"event_instance_id": 	this.id,
			"start": 				(start < time_shift ) ? start + 24*60 : start,
			"left": 				( ( x / day_width ) % 1 ).round(1),
			"day_id": 				new_day.id,
			"time":					$program.last_update_time
		});
		
		load_url = "index.php?" + args.toQueryString();
		
		new Request.JSON(
		{
			url: load_url, 
			onComplete: function(ans)
			{
				$program.run_update( ans );
				this.unwait();
			}.bind(this)
		}).send();
	},
	
	save_zoom: function( w, h )
	{
		this.wait()
		
		w = w.toInt();	h = h.toInt();
		
		args = new Hash(
		{
			"app":					"program",
			"cmd":					"save_zoom_event",
			"event_instance_id": 	this.id,
			"length": 				$h.px2min( h, 15, false ),
			"width": 				( w / day_width ).round(1),
			"time":					$program.last_update_time
		});
		
		load_url = "index.php?" + args.toQueryString();
		
		new Request.JSON(
		{
			url: load_url, 
			onComplete: function(ans)
			{
				$program.run_update( ans );
				this.unwait();
			}.bind(this)
		}).send();
	},
	
	move: function( time, left, nday )
	{
		nday 	= nday || this.day;
		left 	= left || this.left;
		
		if( $type(nday) == "number" || $type(nday) == "string" )	{	$program.day.each( function( item ){	if( item.day_nr == nday.toInt() ){	nday = item;	} }	);	}
		if( $type(nday) == "object" )								{	this.day.remove_event_instance(this);	nday.add_event_instance(this);	}
		
		this.time 	= time.limit( 0, 24 * 60 - this.length );
		this.day	= nday;
		this.left	= left.limit( 0, 1 - this.width );
		
		this.display();
	},
	
	zoom: function( length, width )
	{
		width 	= width || this.width;
		width 	= width.toFloat().round(1).limit( 0.3, 1 - this.left.round(1) );
		length	= length.limit( 15, 24 * 60 - this.time );
		
		this.length	= length;
		this.width	= width;
		
		this.display();
	},
	
	menu: function(ee)
	{
		$program.menu.event_cm.show( ee, this );
	},
	
	show: function()
	{
		this.frame_div.removeClass( 'hidden' );
		this.display();
	},
	
	hide: function()
	{
		this.frame_div.addClass( 'hidden' );
	},
	
	highlight: function()
	{
		
		this.border_div.setStyle('opacity', '1').setStyle( 'z-index', 100 + this.zindex );
		this.border_div.setStyles({'margin': '0px', 'border-width': '2px', 'border-color': 'black' });
		
		this.nr_div.setStyle('font-weight', 'bold');
		this.cat_div.setStyle('font-weight', 'bold');
		this.name_div.setStyle('font-weight', 'bold');
		this.resp_div.setStyle('font-weight', 'bold');
	},
	
	lowlight: function()
	{
		this.border_div.setStyle( 'opacity', '0.7').setStyle( 'z-index', this.zindex );
		this.border_div.setStyles({ 'margin': '1px', 'border-width': '1px', 'border-color': 'black' });
		
		this.nr_div.setStyle('font-weight', '');
		this.cat_div.setStyle('font-weight', '');
		this.name_div.setStyle('font-weight', '');
		this.resp_div.setStyle('font-weight', '');
	},
	
	update_zindex: function( zindex )
	{
		this.zindex = zindex;
		this.border_div.setStyle('z-index', this.zindex);
	},
	
	copy_dialog: function()
	{
		var content = {
					'popup_image': new Element('img').setStyles({'position': 'absolute', 'left': '25px', 'top': '35px', 	'width': '100px', 'height': '100px'}).set('src', 'public/global/img/question.png'),
					'popup_div_copy': new Element('button').setStyles({'position': 'absolute', 'left': '150px', 'top': '30px', 'width': '210px', 'height':'120px', 'font-size': '11px', 'text-align':'left'})
						.set('html', "<img src='public/application/program/img/copy.png' />&nbsp;&nbsp;<b>Block kopieren:</b><br /><br />Ein kopierter Block ist vollständig unabhängig vom Original. Die Kopie wird durch Rechtsklick über das Contextmenu an einer freien Stelle eingefügt."),
					'popup_div_split': new Element('button').setStyles({'position': 'absolute', 'left': '370px', 'top': '30px', 'width': '210px', 'height':'120px', 'font-size': '11px', 'text-align':'left'})
						.set('html', "<img src='public/application/program/img/split.png' />&nbsp;&nbsp;<b>Block spliten:</b><br /><br />Beim spliten wird der gleiche Block zu verschiedenen Zeiten durchgeführt. Der Blockinhalt ist bei allen Splitts der selbe, auch nach einer Überarbeitung."),
					
					
					
					//'popup_save_button': new Element('input').setStyles({'position': 'absolute', 'right': '180px', 'top': '130px', 'width': '100px'}).set('type', 'button').set('value', 'Sichern'),
					'popup_abort_button': new Element('input').setStyles({'position': 'absolute', 'right': '50px', 'top': '160px', 'width': '100px'}).set('type', 'button').set('value', 'Abbrechen')
					};
		var events 	= { 
					'popup_abort_button': 	function(){	$popup.hide_popup();	},
					'popup_div_copy': 	function()
						{
							this.save_copy_event();
							$popup.hide_popup();
						}.bind(this),
					'popup_div_split': 	function()
						{
							this.save_copy_event_instance();
							$popup.hide_popup();
						}.bind(this)
					};
					
		keyevents = {	"esc": events['popup_abort_button'] };
					
		fokus	= 'popup_div_copy';
		lock	= true;
		width	= 600;
		height	= 190;
		
		$popup.popup_HTML( "Block kopieren", content, events, keyevents, lock, width, height );
		
		content[fokus].focus();
	},
	
	save_copy_event_instance: function()
	{
		this.wait();
		
		args = new Hash(
		{
			"app":					"program",
			"cmd":					"copy_event_instance",
			"event_instance_id": 	this.id,
			"time":					$program.last_update_time
		});
		load_url = "index.php?" + args.toQueryString();
		
		new Request.JSON(
		{
			url: load_url, 
			onComplete: function(ans)
			{
				$program.run_update( ans );
				this.unwait();
			}.bind(this)
		}).send();
	},
	
	copy_event_instance: function( new_event_instance_id )
	{
		this.zoom( this.length / 2, this.width );
		$program.event_instance.include( new_event_instance_id, new event_instance_class( new_event_instance_id, this.event, this.day, this.time + this.length, this.length, this.left, this.width) );
	},
	
	save_copy_event: function()
	{
		this.wait();
		args = new Hash(
		{
			"app":					"program",
			"cmd":					"copy_event",
			"event_instance_id": 	this.id,
			"time":					$program.last_update_time
		});
		load_url = "index.php?" + args.toQueryString();
		
		new Request.JSON(
		{
			url: load_url, 
			onComplete: function(ans)
			{
				$program.run_update( ans );
				this.unwait();
			}.bind(this)
		}).send();
		
	},
	
	copy_event: function( new_event_id, new_event_instance_id)
	{
		$program.event.include(new_event_id, new event_class( new_event_id, this.event.name, this.event.category, this.event.prog ) );
		
		if(this.width >= 0.4)
		{
			this.zoom( this.length, this.width - 0.1);
			$program.event_instance.include( new_event_instance_id, new event_instance_class( new_event_instance_id, $program.event.get(new_event_id), this.day, this.time, this.length, this.left + 0.1, this.width ) );
		}
		else
		{
			if(this.left + this.width == 1)
			{	$program.event_instance.include( new_event_instance_id, new event_instance_class( new_event_instance_id, $program.event.get(new_event_id), this.day, this.time, this.length, this.left - 0.1, this.width) );	}
			else
			{	$program.event_instance.include( new_event_instance_id, new event_instance_class( new_event_instance_id, $program.event.get(new_event_id), this.day, this.time, this.length, this.left + 0.1, this.width) );	}
		}
	},
	
	wait: function()
	{
		this.waiting = true;
		this.wait_div.removeClass('hidden');
	},
	
	unwait: function()
	{
		this.waiting = false;
		if( !(this.waiting || this.event.waiting) )
		{	this.wait_div.addClass('hidden');	}
	},
	
	show_cat: function()
	{	this.border_div.setStyle( 'background-color', this.event.category.color );	},
	
	show_progress: function()
	{	this.border_div.setStyle( 'background-color', this.event.progress_color() );	},
	
	save_remove: function()
	{
		this.wait();
		
		args = new Hash(
		{
			"app":					"program",
			"cmd":					"remove_event_instance",
			"event_instance_id": 	this.id,
			"time":					$program.last_update_time
		});
		load_url = "index.php?" + args.toQueryString();
		
		new Request.JSON(
		{
			url: load_url, 
			onComplete: function(ans)
			{
				$program.run_update(ans);
			}.bind(this)
		}).send();
	},
	
	remove: function()
	{
		this.frame_div_fx.start( { '0': { 'opacity': 0 } } );
		this.frame_div.destroy.delay( 1500, this.frame_div );
		
		this.event.remove_event_instance(this);
		this.day.remove_event_instance(this);
		$program.event_instance.erase(this.id);
	}
	
});