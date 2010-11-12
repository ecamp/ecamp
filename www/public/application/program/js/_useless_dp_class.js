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

var border_class = new Class({
	initialize: function()
	{
		this.div 		= $empty;
		this.content 	= $empty;
		this.wait		= $empty;
		this.event_id	= $empty;
	},
	
	show: function(event_id)
	{
		this.event_id = event_id;
		this.div.removeClass('hidden');
		this.load_data();
	},
	
	hide: function()
	{
		load_url = "index.php?app=program&cmd=unlock_event&event_id=" + this.event_id;
		new Request({ url: load_url	 }).send();
		
		$program.event.get(this.event_id).change_in_edition(0, 0);
		
		this.div.addClass('hidden');
		this.wait.removeClass('hidden');
		this.content.addClass('hidden');
	},
	
	load_data: function()
	{
		load_url = "index.php?app=program&cmd=lock_event&event_id=" + this.event_id;
		new Request({ url: load_url	 }).send();
		
		$program.event.get(this.event_id).change_in_edition(1, (new  Date().getTime().toInt()  / 1000 ).round() );
		
		load_url = "index.php?app=program&cmd=load_dp_data&event_id=" + this.event_id;
		new Request.HTML(
		{
			url: load_url,
			onComplete: function(responseTree, responseElements, responseHTML, responseJavaScript)
			{
				this.content.set('html', responseHTML);
				
				$detailprogram.content.make_interactive();
				
				this.wait.addClass('hidden');
				this.content.removeClass('hidden');
				
			}.bind(this)
		}).send();
	}
	
});

var content_class = new Class({
	initialize: function()
	{
		
		
		//this.dp_main_left	= new Fx.Morph( 'dp_main_left',  { duration: 'long', transition: 'bounce:out' });
		//this.dp_main_right	= new Fx.Morph( 'dp_main_right', { duration: 'long', transition: 'bounce:out' });
	},
	
	
	
	make_interactive: function()
	{
		$$('.toggle_border').each(function(item)
		{
			item.getElement('.toggle_content').set('slide', { duration: 1000 ,transition: 'quint:in:out' });
			item.getElement('.toggle_button').addEvent('click', function(e){	
					new Event(e).stop();
					item.getElement('.toggle_content').slide('toggle');
					item.toggleClass('toggle_open');
					if( item.getElement('.d_program_tag_title').getElement('.d_program_tag_title_close') )
					{
						item.getElement('.d_program_tag_title').getElement('.d_program_tag_title_close').toggleClass('hidden');
						item.getElement('.d_program_tag_title').getElement('.d_program_tag_title_open').toggleClass('hidden');
					}
				});
			
			if(!item.hasClass('toggle_open'))
			{	
				item.getElement('.toggle_content').slide('hide');
				if( item.getElement('.d_program_tag_title').getElement('.d_program_tag_title_close') )
				{	
					item.getElement('.d_program_tag_title').getElement('.d_program_tag_title_close').removeClass('hidden');
					item.getElement('.d_program_tag_title').getElement('.d_program_tag_title_open').addClass('hidden');
				}
			}
			
		});		
		
	}
	
});


var $detailprogram = new Hash(
{
	border:		new border_class(),
	content: 	new content_class()
	
});