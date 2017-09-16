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
	
	formtype_select = new Element('select').setStyles({'position': 'absolute', 'left': '150px', 'top': '100px', 'width': '230px'});
	
	
	new Request.JSON(
	{
		method: 'get',
		url: "index.php",
		data: "app=option&cmd=load_dropdown",
		onComplete: function( ans )
		{
			dropdown = ans;
			
			dropdown.formtype.each(function(item)
			{	new Element('option').set('value', item.value).set('html', item.entry).inject(formtype_select);	});
		}
	}).send();
	
	
	category_content = 
	{
		"name_lable":		new Element('div').setStyles({'position': 'absolute', 'left': '20px', 'top': '30px'}).set('html', 'Kategoryname:'),
		"short_lable":		new Element('div').setStyles({'position': 'absolute', 'left': '20px', 'top': '55px'}).set('html', 'Abk&uuml;rzung:'),
		"color_lable":		new Element('div').setStyles({'position': 'absolute', 'left': '20px', 'top': '80px'}).set('html', 'Farbe:'),
		"type_lable":		new Element('div').setStyles({'position': 'absolute', 'left': '20px', 'top': '105px'}).set('html', 'Blocktype:'),
		
		"name_input":		new Element('input').setStyles({'position': 'absolute', 'left': '150px', 'top': '25px', 'width': '230px'}).set('type', 'text'),
		"short_input":		new Element('input').setStyles({'position': 'absolute', 'left': '150px', 'top': '50px', 'width': '230px'}).set('type', 'text'),
		"color_input":		new Element('input').setStyles({'position': 'absolute', 'left': '150px', 'top': '75px', 'width': '160px'}).set('type', 'text'),
		"color_picker":		new Element('button').setStyles({'position': 'absolute', 'left': '320px', 'top': '75px', 'width': '65px'}).set('html', 'w&auml;hlen'),
		"formtype_select":	formtype_select,
		
		"save_button":		new Element('button').setStyles({'position': 'absolute', 'left': '290px', 'top': '140px', 'width': '90px'}).set('html', 'Hinzuf&uuml;gen'),
		"cancel_button":	new Element('button').setStyles({'position': 'absolute', 'left': '190px', 'top': '140px', 'width': '90px'}).set('html', 'Abbrechen'),
	};
	
	
	var ColorPicker = new MooRainbow( category_content['color_picker'], 
	{
		'onChange': function(color) {
			category_content['color_input'].value = color.hex;
			category_content['color_input'].setStyle( 'background-color', color.hex );
		},
		imgPath: 'public/module/img/'
	});
	
	
	
	
	
	$$('.new_job_form').each( function(item)
	{
		
		item.getElement('.job_ok').addEvent( 'click', function()
		{
			data = new Hash({
				"job_name": item.getElement('.job_name').get('value'),
				"app": "option",
				"cmd": "action_new_job"
			});
			
			new Request.JSON(
			{
				method: 'get',
				url: 'index.php',
				data: data.toQueryString(),
				onComplete: function(ans)
				{
					if(!ans.error)
					{
						new Element('option').set('value', ans.job_id).set('html', ans.job_name).inject( $('group_normal') );
						item.getElement('.job_name').set('value', "");
					}
					else
					{	alert(ans.msg);	}

					item.getElement('.busy_new').addClass('hidden');
					item.getElement('.job_ok').removeClass('hidden');
					item.getElement('.job_name').removeClass('hidden');
				}
			}).send();
			
			item.getElement('.busy_new').removeClass('hidden');
			item.getElement('.job_ok').addClass('hidden');
			item.getElement('.job_name').addClass('hidden');
		});
	});
	
	
	$$('.job_delete').each( function(item)
	{
		yes_function = function()
		{
			data = new Hash({
				"job_id": $('job_list').get('value'),
				"app": "option",
				"cmd": "action_del_job"
			});
			
			new Request.JSON(
			{
				method: 'get',
				url: 'index.php',
				data: data.toQueryString(),
				onComplete: function(ans)
				{
					if(!ans.error)
					{	$('job_list').getSelected().destroy();	}
					else
					{	alert(ans.msg);	}
				}
			}).send();
		};
		
		item.addEvent('click', function()
		{	$popup.popup_yes_no("Job l&ouml;schen", "Diesen Job wirklick l&ouml;schen?", yes_function, function(){}, "popup_no_button");	});
	});
	
	
	$$('.job_picasso').each( function(item)
	{
		item.addEvent('click', function()
		{
			data = new Hash({
				"job_id": $('job_list').get('value'),
				"app": "option",
				"cmd": "action_change_picasso"
			});
			
			new Request.JSON(
			{
				method: 'get',
				url: 'index.php',
				data: data.toQueryString(),
				onComplete: function(ans)
				{
					if(!ans.error)
					{
						//$('job_list').getSelected().destroy();
						$$('#group_gp option').inject( $('group_normal') );
						$$('#group_normal option').filter( function(item)
								{	
									return item.get('value') == ans.job_id;
								}).inject( $('group_gp') );
					}
					else
					{	alert(ans.msg);	}
				}
			}).send();
			
		});
	});
	
	
	$$('.job_change').each( function(item)
	{
		item.addEvent('click', function()
		{
			content = {
				"name_lable":		new Element('div').setStyles({'position': 'absolute', 'left': '20px', 'top': '30px'}).set('html', 'Neuer Name:'),
				"name_input":		new Element('input').setStyles({'position': 'absolute', 'left': '110px','top': '25px'}).set('value', unescapeHTML($('job_list').getSelected().get('html')) ),
				
				"save_button":		new Element('button').setStyles({'position': 'absolute', 'left': '210px', 'top': '55px'}).set('html', 'Sichern'),
				"cancel_button": 	new Element('button').setStyles({'position': 'absolute', 'left': '120px', 'top': '55px'}).set('html', 'Abbrechen')
			};
			
			events = {
				"save_button":		function()
									{
										var str = content["name_input"].get('value');
										alert(str);
										
										data = new Hash({
															"job_id": $('job_list').getSelected().getLast().get('value'),
															"job_name": content["name_input"].get('value'),
															"app": "option",
															"cmd": "action_change_job"
														});
										new Request.JSON(
										{
											method: 'get',
											url: 'index.php',
											data: data.toQueryString(),
											onComplete: function(ans)
											{
												if(!ans.error)
												{
													$$('option').filter( function(item)
													{	
														return item.get('value') == ans.job_id;
													}).set('html', ans.job_name);
												}
												else
												{	alert(ans.msg);	}
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
	});
	
	$('new_category').addEvent('click', function()
	{
		category_content["save_button"].removeEvents('click');
		category_content["cancel_button"].removeEvents('click');
		
		
		category_content["name_input"].set('value', '');
		category_content["short_input"].set('value', '');
		category_content["color_input"].set('value', '');
		category_content["color_input"].setStyle('background-color', "#ffffff" );
		
		category_content["save_button"].set('text', 'Hinzufügen');
		ColorPicker.manualSet( "#ffffff", "hex" );
		
		events = {
			"cancel_button":	function(){	$popup.hide_popup();	},
			
			"save_button":		function()
			{
				data = new Hash({
								"name": 	$("name_input").get('value'),
								"short":	$("short_input").get('value'),
								"color":	$("color_input").get('value'),
								"type":		$("formtype_select").get('value'),
								"app":		"option",
								"cmd":		"action_add_cat"
							});
				
				new Request.JSON(
				{
					method: 'get',
					url: 'index.php',
					data: data.toQueryString(),
					onComplete: function(ans)
					{
						if(!ans.error)
						{	window.document.location.reload();	}
						else
						{	alert(ans.msg);	}
						$popup.hide_popup();
					}
				}).send();
			}
		};
		
		keyevents = {	"enter": events['save_button'], "esc": events['cancel_button'] };
		
		$popup.popup_HTML("Neue Kategorie", category_content, events, keyevents, true, 400, 170);
		
		category_content['name_input'].focus();
	});
	
	
	$$('.category').each(function(item)
	{
		item.getElement('.edit').addEvent('click', function()
		{
			category_content["save_button"].removeEvents('click');
			category_content["cancel_button"].removeEvents('click');
			
			
			category_content["name_input"].set('value', unescapeHTML(item.getElement('.name').get('html')) );
			category_content["short_input"].set('value', unescapeHTML(item.getElement('.short').get('html')) );
			category_content["color_input"].set('value', item.get('bgcolor') );
			category_content["color_input"].setStyle('background-color', item.get('bgcolor') );
			
			category_content["formtype_select"].getElements('option').each( function( opt )
			{
				if( opt.get('html') == item.getElement('.type' ).get('text') )
				{	opt.set('selected', 'selected' );	}
			});
			
			category_content["save_button"].set('text', 'Speichern');
			ColorPicker.manualSet( item.get('bgcolor'), "hex" );
			
			
			events = {
						"cancel_button":	function(){	$popup.hide_popup();	},
						"save_button":		function()
											{
							                 
												data = new Hash({
																	"cat_id":	item.getElement('.category_id').get('value'),
																	"name": 	$("name_input").get('value'),
																	"short":	$("short_input").get('value'),
																	"color":	$("color_input").get('value'),
																	"type":		$("formtype_select").get('value'),
																	"app":		"option",
																	"cmd":		"action_change_cat"
																});
												new Request.JSON(
												{
													method: 'get',
													url: 'index.php',
													data: data.toQueryString(),
													onComplete: function(ans)
													{
														if(!ans.error)
														{
															item.getElement('.name').set('html', escapeHTML($("name_input").get('value')) );
															item.getElement('.short').set('html', escapeHTML($("short_input").get('value')) );
															item.getElement('.type').set('html', $("formtype_select").getSelected().get('html') );
															item.set('bgcolor', $("color_input").get('value') );
														}
														else
														{	alert(ans.msg);	}
														$popup.hide_popup();
													}
												}).send();
											}
					};

			keyevents = {	"enter": events['save_button'], "esc": events['cancel_button'] };
			
			$popup.popup_HTML("Kategorie editieren", category_content, events, keyevents, true, 400, 170);
			
			category_content['name_input'].focus();
		});
		
		
		item.getElement('.del').addEvent('click', function()
		{
			data = new Hash({
								"category_id": 	item.getElement('.category_id').get('value'),
								"app":		"option",
								"cmd":		"is_del_possible"
							});
			
			new Request.JSON(
			{
				method: 'get',
				url: 'index.php',
				data: data.toQueryString(),
				onComplete: function(ans)
				{
					if(!ans.error && ans.del)
					{
						$popup.popup_yes_no( 
											"Kategorie loeschen", 
											"Willst du diese Kategorie wirklich löschen?", 
											function()
											{
												data = new Hash({
																	"category_id": 	item.getElement('.category_id').get('value'),
																	"app":		"option",
																	"cmd":		"action_del_cat"
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
														$popup.hide_popup();
													}
												}).send();
											},
											function(){},
											"popup_no_button"
										);
					}
					else
					{	alert(ans.msg);	}
				}
			}).send();
		});
	});
	
	
	
	//	Materialliste:
	// ================
	/*
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
																"app": "option",
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
						"app": "option",
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
				}
				
				item.addEvent('click', function()
				{	$popup.popup_yes_no("Einkaufsliste l&ouml;schen", "Diese Einkaufsliste wirklick l&ouml;schen?", yes_function, function(){}, "popup_no_button");	});
	
			});
		}
	}
	
	
	$$('.mat_list tr').each( function( item ){	mat_list_setup( item );	} );

	
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
														"app": "option",
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
												new_list.getElement('.mat_list_id').set( 'value', ans.mat_list_id );
												new_list.inject( 'mat_list_example', 'before' );
												new_list.removeClass('hidden');
												
												new_list.getElement('a').addClass('del');
												
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
	*/
});