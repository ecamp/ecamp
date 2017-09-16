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
	
	
	//	Materialliste:
	// ================
		
	mat_list_setup = function(item)
	{

		if( item.getElement('.edit') )
		{
			item.getElement('.edit').addEvent( 'click', function()
			{
				content = {
					"name_lable":		new Element('div').setStyles({'position': 'absolute', 'left': '20px', 'top': '30px'}).set('html', 'Neuer Name:'),
					"name_input":		new Element('input').setStyles({'position': 'absolute', 'left': '110px','top': '25px'}).set('value', item.getElement('.mat_list_name').get('html') ),
					
					"save_button":		new Element('button').setStyles({'position': 'absolute', 'left': '210px', 'top': '55px'}).set('html', 'Sichern'),
					"cancel_button": 	new Element('button').setStyles({'position': 'absolute', 'left': '120px', 'top': '55px'}).set('html', 'Abbrechen')
				};
				
				events = {
					"save_button":		function()
										{
											data = new Hash({
																"mat_list_id": item.getElement('.mat_list_id').get('value'),
																"mat_list_name": content["name_input"].get('value'),
																"app": "mat_list",
																"cmd": "action_change_mat_list"
															});
											new Request.JSON(
											{
												method: 'get',
												url: 'index.php',
												data: data.toQueryString(),
												onComplete: function(ans)
												{
													if( ans.error )
													{	alert(ans.msg);	}
													else
													{
														item.getElement('.mat_list_name').set('html', content["name_input"].get('value') );
													}
													$popup.hide_popup();
												}
											}).send();
										},
					"cancel_button":	function()	{	$popup.hide_popup();	}
				};
				
				keyevents = {	"enter": events['save_button'], "esc": events['cancel_button'] };
				
				$popup.popup_HTML("Neuer Name", content, events, keyevents, true, 300, 90);
				content['name_input'].focus();
			});
		}
		
		if( item.getElement('.del') )
		{
		
			item.getElement('.del').addEvent( 'click', function()
			{
				yes_function = function()
				{
					data = new Hash({
						"mat_list_id": item.getElement('.mat_list_id').get('value'),
						"app": "mat_list",
						"cmd": "action_del_mat_list"
					});
					
					new Request.JSON(
					{
						method: 'get',
						url: 'index.php',
						data: data.toQueryString(),
						onComplete: function(ans)
						{
							if(!ans.error)
							{	item.destroy();	}
							else
							{	alert(ans.msg);	}
						}
					}).send();
				};
				
				item.addEvent('click', function()
				{	$popup.popup_yes_no("Einkaufsliste l&ouml;schen", "Diese Einkaufsliste wirklick l&ouml;schen?", yes_function, function(){}, "popup_no_button");	});
	
			});
		}
	};
	
	
	$$('.mat_list li').each( function( item ){	mat_list_setup( item );	} );

	
	$('mat_list_add').addEvent('click', function()
	{
		
		content = {
			"name_lable":		new Element('div').setStyles({'position': 'absolute', 'left': '20px', 'top': '30px'}).set('html', 'Name:'),
			"name_input":		new Element('input').setStyles({'position': 'absolute', 'left': '110px','top': '25px'}),
			
			"save_button":		new Element('button').setStyles({'position': 'absolute', 'left': '210px', 'top': '55px'}).set('html', 'Sichern'),
			"cancel_button": 	new Element('button').setStyles({'position': 'absolute', 'left': '120px', 'top': '55px'}).set('html', 'Abbrechen')
		};
		
		events = {
			"save_button":		function()
								{
									data = new Hash({
														"mat_list_name": content["name_input"].get('value'),
														"app": "mat_list",
														"cmd": "action_add_mat_list"
													});
									
									new Request.JSON(
									{
										method: 'get',
										url: 'index.php',
										data: data.toQueryString(),
										onComplete: function(ans)
										{
											if( ans.error )
											{	alert(ans.msg);	}
											else
											{
												new_list = $('mat_list_example').clone();
												new_list.getElement('.mat_list_name').set( 'html', ans.mat_list_name );
												new_list.getElement('.mat_list_name').set( 'href', "?app=mat_list&listtype=mat_list&list=" + ans.mat_list_id );
												new_list.getElement('.mat_list_id').set( 'value', ans.mat_list_id );
												new_list.inject( 'mat_list_example', 'before' );
												new_list.removeClass('hidden');
												
												
												mat_list_setup( new_list );
											}
											$popup.hide_popup();
										}
									}).send();
								},
			"cancel_button":	function()	{	$popup.hide_popup();	}
		};
		
		keyevents = {	"enter": events['save_button'], "esc": events['cancel_button'] };
		
		$popup.popup_HTML("Neue Einkaufliste", content, events, keyevents, true, 300, 90);
		content['name_input'].focus();
	});
	
	
	
	$$('tr.mat_list_entry').each( function( entry )
	{
		var mat_event_id = entry.getElement( 'td.mat_list_organized input.mat_event_id' ).get( 'value' );
		
		var checkbox = entry.getElement( 'td.mat_list_organized input.mat_event_checkbox' );
		
		checkbox.addEvent( 'click', function()
		{
			data = new Hash({
								"mat_event_id": mat_event_id,
								"organized": checkbox.get('checked'),
								"app": "mat_list",
								"cmd": "action_change_organized"
							});
			
			new Request.JSON(
			{
				method: 'get',
				url: 'index.php',
				data: data.toQueryString(),
				onComplete: function(ans)
				{	if( ans.error ){	alert(ans.msg);	}	}
			}).send();
		});
		
	});
	
});

