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

var DI_TEXT = new Class({
	options: {
		args: 		{},
		save_url: 	'index.php?',
		buttons:	true,
		button_pos:	'right',
		
		min_level:  0,
		
		event_funcs: {}
	},
	
	type: 'text',
	
	initialize: function( element, options )
	{
		this.setOptions( options );
		this.options.args = new Hash( this.options.args );
		this.options.event_funcs = new Hash( this.options.event_funcs );
		
		if( $type( element ) == "array" )	
		{	this.reproduce( element, this.options );	return;	}
		
		if( $type( $( element ) ) != "element" )	{	return false;	}
		if( $( element ).get( 'tag' ) != "input" )	{	return false;	}
		if( $( element ).get( 'type' ) != "text" )	{	return false;	}

		if( !this.options.save_url.contains( '?' ) )	
		{	this.options.save_url = this.options.save_url + '?';	}
		
		this.element = element;
		
		this.setup_element();
		
		if( auth.access( this.options.min_level ) )
		{	this.setup_function();	}
		
		this.value = this.show_input.get( 'value' );
	},
	
	reproduce: function( element, options )
	{
		this.list = [];
		element.each( function( item )
		{	this.list.include( new DI_TEXT( item, options ) );	}.bind(this) );
	},
	
	setup_element: function()
	{
		this.show_div 		= new Element( 'div' );
		this.wait_div 		= new Element( 'div' );
		this.edit_div 		= new Element( 'div' );
		
		this.show_input 	= $( this.element );
		this.edit_input		= this.show_input.clone([ true, false ]);
		this.wait_img 		= new Element( 'img', { 'src': 'public/global/img/wait.gif' } );
		
		if( this.options.buttons )
		{
			this.save_button	= new Element( 'input', { 'type': 'image', 'src': 'public/global/img/okay.png' 	} );
			this.cancel_button 	= new Element( 'input', { 'type': 'image', 'src': 'public/global/img/cancel.png'} );
			
			this.save_button.setStyle( 'padding-left', '5px' );
			this.cancel_button.setStyle( 'padding-left', '5px' );
		}

		this.show_input.setStyle( 'border', '1px solid black' );
		this.show_input.setStyle( 'margin', '2px' );
		this.edit_input.setStyle( 'width', this.show_input.getStyle( 'width' ) );
		
		this.show_div.wraps( 		this.show_input );
		this.wait_div.inject( 		this.show_div, 'after' );
		this.wait_img.inject( 		this.wait_div );
		
		this.edit_div.inject(		this.show_div, 'after' );
		this.edit_input.inject(		this.edit_div );
		
		if( this.options.buttons )
		{
			this.save_button.inject(	this.edit_input, 'after' );
			this.cancel_button.inject(	this.save_button, 'after' );
		}

		this.edit_div.addClass( 'hidden' );
		this.wait_div.addClass( 'hidden' );

		if( this.options.buttons )
		{
			if( this.options.button_pos == "bottom" )
			{
				new Element('br').inject( this.edit_input, 'after' );
				this.edit_div.setStyle( 'text-align', 'right' );
			}
			else
			{	this.edit_input.setStyle( 'width', Math.max( (this.show_input.getSize().x - 60), 30 ) );	}
		}

		this.edit_input.setStyle( 'background-color', '#FFBB00' );
		this.edit_input.removeProperty( 'readonly' );
		this.show_input.set('readonly', 'readonly').setStyle('cursor', 'pointer');
		
		this.edit_input.set( 'value', this.show_input.get( 'value' ) );
	},
	
	setup_function: function()
	{
		this.show_input.addEvent( 	'click', this.edit.bind( this ) );
		this.show_input.addEvent( 	'keyup', this.show_keyup.bind( this ) );
		
		this.show_input.addEvent(	'focus', function()
		{
			this.show_input.setStyle( 'border', '3px solid red' );
			this.show_input.setStyle( 'margin', '0px' );
		}.bind(this) );
		this.show_input.addEvent(	'blur',  function()
		{
			this.show_input.setStyle( 'border', '1px solid black' );
			this.show_input.setStyle( 'margin', '2px' );
		}.bind(this) );
		
		this.edit_input.addEvent( 	'keyup', this.edit_keyup.bind( this ) );
		
		if( this.options.buttons )
		{
			this.save_button.addEvent( 	'click', this.save.bind( this ) );
			this.cancel_button.addEvent('click', this.cancel.bind( this ) );
		}
	},
	
	show_keyup: function( event )
	{
		event.stopPropagation();
		
		if( this.show_div.hasClass( 'hidden' ) )
		{	return;	}
		
		if( event.key == "enter" || event.key == "space" )
		{	this.edit.bind( this ).run();	}
	},
	
	edit_keyup: function( event )
	{
		event.stopPropagation();
	
		if( this.edit_div.hasClass( 'hidden' ) )
		{	return;	}
		
		if( event.key == "enter" )		{	this.save.bind( this ).run();	}
		if( event.key == "esc" )		{	this.cancel.bind( this ).run();	}
	},
	
	set_value: function( value )
	{
		this.value = value;
		
		this.show_input.set( 'value', this.value );
		this.edit_input.set( 'value', this.value );
	},
	
	edit: function()
	{
		this.show_div.addClass( 'hidden' );
		this.wait_div.addClass( 'hidden' );
		this.edit_div.removeClass( 'hidden' );
		
		this.edit_input.focus();
	},
	
	cancel: function(  )
	{
		this.edit_div.addClass('hidden');
		this.wait_div.addClass('hidden');
		this.show_div.removeClass('hidden');
		
		this.show_input.set( 'value', this.value );
		this.edit_input.set( 'value', this.value );
		
		this.show_input.focus();
	},
	
	save: function(  )
	{
		this.show_div.addClass( 'hidden' );
		this.edit_div.addClass( 'hidden' );
		this.wait_div.removeClass( 'hidden' );
		
		url = this.options.args.set( this.show_input.get('name'), this.edit_input.get('value') );
		url = this.options.save_url + url.toQueryString();
		
		new Request.JSON(
		{
			url: url, 
			onComplete: this.change.bind(this)
		}).send();
	},
	
	change: function( ans )
	{
		if( ans.error )
		{
			alert( ans.error_msg );
			this.set_value( this.value );
		}
		else
		{	this.set_value( ans.value );	}
		
		this.edit_div.addClass('hidden');
		this.wait_div.addClass('hidden');
		this.show_div.removeClass('hidden');
		
		this.show_input.focus();
		
		this.runEvent( 'change' );
	},
	
	addEventListener: function( event, func )
	{
		if( !this.options.event_funcs.get(event) )
		{	this.options.event_funcs.set(event, new Array() );	}
		
		this.options.event_funcs.get( event ).include( func );
	},
	
	runEvent: function( event )
	{
		if( this.options.event_funcs.get( event ) )
		{
			this.options.event_funcs.get( event ).each( function( item )
			{	item.run();	});
		}
	}
});
DI_TEXT.implement( new Options );

var DI_DATE = new Class({
	options: {
		args: 		{},
		save_url: 	'index.php?'
	},
	
	type: 'date',

	initialize: function( element, options )
	{
		this.setOptions( options );
		this.options.args = new Hash( this.options.args );
		
		if( $type( element ) == "array" )	
		{	this.reproduce( element, this.options );	return;	}
		
		if( $type( $( element ) ) != "element" )		{	return false;	}
		if( $( element ).get( 'tag' ) != "input" )	{	return false;	}
		if( $( element ).get( 'type' ) != "text" )	{	return false;	}

		if( !this.options.save_url.contains( '?' ) )	
		{	this.options.save_url = this.options.save_url + '?';	}
		
		this.element = element;
		
		this.setup_element();
		this.setup_function();
		
		this.value = this.show_input.get( 'value' );
	},
	
	reproduce: function( element, options )
	{
		this.list = [];
		element.each( function( item )
		{	this.list.include( new DI_DATE( item, options ) );	}.bind(this) );
	},
	
	setup_element: function()
	{
		this.show_div 		= new Element( 'div' );
		this.wait_div 		= new Element( 'div' );
		this.edit_div 		= new Element( 'div' );
		
		this.show_input 	= $( this.element );
		this.edit_input		= this.show_input.clone();
		this.wait_img 		= new Element( 'img', { 'src': 'public/global/img/wait.gif' } );

		this.show_div.wraps( 		this.show_input );
		this.wait_div.inject( 		this.show_div, 'after' );
		this.wait_img.inject( 		this.wait_div );
		
		this.edit_div.inject(		this.show_div, 'after' );
		this.edit_input.inject(		this.edit_div );

		this.edit_div.addClass( 'hidden' );
		this.wait_div.addClass( 'hidden' );
		
		this.edit_input.setStyle( 'background-color', '#FFBB00' );
		this.edit_input.setStyle( 'width', this.show_input.getSize().x - 35 );
		this.show_input.set('readonly', 'readonly').setStyle('cursor', 'pointer');
	},
	
	setup_function: function()
	{
		this.show_input.addEvent( 	'click', this.edit.bind( this ) );
		this.show_input.addEvent( 	'keyup', this.show_keyup.bind( this ) );
		
		this.edit_input.addEvent(	'keyup', this.edit_keyup.bind( this ) );
		
		this.id_str = 'Calendar_element_' + $random( 0, Math.pow(2,64) );
		this.edit_input.set( 'id', this.id_str );

		tx = -1 * this.edit_input.getStyle('width').toInt() - 25;
		ty = 20;
		this.cal_el = (new Hash({})).set( this.id_str, 'd.m.Y' );
		this.cal = new Calendar( 
			this.cal_el, 
			{ navigation: 2 , offset: 1, tweak: {x: tx, y: ty}, onHideComplete: this.hide_calendar.bind(this) }
		);
	},
	
	show_keyup: function( event )
	{
		if( event.key == "enter" || event.key == "space" )
		{	this.edit.bind( this ).run();	}
	},
	
	edit_keyup: function( event )
	{
		if( event.key == "esc" )
		{	this.cal.toggle( this.cal.calendars.filter( function(value, key){ return value.el == this.edit_input;	}.bind(this) ).getLast() );	}
	},
	
	hide_calendar: function()
	{
		if( this.edit_input.get('value') == this.show_input.get('value') && this.show_input.get('value') == this.value )
		{	this.cancel.bind(this).run();	}
		else
		{	this.save.bind(this).run();	}
	},
	
	set_value: function( value )
	{
		this.value = value;
		this.show_input.set( 'value', this.value );
		this.edit_input.set( 'value', this.value );
	},
	
	edit: function()
	{
		this.show_div.addClass( 'hidden' );
		this.wait_div.addClass( 'hidden' );
		this.edit_div.removeClass( 'hidden' );
		
		this.edit_input.focus();
	},
	
	cancel: function()
	{
		this.edit_div.addClass('hidden');
		this.wait_div.addClass('hidden');
		this.show_div.removeClass('hidden');
		
		this.edit_input.set('value', this.value );
		this.show_input.set('value', this.value );
		
		this.show_input.focus();
	},
	
	save: function()
	{
		this.show_div.addClass('hidden');
		this.edit_div.addClass('hidden');
		this.wait_div.removeClass('hidden');
		
		url = this.options.args.set( this.show_input.get('name'), this.edit_input.get('value') );
		url = this.options.save_url + url.toQueryString();
		
		new Request.JSON(
		{
			url: url, 
			onComplete: this.change.bind(this)
		}).send();
	},
	
	change: function( ans )
	{
		if( ans.error )
		{
			alert( ans.error_msg );
			this.set_value( this.value );
		}
		else
		{	this.set_value( ans.value );	}
		
		this.edit_div.addClass('hidden');
		this.wait_div.addClass('hidden');
		this.show_div.removeClass('hidden');
		
		this.show_input.focus();
	}
	
});
DI_DATE.implement( new Options );

var DI_TEXTAREA = new Class({
	options: {
		args: 		{},
		save_url: 	'index.php?',
		buttons:	true,
		button_pos:	'right',
		
		min_level:	0
	},
	
	type: 'textarea',

	initialize: function( element, options )
	{
		this.setOptions( options );
		this.options.args = new Hash( this.options.args );
		
		if( $type( element ) == "array" )	
		{	this.reproduce( element, this.options );	return;	}
				
		if( $type( $( element ) ) != "element" )		{	return false;	}
		if( $( element ).get( 'tag' ) != "textarea" )	{	return false;	}

		if( !this.options.save_url.contains( '?' ) )	
		{	this.options.save_url = this.options.save_url + '?';	}
		
		this.element = element;
		
		this.setup_element();
		if( auth.access( this.options.min_level ) )
		{	this.setup_function();	}
		
		this.value = this.show_input.get( 'value' );
		
		this.autofit( "" );
	},
	
	reproduce: function( element, options )
	{
		this.list = [];
		element.each( function( item )
		{	this.list.include( new DI_TEXTAREA( item, options ) );	}.bind(this) );
	},
	
	setup_element: function()
	{
		this.show_div 		= new Element( 'div' );
		this.wait_div 		= new Element( 'div' );
		this.edit_div 		= new Element( 'div' );
		
		this.show_input 	= $( this.element );
		this.edit_input		= this.show_input.clone();
		this.wait_img 		= new Element( 'img', { 'src': 'public/global/img/wait.gif' } );
		
		if( this.options.buttons )
		{
			this.save_button	= new Element( 'input', { 'type': 'image', 'src': 'public/global/img/okay.png' 	} ).setStyle( 'padding-left', '5px' );
			this.cancel_button 	= new Element( 'input', { 'type': 'image', 'src': 'public/global/img/cancel.png'} ).setStyle( 'padding-left', '5px' );
		}

		this.show_input.setStyle( 'border', '1px solid black' );
		this.show_input.setStyle( 'margin', '2px' );
		this.edit_input.setStyle( 'width', this.show_input.getStyle( 'width' ) );
		
		this.show_div.wraps( 		this.show_input );
		this.wait_div.inject( 		this.show_div, 'after' );
		this.wait_img.inject( 		this.wait_div );
		
		this.edit_div.inject(		this.show_div, 'after' );
		this.edit_input.inject(		this.edit_div );
		
		if( this.options.buttons )
		{
			this.save_button.inject(	this.edit_input, 'after' );
			this.cancel_button.inject(	this.save_button, 'after' );
		}

		this.edit_div.addClass( 'hidden' );
		this.wait_div.addClass( 'hidden' );

		if( this.options.buttons )
		{
			if( this.options.button_pos == "bottom" )
			{
				new Element('br').inject( this.edit_input, 'after' );
				this.edit_div.setStyle( 'text-align', 'right' );
			}
			else
			{	this.edit_input.setStyle( 'width', this.show_input.getSize().x - 50 );	}
		}
		
		this.edit_input.setStyle( 'background-color', '#FFBB00' );
		this.edit_input.removeProperty( 'readonly' );
		this.show_input.set('readonly', 'readonly').setStyle('cursor', 'pointer');
	},
	
	setup_function: function()
	{
		this.show_input.addEvent( 	'click', this.edit.bind( this ) );
		this.show_input.addEvent( 	'keyup', this.show_keyup.bind( this ) );

		this.show_input.addEvent(	'focus', function()
		{
			this.show_input.setStyle( 'border', '3px solid red' );
			this.show_input.setStyle( 'margin', '0px' );
		}.bind(this) );
		this.show_input.addEvent(	'blur',  function()
		{
			this.show_input.setStyle( 'border', '1px solid black' );
			this.show_input.setStyle( 'margin', '2px' );
		}.bind(this) );

		this.edit_input.addEvent( 	'keyup', this.edit_keyup.bind( this ) );
		this.edit_input.addEvent(	'keyup', this.autofit.bind( this ) );
		
		if( this.options.buttons )
		{
			this.save_button.addEvent( 	'click', this.save.bind( this ) );
			this.cancel_button.addEvent('click', this.cancel.bind( this ) );
		}
	},
	
	show_keyup: function( event )
	{
		if( event.key == "enter" || event.key == "space" )
		{	this.edit.bind( this ).run();	}
	},
	
	edit_keyup: function( event )
	{	if( event.key == "esc" )		{	this.cancel.bind( this ).run();	}	},
	
	autofit: function( event )
	{
		if( event.key == "backspace" || event.key == "delete" )
		{	this.edit_input.setStyle( 'height', '30px' );	}
		
		if( this.edit_input.getSize().y < this.edit_input.getScrollSize().y.limit(30, 500) )
		{	this.edit_input.setStyle( 'height', this.edit_input.getScrollSize().y.limit(30, 500) );	}
		
		if( this.show_input.getSize().y < this.show_input.getScrollSize().y.limit(30, 500) )
		{	this.show_input.setStyle( 'height', this.show_input.getScrollSize().y.limit(30, 500) );	}
	},
	
	set_value: function( value )
	{
		this.value = value;
		this.show_input.set( 'value', this.value );
		this.edit_input.set( 'value', this.value );
	},
	
	edit: function()
	{
		this.show_div.addClass( 'hidden' );
		this.wait_div.addClass( 'hidden' );
		this.edit_div.removeClass( 'hidden' );
		
		this.autofit( "" );
		this.edit_input.focus();
	},
	
	cancel: function()
	{
		this.edit_div.addClass('hidden');
		this.wait_div.addClass('hidden');
		this.show_div.removeClass('hidden');
		
		this.show_input.set( 'value', this.value );
		this.edit_input.set( 'value', this.value );
		
		this.autofit( "" );
		this.show_input.focus();
	},
	
	save: function()
	{
		this.show_div.addClass( 'hidden' );
		this.edit_div.addClass( 'hidden' );
		this.wait_div.removeClass( 'hidden' );
		
		url = this.options.args.set( this.show_input.get('name'), this.edit_input.get('value') );
		url = this.options.save_url + url.toQueryString();
				
		new Request.JSON(
		{
			url: url, 
			onComplete: this.change.bind(this)
		}).send();
	},
	
	change: function( ans )
	{
		if( ans.error )
		{
			alert( ans.error_msg );
			this.set_value( this.value );
		}
		else
		{	this.set_value( ans.value );	}
		
		this.edit_div.addClass('hidden');
		this.wait_div.addClass('hidden');
		this.show_div.removeClass('hidden');
		
		this.autofit( "" );
		this.show_input.focus();
	}
});
DI_TEXTAREA.implement( new Options );

var DI_SELECT = new Class({
	options: {
		args: 		{},
		save_url: 	'index.php?',
		changed:	function(){},
		
		min_level: 	0
	},
	
	type: 'select',
	
	initialize: function( element, options )
	{
		this.setOptions( options );
		this.options.args = new Hash( this.options.args );
		
		if( $type( element ) == "array" )	
		{	this.reproduce( element, this.options );	return;	}
		
		if( $type( $( element ) ) != "element" )		{	return false;	}
		if( $( element ).get( 'tag' ) != "select" )	{	return false;	}

		if( !this.options.save_url.contains( '?' ) )	
		{	this.options.save_url = this.options.save_url + '?';	}
		
		this.element = element;
		
		this.setup_element();
		
		if( auth.access( this.options.min_level ) )
		{	this.setup_function();	}
		else
		{	this.show_input.set( 'disabled', 'disabled' );	}

		this.value = this.show_input.get( 'value' );
	},

	reproduce: function( element, options )
	{
		this.list = [];
		element.each( function( item )
		{	this.list.include( new DI_SELECT( item, options ) );	}.bind(this) );
	},
	
	setup_element: function()
	{
		this.show_div 		= new Element( 'div' );
		this.wait_div 		= new Element( 'div' );
		
		this.show_input 	= $( this.element );
		this.wait_img 		= new Element( 'img', { 'src': 'public/global/img/wait.gif' } );
		
		if( this.show_input.get('initvalue') == "false" )
		{
			this.empty_opt = new Element('option').set('html', '-').inject(this.show_input, 'top').set('selected', 'selected');
			this.value = false;
		}
		else
		{
			if( this.show_input.getElement('option[value=' + this.show_input.get('initvalue') + ']') )
			{	this.value = this.show_input.get('initvalue');	}
			else
			{	this.value = this.show_input.get( 'value' );	}
		}
				
		this.set_value( this.value );
		
		this.show_div.wraps( 		this.show_input );
		this.wait_div.inject( 		this.show_div, 'after' );
		this.wait_img.inject( 		this.wait_div );

		this.wait_div.addClass( 'hidden' );
	},
	
	setup_function: function()
	{
		this.show_input.addEvent( 	'change', this.save.bind( this ) );
	},
	
	set_value: function( value )
	{
		this.value = value;
		this.show_input.set( 'value', this.value );
	},
	
	save: function()
	{
		this.show_div.addClass('hidden');
		this.wait_div.removeClass('hidden');
		
		url = this.options.args.set( this.show_input.get('name'), this.show_input.get('value') );
		url = this.options.save_url + url.toQueryString();
		
		new Request.JSON(
		{
			url: url, 
			onComplete: this.change.bind(this)
		}).send();
	},
	
	change: function( ans )
	{
		if( ans.error )
		{
			alert( ans.error_msg );
			this.set_value( this.value );
		}
		else
		{
			this.set_value( ans.value );
			if( $defined( this.empty_opt ) ){	this.empty_opt.destroy();	}
		}
		this.show_input.set( 'value', this.value );
		
		this.wait_div.addClass('hidden');
		this.show_div.removeClass('hidden');
		
		this.options.changed.run();
	}
});
DI_SELECT.implement( new Options );

var DI_MSELECT = new Class({
	options: {
		args: 		{},
		save_url: 	'index.php?',
		changed:	function(){},
		show_optgroup_label: "Ausgewählte:",
		list_optgroup_label: "Auswahl:",
		changed:	function(){},
		
		min_level: 	0,
		
		debug:		false
	},
		
	type: 'mselect',
	
	initialize: function( element, options )
	{
		this.setOptions( options );
		this.options.args = new Hash( this.options.args );
		
		if( $type( element ) == "array" )	
		{	this.reproduce( element, this.options );	return;	}
		
		if( $type( $( element ) ) != "element" )	{	return false;	}
		if( $( element ).get( 'tag' ) != "select" )	{	return false;	}
		
		if( !this.options.save_url.contains( '?' ) )	
		{	this.options.save_url = this.options.save_url + '?';	}
		
		this.element = $( element );
		
		this.setup_element();
		
		if( auth.access( this.options.min_level ) )
		{	this.setup_function();	}
		else
		{	this.element.set( 'disabled', 'disabled' );	}

		this.value = this.show_input.get( 'value' );
	},

	reproduce: function( element, options )
	{
		this.list = [];
		element.each( function( item )
		{	this.list.include( new DI_MSELECT( item, options ) );	}.bind(this) );
	},
	
	setup_element: function()
	{
		this.show_div 		= new Element( 'div' );
		this.wait_div 		= new Element( 'div' );
		
		this.show_input 	= this.element;
		this.wait_img 		= new Element( 'img', { 'src': 'public/global/img/wait.gif' } );
		
		this.option_list = new Array();
		
		this.show_optgroup	= new Element( 'optgroup' ).inject( this.show_input );
		this.list_optgroup	= new Element( 'optgroup' ).inject( this.show_input );
		
		this.show_optgroup.setProperty( 'label', this.options.show_optgroup_label );
		this.list_optgroup.setProperty( 'label', this.options.list_optgroup_label );
		
		this.show_input.getElements( 'option' ).each( function( opt )
		{
			opt.inject( this.list_optgroup );
			opt.setStyle( 'font-family', 'Courier' );

			optH = new Hash();
			
			optH.set( 'option', 	opt );
			optH.set( 'label',		opt.get( 'html' ) );
			optH.set( 'value', 		opt.getProperty( 'value' ) );
			optH.set( 'selected', 	( opt.getProperty( 'mselected' ) == 'true' ) );
			
			opt.store( 'H', optH );
			this.option_list.include( optH );
			
			if( optH.selected )	{	opt.set('html', "[x] " + optH.label );	}
			else				{	opt.set('html', "[ ] " + optH.label );	}
		}.bind(this));
		
		this.show_option	= new Element( 'option' ).inject( this.show_optgroup );
		
		this.show_string = "";
		this.option_list.each( function( optH )
		{
			if( optH.selected )
			{
				optH.option.removeProperty( 'selected' );
				this.show_string += optH.label + "; ";
			}
		}.bind(this));
		
		this.show_option.set( 'html', this.show_string );		
		this.show_option.set( 'value', 'display' );
		this.show_input.set( 'value', 'display' );

		this.show_div.wraps( 		this.show_input );
		
		this.wait_div.inject( 		this.show_div, 'after' );
		this.wait_img.inject( 		this.wait_div );
		
		this.wait_div.addClass( 'hidden' );
	},
	
	setup_function: function()
	{
		this.show_input.addEvent( 	'change', this.save.bind( this ) );
	},
	
	update_element: function()
	{
		this.show_string = "";
		this.option_list.each( function( optH )
		{
			if( optH.selected )	{	optH.option.set('html', "[x] " + optH.label );	}
			else				{	optH.option.set('html', "[ ] " + optH.label );	}
			
			if( optH.selected )
			{
				optH.option.removeProperty( 'mselected' );
				this.show_string += optH.label + "; ";
			}
		}.bind(this));
		
		this.show_option.set( 'html', this.show_string );
		this.show_input.set( 'value', 'display' );
	},

	toggle_value: function( value )
	{
		optH = this.get_optH_by_value( value );
		this.set_optH( optH, !optH.selected );
	},
	
	toggle_opt: function( opt )
	{
		optH = this.get_optH_by_opt( opt );
		this.set_optH( optH, !optH.selected );
	},

	check_value: function( value )
	{	this.set_value( value, true );	},
	
	check_opt: function( opt )
	{	this.set_opt( opt, true );	},

	uncheck_value: function( value )
	{	this.set_value( value, false );	},
	
	uncheck_opt: function( opt )
	{	this.set_opt( opt, false );	},

	set_value: function( value, set )
	{	this.set_optH( this.get_optH_by_value( value ), set );	},
	
	set_opt: function( opt, set )
	{	this.set_optH( this.get_optH_by_opt( opt ), set );	},
	
	set_optH: function( optH, set )
	{	optH.selected = set;	},

	get_optH_by_value: function( value )
	{	return this.option_list.filter( function( optH ){	return (value == optH.value);	}).getLast();	},
	
	get_optH_by_opt: function( opt )
	{	return opt.retrieve('H');	},

	save: function()
	{
		if( this.show_input.getSelected().getLast() == this.show_option )
		{	return;	}

		this.show_div.addClass( 'hidden' );
		this.wait_div.removeClass( 'hidden' );
		
		this.toggle_opt( this.show_input.getSelected().getLast() );
		
		values = new Hash;
		this.option_list.each( function( optH )
		{	values.set( optH.value, optH.selected );	}.bind(this));
		
		this.toggle_opt( this.show_input.getSelected().getLast() );

		url = this.options.save_url;
		if( this.options.args.getLength() )	{	url = url + this.options.args.toQueryString() + "&";	}
		else								{	url = url + this.options.args.toQueryString() ;			}
		url = url + values.toQueryString( this.show_input.get('name') );
		
		this.options.debug && alert( url );
		
		new Request.JSON(
		{
			url: url, 
			onComplete: this.change.bind(this)
		}).send();
	},
	
	change: function( ans )
	{
		this.options.debug && alert( ans );

		if( ans.error )
		{
			alert( ans.error_msg );
			this.set_value( this.value );
		}
		else
		{
			this.options.debug && alert( ans.value );
			
			ans.value.each( function( item )
			{	this.set_value( item.value, item.selected );	}.bind(this));
			
			this.update_element();
		}
		
		this.wait_div.addClass('hidden');
		this.show_div.removeClass('hidden');
		
		this.options.changed.run();
	}
});
DI_MSELECT.implement( new Options );

var DI_TABLE = new Class({
	options:{
		args:		{},
		button:		true,
		inputs:		{
			'1': { 'width': 0.2, 'type': 'text', 'value': '' },
			'2': { 'width': 0.7, 'type': 'text', 'value': '' },
			'3': { 'width': 0.1, 'type': 'text', 'value': '' }
		},
		save_url:	'index.php?',
		
		min_level:	0
	},
	
	type: 	'table',
	edit_e: null,
	
	initialize: function( element, options )
	{
		this.setOptions( options );
		this.options.args = new Hash( this.options.args );
		
		if( $type( element ) == "array" )	
		{	this.reproduce( element, this.options );	return;	}
		
		if( $type( $( element ) ) != "element" )	{	return false;	}
		if( $( element ).get( 'tag' ) != "table" )	{	return false;	}

		if( !this.options.save_url.contains( '?' ) )	
		{	this.options.save_url = this.options.save_url + '?';	}
		
		this.element = $( element );

		this.setup_element();
		if( auth.access( this.options.min_level ) )
		{	this.setup_function();	}
		
		this.scroller = new Fx.Scroll( this.list );
	},
	
	reproduce: function( element, options )
	{
		this.list = [];
		element.each( function( item )
		{	this.list.include( new DI_TABLE( item, options ) );	}.bind(this) );
	},
	
	setup_element: function()
	{
		this.width =  this.element.getSize().x.toInt();
		this.element.setStyle( 'width',  this.width - 20  );
		
		this.options.inputs = new Hash( this.options.inputs );

		this.rows = new Hash();
		this.row_count = 0;
		this.col_count = 0;
		this.element.getElements( 'tr' ).each( this.setup_element_entry.bind( this ) );
		
		this.height = 18;
		this.height += this.element.get( 'cellspacing' ).toInt(); 
		this.height += 2 * this.element.get( 'cellpadding' ).toInt();
		this.height *= this.col_count.limit( 1, 4 );

		this.list = new Element( 'div' );
		this.list.wraps( this.element );
		this.list.setStyle( 'overflow', 'auto' );
		
		this.list.setStyle( 'height', this.height + "px" );
		this.list.setStyle( 'width', this.width + "px" );
		this.list.setStyle( 'border', '1px solid black' );

		this.border = new Element( 'div' );
		this.border.wraps( this.list );
		
		this.inputs = new Hash();

		if( auth.access( this.options.min_level ) )
		{
			if( this.row_count )	
			{
				this.rows.each( function( width, nr )
				{
					if( this.options.inputs.get( nr ) )	{	i = new Hash( this.options.inputs.get( nr ) );	}
					else								{	i = new Hash({ 'width': 0 });	}
					i.width = width / ( this.width - 20 );
					
					if( i.type == "text" )	{	this.setup_text_input( i, nr );		}
					if( i.type == "select" ){	this.setup_select_input( i, nr );	}
					
				}.bind( this ) );
				
				if( this.options.button )
				{
					this.button = new Element( 'button' );
					this.button.setStyle( 'width', this.rows.get( this.row_count ) + 20 );
					this.button.set( 'html', '+' );
					this.button.inject( this.border, 'bottom' );
				}
			}
			else
			{
				for( var nr=1; nr <= this.options.inputs.getLength(); nr=nr+1 )
				{
					var i = this.options.inputs.get( nr );
				//this.options.inputs.each( function( i, nr )
				//{
					if( i.type == "text" )	{	this.setup_text_input( i, nr );		}
					if( i.type == "select" ){	this.setup_select_input( i, nr );	}
					
				}; //.bind( this ) );
				
				if( this.options.button )
				{
					this.button = new Element( 'button' );
					this.button.setStyle( 'width', this.options.inputs.get( this.options.inputs.getLength() ).width * (this.width-20) + 20 );
					this.button.set( 'html', '+' );
					this.button.inject( this.border, 'bottom' );
				}
			}
		}
	},
	
	setup_text_input: function( i, nr )
	{
		if( this.options.inputs.getLength() == nr )	{	return;	}
				
		input = new Element( 'input' );

		input.setStyle( 'width', Math.max( 20, (this.width - 20) * i.width - 8 ) );
		input.setStyle( 'border', '1px solid black' );
		input.setStyle( 'margin', '2px' );
		
		if( $type( i.value ) == "string" )	{	input.set('value', i.value );	}
		
		input.addEvent(	'focus', function()
		{
			this.setStyle( 'border', '3px solid red' );
			this.setStyle( 'margin', '0px' );
		}.bind(input) );
		input.addEvent(	'blur',  function()
		{
			this.setStyle( 'border', '1px solid black' );
			this.setStyle( 'margin', '2px' );
		}.bind(input) );
		
		input.inject( this.border, 'bottom' );
		
		this.inputs.set( nr, input );
		
		return;
	},
	
	setup_select_input: function( i, nr )
	{
		if( this.options.inputs.getLength() == nr )	{	return;	}
		
		select = new Element('select');
		select.setStyle( 'width', (this.width - 20) * i.width - 4 );
		select.setStyle( 'margin', '2px' );
		
		if( $type( i.options ) == "array" )
		{
			i.options.each( function( opt )
			{
				if( opt.tag == "option" )
				{	this.setup_select_option( select, opt );	}
				if( opt.tag == "optgroup" )
				{	this.setup_select_optgroup( select, opt );	}
			}.bind(this));
		}
		
		select.inject( this.border, 'bottom' );
		this.inputs.set( nr, select );
		
		return;
	},
	
	setup_select_optgroup: function( p, optgroup )
	{
		og = new Element( 'optgroup' );
		og.set( 'label', optgroup.label );
		
		og.inject( p , 'bottom' );
		
		if( $type( optgroup.options ) == "array" )
		{
			optgroup.options.each( function( opt )
			{
				this.setup_select_option( og, opt );
			}.bind(this));
		}
	},
	
	setup_select_option: function( p, option )
	{
		o = new Element( 'option' );
		o.set( 'value', option.value );
		o.set( 'html', option.html );
		
		o.inject( p, 'bottom' );
	},
	
	setup_element_entry: function( entry )
	{	
		this.col_count++;
		
		e = new Hash();
		e.rows = new Hash();
		
		e.options = new Element( 'td' );
		e.options.set('width', '32px' );
		e.options.inject( entry );
		
		e.edit = new Element( 'img' );
		e.edit.set( 'src', 'public/global/img/edit.png' );
		e.edit.setStyle( 'cursor', 'pointer' );
		e.edit.inject( e.options );

		e.del = new Element( 'img' );
		e.del.set( 'src', 'public/global/img/del.png' );
		e.del.setStyle( 'cursor', 'pointer' );
		e.del.inject( e.options );
		
		if( entry.get('id') )
		{	e.id = entry.get('id');	}
		else
		{	e.id = 0;	}

		this.temp = 1;
		entry.getElements( 'td' ).each( function( row )
		{
			row.setStyle( 'width', this.options.inputs.get( this.temp ).width * this.width - 6);
			
			this.rows.set( this.temp, row.getStyle( 'width' ).toInt() );
			e.rows.set( this.temp, row );
			
			this.row_count = Math.max( this.row_count, this.temp );
			this.temp++;
		}.bind( this ));
		
		this.setup_function_entry( entry, e );
	},
	
	update_element: function()
	{
		this.height = 18;
		this.height += this.element.get( 'cellspacing' ).toInt(); 
		this.height += 2 * this.element.get( 'cellpadding' ).toInt();
		this.height *= this.col_count.limit( 1, 4 );
		
		this.list.setStyle( 'height', this.height );
	},
	
	setup_function: function()
	{
		this.button.removeEvents( 'click' );
		this.button.addEvent( 'click', this.save_add_entry.bind(this) );
		
		this.button.addEvent( 'focus', function()
		{
			this.button.setStyle( 'font-weight', 'bolder' );
			this.button.setStyle( 'color', 'red' );
		}.bind(this));
		
		this.button.addEvent( 'blur', function()
		{
			this.button.setStyle( 'font-weight', 'none' );
			this.button.setStyle( 'color', 'black' );
		}.bind(this));
	},
	
	setup_function_entry: function( entry, e )
	{
		//e = entry.retrieve( 'e' );
	
		e.del.addEvent( 'click', this.save_remove_entry.bind(this, [entry, e]) );
		e.edit.addEvent( 'click', this.start_edit_entry.bind(this, e) );
	},
	
	save_add_entry: function()
	{
		values = new Hash();
		this.inputs.each( function( input, nr )
		{	values.set( nr, input.get('value') );	});
		
		url = this.options.args.set( 'todo', 'add' );
		url = this.options.save_url + url.toQueryString();
		url = url + "&" + values.toQueryString( "inputs" );
		
		//alert( url );						// For Debugging!!
		//this.add_entry( 10, values );		// For Debugging!!
		
		new Request.JSON(
		{
			url: url, 
			onComplete: function( ans )
			{
				if( ans.error )	{	alert( ans.error_msg );	}
				else			{	this.add_entry( ans.id, ans.values );	}
			}.bind( this )
		}).send();
	},
	
	add_entry: function( id, values )
	{
		tr = new Element( 'tr' ).set( 'id', id );
		tr.inject( this.element, 'bottom' );

		values.each( function( value )
		{
			td = new Element( 'td' );
			td.set( 'html', value );
			td.inject( tr, 'bottom' );
		}.bind(this));

		this.inputs.each( function( input )
		{	input.set( 'value', '' );	});

		this.setup_element_entry( tr );
		this.update_element();
		
		this.scroller.toElement( tr );
		this.inputs.get(1).focus();
	},
	
	save_remove_entry: function( entry, e )
	{		
		url = this.options.args.set( 'todo', 'del' ).set( 'id', e.id );
		url = this.options.save_url + url.toQueryString();
		
		//alert( url );						// For Debugging!!
		//this.remove_entry( entry, e );	// For Debugging!!
		
		new Request.JSON(
		{
			url: url, 
			onComplete: function( ans )
			{
				if( ans.error )	{	alert( ans.error_msg );	}
				else			{	this.remove_entry( entry, e );	}
			}.bind( this )
		}).send();		
		
	},
	
	remove_entry: function( entry, e )
	{
		if( this.edit_e == e )
		{
			this.inputs.each( function( input )
			{	input.set( 'value', '' );	});
			
			this.button.set( 'html', '+' );
			this.button.removeEvents( 'click' );
			this.button.addEvent( 'click', this.save_add_entry.bind( this, e ) );
		}
		
		$(entry).destroy();
		this.col_count--;
		
		this.update_element();
		this.inputs.get(1).focus();
	},
	
	save_edit_entry: function( e )
	{
		values = new Hash();
		this.inputs.each( function( input, nr )
		{	values.set( nr, input.get('value') );	});
		
		url = this.options.args.set( 'todo', 'edit' ).set( 'id', e.id );
		url = this.options.save_url + url.toQueryString();
		url = url + "&" + values.toQueryString( "inputs" );
		
		//alert( url );						// For Debugging!!
		//this.edit_entry( e, values );		// For Debugging!!
		
		new Request.JSON(
		{
			url: url, 
			onComplete: function( ans )
			{
				if( ans.error )	{	alert( ans.error_msg );	}
				else			{	this.edit_entry( e, ans.values );	}
			}.bind( this )
		}).send();
	},
	
	start_edit_entry: function( e )
	{
		this.edit_e = e;
		
		this.inputs.each( function( input, nr )
		{
			if( input.get('tag') == "input" )	
			{	input.set( 'value', e.rows.get(nr).get('text') );	}
			else							
			{
				input.getElements( 'option' ).each( function( option )
				{
					if( option.get('text') == e.rows.get(nr).get('text') )
					{	input.set( 'value', option.get('value') );	}
				});
				//alert( 'option:contains(\"' + e.rows.get(nr).get('text') + '\")' );
				//input.set( 'value', input.getElement( 'option:contains("' + e.rows.get(nr).get('text') + '")' ).get('value') );
			}
		}.bind(this));
		this.inputs.get(1).focus();

		this.button.set( 'html', 'OK' );
		this.button.removeEvents( 'click' );
		this.button.addEvent( 'click', this.save_edit_entry.bind( this, e ) );
	},
	
	edit_entry: function( e, values )
	{
		this.edit_e = null;
		
		values = new Hash( values );
		values.each( function( value, nr )
		{	e.rows.get( nr ).set( 'html', value );	});

		this.inputs.each( function( input )
		{	input.set( 'value', '' );	});
		
		this.button.set( 'html', '+' );
		this.button.removeEvents( 'click' );
		this.button.addEvent( 'click', this.save_add_entry.bind( this ) );
		
		this.scroller.toElement( e.options );
		this.inputs.get(1).focus();
	}
	
});
DI_TABLE.implement( new Options );

var DI_HIDDEN = new Class({
	options:{
		args:		{},
		save_url:	'index.php?'
	},
	
	type: 'hidden',
	
	initialize: function( element, options )
	{
		this.setOptions( options );
		this.options.args = new Hash( this.options.args );
		
		if( $type( element ) == "array" )	
		{	this.reproduce( element, this.options );	return;	}
		
		if( $type( $( element ) ) != "element" )	{	return false;	}
		if( $( element ).get( 'tag' ) != "input" )	{	return false;	}

		if( !this.options.save_url.contains( '?' ) )	
		{	this.options.save_url = this.options.save_url + '?';	}
		
		this.element = $( element );
		
		this.setup_element();
		
		this.value = this.element.get( 'value' );
	},
	
	reproduce: function( element, options )
	{
		this.list = [];
		element.each( function( item )
		{	this.list.include( new DI_HIDDEN( item, options ) );	}.bind(this) );
	},
	
	setup_element: function()
	{
		this.show_input = this.element;
		this.edit_input = this.element;
		
		this.show_div = new Element('div');
		this.edit_div = new Element('div');
		this.wait_div = new Element('div');
				
		this.element.addClass( 'hidden' );
		//this.element.set( 'type', 'hidden' );
		this.element.set( 'readonly', 'readonly' );
	},
	
	set_value: function( value )
	{
		this.value = value;
		this.element.set( 'value', this.value );
	},
	
	edit: 	function(){},
	cancel: function(){},
	save:	function(){}
	
});
DI_HIDDEN.implement( new Options );

var DI_MULTIPLE = new Class({
	options: {
		uni_height:		false,
		
		args: 			{},
		single_save: 	false,
		save_url: 		'index.php?',
		
		debug:			false,
		
		min_level:		0
	},
	
	list: [],
	
	height: 0,
	
	initialize: function( inputs, options )
	{
		this.setOptions( options );
		this.options.args = new Hash( this.options.args );
		
		if( !this.options.save_url.contains( '?' ) )	
		{	this.options.save_url = this.options.save_url + '?';	}

		if( $type(inputs) == "array" )
		{	inputs.each( function( input ){	this.setup_element( input );	}.bind( this ) );	}
		else
		{	this.setup_element( inputs );	}

		if( auth.access( this.options.min_level ) )
		{	this.setup_function();	}
	},
	
	setup_element: function( input )
	{
		if( input.type.toLowerCase() == "text" )
		{
			if( $defined( input.id ) )
			{
				this.set( input.id, new DI_TEXT( input.element, input.options ) );
				this.list.include( this[ input.id ] );
			}
			else
			{	this.list.include( new DI_TEXT( input.element, input.options ) );	}
		}
		else if( input.type.toLowerCase() == "textarea" )
		{
			if( $defined( input.id ) )
			{
				this.set( input.id, new DI_TEXTAREA( input.element, input.options ) );
				this.list.include( this[ input.id ] );
			}
			else
			{	this.list.include( new DI_TEXTAREA( input.element, input.options ) );	}
		}		
		else if( input.type.toLowerCase() == "hidden" ) {
			if ($defined(input.id)) {
				this.set(input.id, new DI_HIDDEN(input.element, input.options));
				this.list.include(this[input.id]);
			}
			else {
				this.list.include(new DI_HIDDEN(input.element, input.options));
			}
		}
	},
	
	setup_function: function()
	{
		this.list.each( function( input )
		{
			if( input.type.toLowerCase() == "text" )
			{
				input.show_input.removeEvents( 'click' );
				input.show_input.removeEvents( 'keyup' );
				input.show_input.addEvent( 'click', this.edit.bind( this ) );
				input.show_input.addEvent( 'keyup', this.show_keyup.bind( this ) );
				
				input.edit_input.removeEvents('keyup');
				input.edit_input.addEvent( 'keyup', this.edit_keyup.bindWithEvent( this,  "text" ) );
				
				if( input.options.buttons )
				{
					input.save_button.removeEvents( 'click' );
					input.cancel_button.removeEvents( 'click' );
					
					input.save_button.addEvent( 'click', this.save.bind( this ) );
					input.cancel_button.addEvent( 'click', this.cancel.bind( this ) );
				}
			}
			else if( input.type.toLowerCase() == "textarea" )
			{
				input.show_input.removeEvents( 'click' );
				input.show_input.removeEvents( 'keyup' );
				input.show_input.addEvent( 'click', this.edit.bind( this) );
				input.show_input.addEvent( 'keyup', this.show_keyup.bind( this ) );
				
				input.edit_input.removeEvents('keyup');
				input.edit_input.addEvent( 'keyup', this.edit_keyup.bindWithEvent( this, "textarea" ) );
				
				if( this.options.uni_height )
				{	input.edit_input.addEvent( 'keyup', this.autofit.bindWithEvent( this, input ) );	}
				else
				{	input.edit_input.addEvent( 'keyup', input.autofit.bind( input ) );	}
				
				if( input.options.buttons )
				{
					input.save_button.removeEvents( 'click' );
					input.cancel_button.removeEvents( 'click' );
					
					input.save_button.addEvent( 'click', this.save.bind( this ) );
					input.cancel_button.addEvent( 'click', this.cancel.bind( this ) );
				}
			}
		}.bind(this) );
	},
	
	show_keyup: function( event )
	{
		if( event.key == "enter" || event.key == "space" )
		{	this.edit.bind( this ).run();	}
	},
	
	edit_keyup: function( event, type )
	{
		if( event.key == "enter" && type == "text")	{	this.save.bind( this ).run();	}
		if( event.key == "esc" )					{	this.cancel.bind( this ).run();	}
	},
	
	autofit: function( event, input )
	{
		if( input.type != "textarea" )	{	return;	}
		
		input.autofit( event );
		
		if( event.key == "backspace" || event.key == "delete" )
		{
			if( input.edit_input.getSize().y < this.height )
			{
				this.height = 30;
				
				this.list.each( function( item )
				{
					if( input.type != "textarea" )	{	return;	}
					
					item.autofit( event );
					this.height  = this.height.limit( item.edit_input.getSize().y, 500 );
				}.bind( this ) );
				
				this.list.each( function( item )
				{
					if( input.type != "textarea" )	{	return;	}
					
					item.edit_input.setStyle( 'height', this.height );
				}.bind( this ) );
			}
		}
		else
		{
			this.list.each( function( item )
			{
				if( item.type != "textarea" )	{	return;	}
				
				if( item.edit_input.getSize().y < input.edit_input.getSize().y )
				{	item.edit_input.setStyle( 'height', input.edit_input.getSize().y );	}
				
				if( item.show_input.getSize().y < input.show_input.getSize().y )
				{	item.show_input.setStyle( 'height', input.show_input.getSize().y );	}
			}.bind(this));
		}
		
		this.height = input.edit_input.getSize().y;
	},
	
	cancel: function()
	{
		this.list.each( function( input ){	input.cancel();	});
		this.list.getFirst().show_input.focus();
	},
	
	edit: function()
	{
		this.list.each( function( input )
		{
			input.edit();
			if( this.options.uni_height ) 
			{	this.autofit( "", input );	}
		}.bind( this ) );
		this.list.getFirst().edit_input.focus();
	},
	
	save: function()
	{
		if( this.options.single_save )
		{
			this.list.each( function( input )
			{
				if( input.type == "text" || input.type == "textarea" )
				{
					input.show_div.addClass( 'hidden' );
					input.edit_div.addClass( 'hidden' );
					input.wait_div.removeClass( 'hidden');
				}
				this.options.args.set( input.show_input.get('name'), input.edit_input.get('value') );
			}.bind( this ) );
			
			if( this.options.debug ){	alert( this.options.save_url + this.options.args.toQueryString() );	}
			
			new Request.JSON(
			{
				url: this.options.save_url + this.options.args.toQueryString(), 
				onComplete: this.change.bind(this)
			}).send();
		}
		else
		{	this.list.each( function( input ){	input.save();	});	}
	},
	
	change: function( ans )
	{
		ans = new Hash( ans );
		
		if( ans.error )
		{
			alert( ans.error_msg );
			this.list.each( function( input )
			{
				input.show_input.set( 'value', input.value );
				input.edit_input.set( 'value', input.value );
			});
		}
		else
		{
			this.list.each( function( input )
			{
				if( $defined( ans.get( input.show_input.get( 'name' ) ) ) )
				{	input.value = ans.get( input.show_input.get( 'name' ) );	}
				
				input.show_input.set( 'value', input.value );
				input.edit_input.set( 'value', input.value );
			});
		}
		
		this.list.each( function( input )
		{
			if( input.type == "text" || input.type == "textarea" )
			{
				input.edit_div.addClass( 'hidden' );
				input.wait_div.addClass( 'hidden' );
				input.show_div.removeClass( 'hidden' );
			}
			
			if( input.type == "textarea" )
			{
				if( this.options.uni_height ) 	{	this.autofit( "" , input );	}
				else							{	input.autofit( "" );	}
			}
		}.bind( this ) );
		
		this.list.getFirst().show_input.focus();
	},
	
	set: function(key, value)
	{
		if (!this[key] || this.hasOwnProperty(key)) this[key] = value;
		return this;
	}
	
});
DI_MULTIPLE.implement( new Options );