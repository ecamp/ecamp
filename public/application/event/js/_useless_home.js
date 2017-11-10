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

$event_detail = Hash(
{
	load: function()
	{
		make_toggable();
		make_input_autofit();
		make_input_editable();
	},
	
	make_toggable: function()
	{
		$$('.toggle_border').each(function(item)
		{
			
			item.getElement('.toggle_content').set('slide', { duration: 400 ,transition: 'quint:in:out' });
			item.getElement('.toggle_button').addEvent('click', function(e)
				{	
					new Event(e).stop();
					item.getElement('.toggle_content').slide('toggle');
					item.toggleClass('toggle_open');
					if( item.getElement('.d_program_tag_title').getElement('.d_program_tag_title_close') )
					{
						item.getElement('.d_program_tag_title').getElement('.d_program_tag_title_close').toggleClass('hidden');
						item.getElement('.d_program_tag_title').getElement('.d_program_tag_title_open').toggleClass('hidden');
					}
				});
		});
	},
	
	make_input_autofit: function( element )
	{
		if( element )
		{
			element.setStyle( 'height', '30px' );
			if( element.getSize().y < element.getScrollSize().y )
			{	element.setStyle('height', element.getScrollSize().y );	}
		}
		else
		{
			$$('.fit_on_the_fly').each( function(item)
			{
				item.addEvent('keyup', function( )
				{
					if( item.getSize().y < item.getScrollSize().y )
					{	item.setStyle('height', item.getScrollSize().y );	}
				});	
				
				if( item.getSize().y < item.getScrollSize().y )
				{	item.setStyle('height', item.getScrollSize().y );	}
			});
		}
	},
	
	make_input_editable: function()
	{
		$$('.input_form').each(function(item)
		{
			item.getElement('.input_show_border').addEvent('click', function()
			{
				item.getElement('.input_show_border').addClass('hidden');
				item.getElement('.input_edit_border').removeClass('hidden');
				make_input_autofit( item.getElement('.input_edit_border textarea') );
			});
			
			item.getElement('.input_edit_cancel').addEvent('click', function()
			{
				item.getElement('.input_edit_border').addClass('hidden');
				item.getElement('.input_show_border').removeClass('hidden');
				
				item.getElement('.input_edit_border .input_edit').set( 'value', item.getElement('.input_show_border .input_show').get('value') );
			});
			
			
			item.getElement('.input_edit_save').addEvent('click', function()
			{
				item.getElement('.input_edit_border').addClass('hidden');
				item.getElement('.input_wait_border').removeClass('hidden');
				
				new Request.JSON(
				{
					method: 'get',
					url: "index.php",
					data: item.toQueryString(),
					onComplete: function( ans )
					{
						if(ans.saved)
						{
							item.getElement('.input_edit_border .input_edit').set( 'value', ans.value );
							item.getElement('.input_show_border .input_show').set( 'value', ans.value );
							item.getElement('.input_wait_border').addClass('hidden');
							item.getElement('.input_show_border').removeClass('hidden');
							
							make_input_autofit( item.getElement('.input_show_border .input_show') );
						}
						else
						{	$popup.popup_warning("Sichern", "Beim sichern ist ein Fehler aufgetreten.");	}
					}
				}).send();
			});
			
		});
	}
	
	
	
});


$event_detail.load();