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

window.addEvent( 'domready', function()
{

	var view = $('view');
	var libary = $('libary');
	var trash = $('trash');

	var main_content = $(window.document.body).getElement('.main_content');

	var viewsort = new Sortables( [view, trash], 
	{
		clone: true,
		opacity: 0.5,
		handle: 'h1',
		onComplete: function( element )
		{
			if( element.getParent() == trash )
			{	element.destroy();	}
		}
	});
	
	
	$$('li.libary').each( function( item ){		
		item.addEvent( 'mousedown', function( e )
		{
			var e = new Event( e ).stop();
			
			var clone = item.clone();
			clone.setProperty( 'class', item.getProperty('class') );
			
			clone.removeClass( 'libary' ).addClass( 'view' );
			clone.inject( view, 'bottom' );
			
			viewsort.addItems( clone );
			
			clone.fireEvent( 'start' );
			
		});
	});
	
	
	//new Sortable( 'libary' );
	//$('libary').makeSortable();
	
	
	
	
	$('print').addEvent('click', function()
	{		
		var order = new Hash();
		
		view.getElements('li').each( function( item, index )
		{
			if( item.hasClass('title') )
			{
				order.set( 'item[' + index + ']', 'title' );
				//new Element('input').set('type', 'hidden').set('name', 'item[' + index + ']').set('value', 'title').inject(item);
			}
			
			if( item.hasClass('picasso') )
			{
				order.set( 'item[' + index + ']', 'picasso' );
				order.set( 'conf[' + index + ']', item.getElement( 'select' ).get('value') );
			}
			
			if( item.hasClass('allevents') )
			{
				order.set( 'item[' + index + ']', 'allevents' );
				order.set( 'conf[' + index + ']', item.getElement( 'input' ).get('checked') );
			}
			
			if( item.hasClass('event') )
			{
				order.set( 'item[' + index + ']', 'event' );
				order.set( 'conf[' + index + '][event_instance]', item.getElement( 'select' ).get('value') );
				order.set( 'conf[' + index + '][dayoverview]', item.getElement( 'input' ).get('checked') );
			}
			
			if( item.hasClass('toc') )
			{	order.set( 'item[' + index + ']', 'toc' );	}

            if( item.hasClass('notes') )
            {
            	order.set( 'item[' + index + ']', 'notes' );
                order.set( 'conf[' + index + ']', item.getElement( 'input' ).get('value') );
            }
			
			if( item.hasClass('pdf') )
			{
				order.set( 'item[' + index + ']', 'pdf' );
				order.set( 'conf[' + index + ']', 'file_' + index );
				
				item.getElement( 'input' ).set('name', 'file_' + index );
			}
			
		});
		
		$( 'form_view' ).set('action', 'index.php?' + order.toQueryString() );
		$('form_view').submit();
		
		
	});
});