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

window.addEvent('load', function()
{
	var dorpdown;
		
	new Request.JSON(
	{
		method: 'get',
		url: "index.php",
		data: "app=leader&cmd=load_dropdown",
		onComplete: function( ans )
		{	dropdown = ans;	}
	}).send();
	
	
	$$('.user_data').each( function(item)
	{
		if( item.getElement('.exit') )
		{
			item.getElement('.exit').addEvent('click', function()
			{
				
				
				yes_function = function()
				{
					data = new Hash( {	
						user_camp_id: 	item.getElement('.user_camp_id').get('value'),
						app: 			"leader",
						cmd:			"action_del_user"
					} );
					
					new Request.JSON(
					{
						method: 'get',
						url: 'index.php',
						data: data.toQueryString(),
						onComplete: function(ans)
						{
							if(! ans.error)
							{	item.destroy();	}
							else
							{	alert(ans.msg);		}
						}
					}).send();
				};
				
				$popup.popup_yes_no("Leiter entfernen", "Leiter wirklich entfernen?", yes_function, function(){}, "popup_no_button");
			});
		}
		
		if( auth.access( 40 ) )
		{
			if( item.getElement('.edit' ) )
			{			
				item.getElement( '.edit' ).addEvent( 'click', function()
				{
					function_id = item.getElement( '.function_id' ).get( 'value' );
					user_camp_id = item.getElement( '.user_camp_id' ).get( 'value' );
					
					form = new Element( 'form' );
					form.set( 'action', 'index.php' );
					
					new Element( 'div' ).setStyles({'position': 'absolute', 'left': '20px', 'top': '30px' }).set( 'html', 'Funktion:' ).inject( form );
					
					select_input = new Element('select').set('name', 'function_id').setStyles({'position': 'absolute', 'left': '100px', 'width': '160px', 'top': '25px'}).inject(form);
					
					dropdown.each( function(item)
					{
						if( function_id == item.id )
						{	new Element('option').set('value', item.id).set('html', item.entry).set('selected', 'selected').inject(select_input);	}
						else
						{	new Element('option').set('value', item.id).set('html', item.entry).inject(select_input);	}	
					});
					
					new Element('input').set('type', 'hidden').set('name', 'app').set('value', 'leader').inject(form);
					new Element('input').set('type', 'hidden').set('name', 'cmd').set('value', 'action_change_user_function').inject(form);
					new Element('input').set('type', 'hidden').set('name', 'user_camp_id').set('value', user_camp_id ).inject(form);
					
					
					content	= {	
								"form": 			form,
								"search_button":	new Element('input').setStyles({'position': 'absolute', 'right': '30px', 'top': '60px', 'width': '90px'}).set('type', 'submit').set('value', 'Ändern'),
								"cancel_button":	new Element('button').setStyles({'position': 'absolute', 'right': '130px', 'top': '60px', 'width': '90px'}).set('html', 'Abbrechen')
							};
					events	= {
								"cancel_button":	function(){	$popup.hide_popup(); },
								"search_button":	function(){	form.submit();	}
							};
					keyevents	= {
								"esc":		function(){	$popup.hide_popup(); },
								"enter":	function(){	form.submit();	}
							};
					
					$popup.popup_HTML("Leiter editieren", content, events, keyevents, true, 280, 90);
				});
			}
		}
		else
		{	$$('.edit').addClass('hidden');	}
	});
	
	
	if( auth.access( 40 ) )
	{
		$$('.function_title').each( function(item)
		{
			item.getElement('.add_leader').addEvent('click', function()
			{
				function_id = item.getElement('.function_id').get('value');
				search_form( function_id );
				
			});
		});
	}
	else
	{
		$$('.add_leader').addClass('hidden');
	}
	
	
	search_form = function( function_id )
	{
		user = [];
		
		form = new Element('form');
		form.addEvent( 'submit', function(){	return false;	});
		new Element('div').setStyles({'position': 'absolute', 'left': '20px', 'top': '30px'}).set('html', 'Pfadiname:').inject(form);
		new Element('div').setStyles({'position': 'absolute', 'left': '20px', 'top': '55px'}).set('html', 'Vorname:').inject(form);
		new Element('div').setStyles({'position': 'absolute', 'left': '20px', 'top': '80px'}).set('html', 'Nachname:').inject(form);
		new Element('div').setStyles({'position': 'absolute', 'left': '20px', 'top': '105px'}).set('html', 'E-mail:').inject(form);
		
		new Element('input').setStyles({'position': 'absolute', 'left': '100px', 'top': '25px', 'width': '380px'}).set('name', 'scoutname').set('type', 'text').inject(form);
		new Element('input').setStyles({'position': 'absolute', 'left': '100px', 'top': '50px', 'width': '380px'}).set('name', 'firstname').set('type', 'text').inject(form);
		new Element('input').setStyles({'position': 'absolute', 'left': '100px', 'top': '75px', 'width': '380px'}).set('name', 'surname').set('type', 'text').inject(form);
		new Element('input').setStyles({'position': 'absolute', 'left': '100px', 'top': '100px', 'width': '380px'}).set('name', 'mail').set('type', 'text').inject(form);
		
		new Element('input').set('type', 'hidden').set('name', 'app').set('value', 'leader').inject(form);
		new Element('input').set('type', 'hidden').set('name', 'cmd').set('value', 'action_search_user').inject(form);
		
		content	= {	
					"form": 			form,
					"search_button":	new Element('button').setStyles({'position': 'absolute', 'right': '30px', 'top': '130px', 'width': '90px'}).set('html', 'Suchen'),
					"cancel_button":	new Element('button').setStyles({'position': 'absolute', 'right': '130px', 'top': '130px', 'width': '90px'}).set('html', 'Abbrechen'),
				};
		events	= {
					"cancel_button":	function(){	$popup.hide_popup();	},
					"search_button":	function()
					{
						data = form.toQueryString();

						$popup.hide_popup();

						new Request.JSON(
						{
							method: 'get',
							url: 'index.php',
							data: data,
							onComplete: function(ans)
							{
								result_form( function_id, ans );
							}
						}).send();
						
					}
				};
		keyevents = {	"enter": events['search_button'], "esc": events['cancel_button']	};
		
		
		$popup.popup_HTML("Leiter suchen", content, events, keyevents, true, 500, 160);
		content['form'].getElement( 'input[name=scoutname]' ).focus();
	};
	
	result_form = function( function_id, user_list )
	{
		form = new Element('div');
		var top = 5;
		
		user_list.each( function( item )
		{
			top = top.toInt() + 30 + "px";
			new Element('div').setStyles({'position': 'absolute', 'left': '20px', 'top': top}).set('html', item.scoutname).inject(form);
			new Element('div').setStyles({'position': 'absolute', 'left': '90px', 'top': top}).set('html', item.firstname).inject(form);
			new Element('div').setStyles({'position': 'absolute', 'left': '160px', 'top': top}).set('html', item.surname).inject(form);
			new Element('div').setStyles({'position': 'absolute', 'left': '230px', 'top': top}).set('html', item.city).inject(form);
			top = top.toInt() - 5 + "px";
			
			select_input = new Element('select').setStyles({'position': 'absolute', 'left': '310px', 'width': '80px', 'top': top}).inject(form);
			dropdown.each( function(entry)
			{
				if( function_id == entry.id )
				{	new Element('option').set('value', entry.id).set('html', entry.entry).set('selected', 'selected').inject(select_input);	}
				else
				{	new Element('option').set('value', entry.id).set('html', entry.entry).inject(select_input);	}	
			});
			
			new Element('button').setStyles({'position': 'absolute', 'left': '400px', 'width': '80px', 'top': top}).set('html', "Hinzuf&uuml;gen").inject(form).addEvent('click', function()
			{
				data = new Hash({ "function_id": select_input.get('value'), "add_user_id": item.id , "app": "leader", "cmd": "action_add_known_user" });
				$popup.hide_popup();
				
				new Request.JSON(
				{
					method: 'get',
					url: 'index.php',
					data: data.toQueryString(),
					onComplete: function(ans)
					{
						alert(ans.msg);
						window.location.href = "index.php?app=leader";
					}
				}).send();
			});
			
		});
		
		top = top.toInt() + 40 + "px";
		
		content	= {
					"form": 			form,
					"search_button":	new Element('button').setStyles({'position': 'absolute', 'left': '270px', 'width': '100px', 'top': top}).set('html', 'Neue Suche'),
					"cancel_button":	new Element('button').setStyles({'position': 'absolute', 'left': '390px', 'width': '100px', 'top': top}).set('html', 'Abbrechen')
				};
		events	= {
					"search_button":	function(){	$popup.hide_popup();	search_form( function_id );	},
					"cancel_button":	function(){	$popup.hide_popup();	}
				};
		keyevents	= {
					"enter":	function(){	$popup.hide_popup();	search_form( function_id );	},
					"esc":		function(){	$popup.hide_popup();	}
				};
		
		top = top.toInt() + 30;
		
		$popup.popup_HTML("Leiter finden", content, events, keyevents, true, 500, top);
	}
	
});