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
	$$('.todo_entry').each(function(item)
	{
		
		if( item.getElement('.todo_done input') )
		{
			item.getElement('.todo_done input').addEvent('click', function()
			{
				if( item.getElement('input').get('checked') )
				{	done = 1;	}
				else
				{	done = 0;	}
				
				data = new Hash({
									'app':		'todo',
									'cmd':		'action_done',
									'todo_id':	item.getElement('.todo_id').get('value'),
									'done':		done
								});
				
				new Request.JSON(
				{
					method: 'get',
					url: 'index.php',
					data: data.toQueryString(),
					onComplete: function(ans)
					{
						if(ans.error)
						{	alert(ans.msg);	}
						if(!ans.error)
						{
							if( ans.done == 1 )
							{
								item.getElements('.todo_option img').addClass('hidden');
								item.getElement('input').set('checked', 'checked');
								item.getElement('.todo_done .red').addClass('hidden');
								item.getElement('.todo_done .green').removeClass('hidden');
							}
							else
							{	
								item.getElements('.todo_option img').removeClass('hidden');
								item.getElement('input').set('checked', '');
								item.getElement('.todo_done .green').addClass('hidden');
								item.getElement('.todo_done .red').removeClass('hidden');
							}
						}
					}
				}).send();
				
			});
			
			item.getElement('.todo_del').addEvent('click', function()
			{
				yes_function = function()
				{
					data = new Hash({
										'app':		'todo',
										'cmd':		'action_del_todo',
										'todo_id':	item.getElement('.todo_id').get('value')
									});
					
					new Request.JSON(
					{
						method: 'get',
						url: 'index.php',
						data: data.toQueryString(),
						onComplete: function(ans)
						{
							if(ans.error)
							{	alert(ans.msg);	 }
							if(!ans.error)
							{	item.destroy(); }
						}
					}).send();
				};
				
				$popup.popup_yes_no( "Aufgabe l&ouml;schen", "Willst du diese Aufgabe wirklich l&ouml;schen?", yes_function, function(){}, 'popup_no_button');
			});
			
			item.getElement('.todo_edit').addEvent('click', function()
			{
				
				title 	= item.getElement('.todo_title').get('html');
				text 	= item.getElement('.todo_short').get('html');
				date	= item.getElement('.todo_date_value').get('value');
				id		= item.getElement('.todo_id').get('value');
				
				
				form = new Element('form');
				new Element('div').setStyles({'position': 'absolute', 'left': '30px', 'top': '30px'}).set('html', 'Titel:').inject(form);
				new Element('input').setStyles({'position': 'absolute', 'left': '130px', 'top': '25px', 'width': '240px'}).set('type', 'text').set('name', 'title').set('value', title).inject(form);
				new Element('div').setStyles({'position': 'absolute', 'left': '30px', 'top': '55px'}).set('html', 'Beschreibung:').inject(form);
				new Element('input').setStyles({'position': 'absolute', 'left': '130px', 'top': '50px', 'width': '240px'}).set('type', 'text').set('name', 'text').set('value', text).inject(form);
				new Element('div').setStyles({'position': 'absolute', 'left': '30px', 'top': '80px', 'width': '350px'}).set('html', 'Datum:').inject(form);
				todo_date_input_border = new Element('div').setStyles({'position': 'absolute', 'left': '132px', 'top': '75px', 'right': '20px'}).inject(form);
				new Element('input').setStyles({'width': '200px'}).set('type', 'text').set('name', 'date').set('value', date).set('id', 'input_todo_date').inject(todo_date_input_border);
				
				new Element('input').set('type', 'hidden').set('name', 'app').set('value', 'todo').inject(form);
				new Element('input').set('type', 'hidden').set('name', 'cmd').set('value', 'action_change_todo').inject(form);
				new Element('input').set('type', 'hidden').set('name', 'id').set('value', id).inject(form);
				
				content	= {	
							"form":				form,
							"search_button":	new Element('button').setStyles({'position': 'absolute', 'right': '30px', 'top': '110px', 'width': '90px'}).set('html', 'Sichern'),
							"cancel_button":	new Element('button').setStyles({'position': 'absolute', 'right': '130px', 'top': '110px', 'width': '90px'}).set('html', 'Abbrechen'),
						};
				events	= {
							"cancel_button":	function(){	$popup.hide_popup();	},
							"search_button":	function()
							{
								form.submit();
								$popup.hide_popup();
							},
						};
				
				keyevents = {	"enter": events['popup_save_button'], "esc": events['popup_abort_button'] };
				
				"Neue Aufgabe", content, events, keyevents, true, 400, 140;);
				
				new Calendar({ 'input_todo_date': 'd.m.Y'  }, { navigation: 2 , offset: 1 });
				
				
			});
		};
		
		item.getElements('.todo_resp .resp_user').each(function(resp_user)
		{
			resp_user.getElement('.del_user').addEvent('click', function()
			{
				data = new Hash({
									'app':		'todo',
									'cmd':		'action_del_user',
									'user_id':	resp_user.getElement('.user_id').get('value'),
									'todo_id':	item.getElement('.todo_id').get('value')
								});
				
				new Request.JSON(
				{
					method: 'get',
					url: 'index.php',
					data: data.toQueryString(),
					onComplete: function(ans)
					{
						if(ans.error)
						{	alert(ans.msg);	}
						if(!ans.error)
						{	resp_user.destroy();	}
					}
				}).send();
				
				
			});
		});
	});
	
	
	$$('.drag_user').each(function(item){

		item.addEvent('mousedown', function(e) {
			e = new Event(e).stop();
	 
			var clone = this.clone()
				.setStyles(this.getCoordinates()) // this returns an object with left/top/bottom/right, so its perfect
				.setStyles({'opacity': 0.7, 'position': 'absolute'})
				.inject(document.body);
	 		
			var drag = clone.makeDraggable({
				droppables: $$('.user_droppable'),
				
				onDrop: function(element, droppable)
						{
							if( droppable )
							{
								droppable.setStyle('background-color', '');
								
								todo_id = droppable.getElement('.todo_id').get('value');
								user_id = element.getElement('.user_id').get('value');
								user_name = element.getElement('.user_name').get('value');
								
								data = new Hash({
												'app': 'todo',
												'cmd': 'action_add_user',
												'todo_id': todo_id,
												'user_id': user_id
											});
								
								new Request.JSON(
								{
									method: 'get',
									url: 'index.php',
									data: data.toQueryString(),
									onComplete: function(ans)
									{
										if(ans.error)
										{	alert(ans.msg);	}
										if(!ans.error)
										{
											if( !droppable.getElement('.todo_resp .user_' + user_id) )
											{
												div = new Element('div').addClass('user_' + user_id).addClass('resp_user');
												div.set('html', user_name + ' ').setStyle('display', 'inline');
												div.inject( droppable.getElement('.todo_resp') );
												
												input = new Element('input').set('type', 'hidden').addClass('user_id').set('value', user_id).inject(div);
												img = new Element('img').set('src', 'public/global/img/del.png').addClass('del_user').inject(div);
												
												img.addEvent('click', function()
												{
													data = new Hash({
																		'app':		'todo'	,
																		'cmd':		'action_del_user',
																		'user_id':	user_id,
																		'todo_id':	droppable.getElement('.todo_id').get('value')
																	});
													
													new Request.JSON(
													{
														method: 'get',
														url: 'index.php',
														data: data.toQueryString(),
														onComplete: function(ans)
														{
															if(ans.error)
															{	alert(ans.msg);	}
															if(!ans.error)
															{	div.destroy();	}
														}
													}).send();						
												});
											}
										}
									}
								}).send();
								element.destroy();
							}
							else
							{	element.destroy();	}
						},
				onEnter: function(element, droppable)
				{
					droppable.setStyle('background-color', '#ffffff');
				},
				
				onLeave: function(element, droppable)
				{
					droppable.setStyle('background-color', '');
				}
			}); // this returns the dragged element
	 
			drag.start(e); // start the event manual
		});
		
	 
	});
	
	$$('.todo_new_todo').each(function(item)
	{
		item.addEvent('click', function(){
			
			form = new Element('form');
			new Element('div').setStyles({'position': 'absolute', 'left': '30px', 'top': '30px'}).set('html', 'Titel:').inject(form);
			new Element('input').setStyles({'position': 'absolute', 'left': '130px', 'top': '25px', 'width': '240px'}).set('type', 'text').set('name', 'title').inject(form);
			new Element('div').setStyles({'position': 'absolute', 'left': '30px', 'top': '55px'}).set('html', 'Beschreibung:').inject(form);
			new Element('input').setStyles({'position': 'absolute', 'left': '130px', 'top': '50px', 'width': '240px'}).set('type', 'text').set('name', 'text').inject(form);
			new Element('div').setStyles({'position': 'absolute', 'left': '30px', 'top': '80px', 'width': '350px'}).set('html', 'Datum:').inject(form);
			todo_date_input_border = new Element('div').setStyles({'position': 'absolute', 'left': '132px', 'top': '75px', 'right': '20px'}).inject(form);
			new Element('input').setStyles({'width': '200px'}).set('type', 'text').set('name', 'date').set('id', 'input_todo_date').inject(todo_date_input_border);
			
			new Element('input').set('type', 'hidden').set('name', 'app').set('value', 'todo').inject(form);
			new Element('input').set('type', 'hidden').set('name', 'cmd').set('value', 'action_add_todo').inject(form);
			
			content	= {	
						"form":				form,
						"search_button":	new Element('button').setStyles({'position': 'absolute', 'right': '30px', 'top': '110px', 'width': '90px'}).set('html', 'Sichern'),
						"cancel_button":	new Element('button').setStyles({'position': 'absolute', 'right': '130px', 'top': '110px', 'width': '90px'}).set('html', 'Abbrechen')
					};
			events	= {
						"cancel_button":	function(){	$popup.hide_popup();	},
						"search_button":	function()
						{
							form.submit();
							$popup.hide_popup();
						}
					};
			
			keyevents = {	"enter": events['search_button'], "esc": events['cancel_button'] };
			
			$popup.popup_HTML("Neue Aufgabe", content, events, keyevents, true, 400, 140);
			
			new Calendar({ 'input_todo_date': 'd.m.Y'  }, { navigation: 2 , offset: 1 });
			
		});
	});
	
	$$('.all_todo').addEvent('click',function()
	{
		$$('.user_list_item .user').set('checked', 'checked');
		show_todo();
	});
	
	$$('.no_user_todo').addEvent('click', function()
	{
		$$('.user_list_item .user').set('checked', '');
		$$('.no_user_todo_checkbox .user').set('checked', 'checked');
		show_todo();
	});
	
	$$('.my_todo').addEvent('click', function()
	{
		$$('.user_list_item .user').set('checked', '');
		$$('.real_user').each(function(item)
		{
			if( item.getElement('.user_id').get('value') == $$('.my_todo .user_id').get('value') )
			{	item.getElement('.user').set('checked', 'checked');	}
		});
		show_todo();
	});
	
	$$('.user_list_item .user').addEvent('click', function()
	{
		$$('.selectiv_todo .user').set('checked');
		show_todo();
	});
	
});


show_todo = function()
{
	$$('.todo_entry').addClass('hidden');
	
	$$('.real_user').each(function(real_user)
	{
		if( real_user.getElement('.user').get('checked') )
		{
			user_id = real_user.getElement('.user_id').get('value');
			$$('.todo_entry').each(function(todo_entry)
			{
				if( todo_entry.getElement('.user_' + user_id) )
				{	todo_entry.removeClass('hidden');	}
			});
		}
		
	});
	
	$$('.no_user_todo_checkbox').each(function(no_user_todo)
	{
		if( no_user_todo.getElement('.user').get('checked') )
		{
			$$('.todo_entry').each(function(todo_entry)
			{
				if( todo_entry.getElement('.todo_resp').get('html').trim() == "" )
				{	todo_entry.removeClass('hidden');	}
			});
		}
	});
	
	$$('.todo_today').removeClass('hidden');
	
	$$('.todo_month_title_tbody').each(function(month)
	{
		month.getElements('.todo_month_title_row').addClass('hidden');
		month.getElements('.todo_entry').each(function(todo_entry)
		{
			if( !todo_entry.hasClass('hidden') )
			{	month.getElements('.todo_month_title_row').removeClass('hidden');	}
		});
	});
};