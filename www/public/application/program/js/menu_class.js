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

var menu_class = new Class({
	
	
	initialize: function( structure )
	{
		this.menu_structure = structure;	// Array mit Struktur des Array's
		this.menu_element = new Hash();		// Hash mit Pointer on DOM - Elements
		
		this.builded = false;
		//this.build( this.menu_element, this.menu_structure );
		
		this.item = $empty;
	},
	
	build: function( base, structure )
	{
		this.bg_div = new Element( 'div' ).inject( $('body') );
		this.bg_div.setStyles( { 'position': 'absolute', 'left': 0, 'right': 0, 'top': 0, 'bottom': 0, 'display': 'none' } );
		this.bg_div.setStyle( 'z-index', 300 );
		this.bg_div.addEvent( 'click', this.hide.bind(this) );
		
		this.build_recursion( base, structure );
		this.menu_element.ul.inject( this.bg_div );
	},
	
	build_recursion: function( base, structure )
	{
		base.set( 'ul', new Element( 'ul' ) );
		base.get( 'ul' ).addClass( 'pmenu' );
		
		structure.each( function( menu_item )
		{
			if( !auth.access( menu_item.min_level ) )
			{	return;	}
			
			if( menu_item.content == "" )
			{
				base.set( menu_item.id, new Element( 'li' ) );
				base.get( menu_item.id ).inject( base.get('ul') );
				base.get( menu_item.id ).set( 'html', menu_item.text );
				base.get( menu_item.id ).addEvent( 'click', menu_item.click.bindWithEvent(this.item, [], this.event) );
				base.get( menu_item.id ).addEvent( 'click', this.hide.bind(this) );
				base.get( menu_item.id ).setStyle( 'cursor', 'default' );
				new Element( 'img' ).set( 'src', menu_item.img ).inject( base.get( menu_item.id ), 'top' );
			}
			if( menu_item.content != "" )
			{
				base.set( menu_item.id, new Hash() );
				
				base.get( menu_item.id ).set( 'li', new Element( 'li' ) );
				base.get( menu_item.id ).get( 'li' ).inject( base.get( 'ul' ) );
				base.get( menu_item.id ).get( 'li' ).addClass( 'parent' );
				base.get( menu_item.id ).get( 'li' ).set( 'html', menu_item.text );
				base.get( menu_item.id ).get( 'li' ).addEvent( 'click', menu_item.click.bindWithEvent(this.item, [], this.event) );
				base.get( menu_item.id ).get( 'li' ).setStyle( 'cursor', 'default' );
				new Element( 'img' ).set( 'src', menu_item.img ).inject( base.get( menu_item.id ).get( 'li' ), 'top' );
				
				this.build_recursion( base.get( menu_item.id ), menu_item.content ).inject( base.get( menu_item.id ).get( 'li' ), 'bottom' );
			}
			
		}.bind( this ) );
		
		return base.get('ul');
	},
	
	set_item: function( item )
	{	this.item = item;	},
	
	show: function( event, item )
	{
		this.item = item || this.item;
		this.event = event || this.event;
		
		this.build( this.menu_element, this.menu_structure );
		
		this.menu_element.ul.setStyles( { 'left': event.page.x, 'top': event.page.y } );
		
		this.menu_element.ul.setStyle( 'display', 'block' );
		this.bg_div.setStyle( 'display', 'block' );
		
		if( item.event )
		{
			item.event.highlight();
			this.bg_div.addEvent( 'mousemove', function(){	item.event.highlight();	});
		}
	},
	
	hide: function()
	{
		this.menu_element.ul.setStyle( 'display', 'none' );
		this.bg_div.setStyle( 'display', 'none' );
		
		this.bg_div.destroy();
		
		this.bg_div.removeEvents( 'mousemove' );
		
		if( this.item.event )
		{	this.item.event.lowlight();	}
		
		this.item = $empty;
	}
});