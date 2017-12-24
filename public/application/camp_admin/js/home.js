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

	window.addEvent('domready', function()
	{	
		$$('.tooltip').each(function(element,index)
		{
			var content = element.get('title').split('::');
			element.store('tip:title', content[0]);
			element.store('tip:text', content[1]);
		}); 
		
		var ttip = new Tips('.tooltip');
		
		$$('.camp_frame').each(function(item)
		{
			if( item.getElement('.camp_option .delete') )
			{	item.getElement('.camp_option .delete').addEvent('click', function()
				{
					var dodel = prompt( "Willst du dieses Lager wirklich löschen? Es werden alle Daten von diesem Lager unwiederruflich gelöscht! \nZur bestätigung 'Ja' eingeben.", "Nein" );
					if( dodel == "Ja" )
					{
						data_string = "app=camp_admin&cmd=action_del_camp&" + item.getElement('.camp_option .form').toQueryString();
						
						new Request.JSON(
						{
							method: 'get',
							url: "index.php",
							data: data_string,
							onComplete: function( ans )
							{
								if(ans.reload)	{	window.location.reload(); }
								if(ans.del)		{	item.destroy();	}
							}
						}).send();
					}
				});
			}
			if( item.getElement('.camp_option .exit') )
			{	item.getElement('.camp_option .exit').addEvent('click', function()
				{
					yes_function = function()
					{
						data_string = "app=camp_admin&cmd=action_exit_camp&" + item.getElement('.camp_option .form').toQueryString();
						
						new Request.JSON(
						{
							method: 'get',
							url: "index.php",
							data: data_string,
							onComplete: function( ans )
							{
								$popup.popup_warning("Lager verlassen", ans.ans);
								if(ans.exit)	{	item.destroy();	}
							}
						}).send();
					}
					$popup.popup_yes_no("Lager verlassen", "Willst du dieses Lager wirklich verlassen?", yes_function, function(){}, 'popup_yes_button');
				});
			}			
		});
	});
