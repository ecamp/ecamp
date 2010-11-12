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

var event_class = new Class({
	initialize: function( id, name, category, prog, in_edition_by, in_edition_time, responsible )
	{
		this.id 				= id;
		this.name 				= name;
		this.category			= category;
		this.prog				= prog.toInt();
		this.in_edition_by		= in_edition_by;
		this.in_edition_time	= in_edition_time;
		this.in_edition			= false;
		this.event_instance 	= new Array();
		this.responsible		= new Array();
		this.resp_text			= "";
		this.waiting			= false;
		this.locked 			= false;
		
		if($type(this.category) == "number" || $type(this.category) == "string")
		{	this.category = $program.category.get(this.category.toInt());	}
		
		responsible = responsible || new Array();
		responsible.each(function( user )
		{	this.add_responsible_user(user);	}.bind(this));
		
		this.change_progress(this.prog);
		this.change_in_edition(this.in_edition_by, this.in_edition_time);
	},
	
	update: function( id, name, category, prog, in_edition_by, in_edition_time, responsible )
	{
		this.id 				= id;
		this.name 				= name;
		this.category			= category;
		this.prog				= prog.toInt();
		this.in_edition_by		= in_edition_by;
		this.in_edition_time	= in_edition_time;
		
		if($type(this.category) == "number" || $type(this.category) == "string")
		{
			this.category = $program.category.get(this.category.toInt());
			
			this.event_instance.each( function( event_instance )
			{	event_instance.day.renummber_event_instances();	} );
		}
		
		
		this.responsible.empty();
		responsible = responsible || new Array();
		responsible.each(function( user )
		{	this.add_responsible_user(user);	}.bind(this));
		
		this.display();
	},
	
	display: function()
	{
		this.event_instance.each( function( event_instance )
		{	event_instance.display()	});
	},
	
	change_in_edition: function( in_edition_by, in_edition_time )
	{
		this.in_edition_by 		= in_edition_by;
		this.in_edition_time 	= in_edition_time;
		
		if( this.in_edition_by == 0 )
		{	
			this.locked = false;
			this.event_instance.each( function(item){	item.lock_div.addClass('hidden');	} );
		}
		else
		{	
			this.locked = true;
			this.event_instance.each( function(item){	item.lock_div.removeClass('hidden');	} );
		}
	},
	
	change_progress: function( progress )
	{
		this.prog = progress.toInt();
	},
	
	progress_color: function()
	{
		if( this.category.count == 0 )	{	return [75,75,75];	}
		else
		{
			if(this.prog == 100)	{	return [255,255,255];	}
			else					{	return $RGB( ((100 - this.prog) * 2.55).toInt(), (this.prog * 2.55).toInt(), 0);	}
		}
	},
	
	change_name: function( name )
	{
		this.name = name;
		this.event_instance.each(function(item){	item.display();	});
	},
	
	save_change_name: function()
	{
		
		var content = {
					'popup_image': new Element('img').setStyles({'position': 'absolute', 'left': '25px', 'top': '35px', 	'width': '100px', 'height': '100px'}).set('src', 'public/global/img/question.png'),
					'popup_div_oldname': new Element('div').setStyles({'position': 'absolute', 'left': '150px', 'top': '50px', 'width': '150px', 'font-size': '11px'}).set('html', "Alter Blockname:"),
					'popup_div_newname': new Element('div').setStyles({'position': 'absolute', 'left': '150px', 'top': '80px', 'width': '150px', 'font-size': '11px'}).set('html', "Neuer Blockname:"),
					'popup_div_oldname_display': new Element('div').setStyles({'position': 'absolute', 'left': '270px', 'top': '50px', 'width': '200px', 'font-size': '11px'}).set('html', escapeHTML(this.name) ),
					'popup_input_newname': new Element('input').setStyles({'position': 'absolute', 'left': '270px', 'top': '75px', 'width': '200px', 'font-size': '11px'}).set('type', 'text').set('value', this.name),
					'popup_save_button': new Element('input').setStyles({'position': 'absolute', 'right': '180px', 'top': '130px', 'width': '100px'}).set('type', 'button').set('value', 'Sichern'),
					'popup_abort_button': new Element('input').setStyles({'position': 'absolute', 'right': '50px', 'top': '130px', 'width': '100px'}).set('type', 'button').set('value', 'Abbrechen')
					};
		var events 	= { 
					'popup_abort_button': 	function(){	$popup.hide_popup();	},
					'popup_save_button': 	function()
						{
							args = new Hash({
												"event_id": this.id,
												"name": 	$('popup_input_newname').get('value'),
												"time":		$program.last_update_time
											});
							load_url = "index.php?app=program&cmd=change_name&" + args.toQueryString();
							
							this.wait();
							$popup.hide_popup();
							
							new Request.JSON(
							{
								url: load_url, 
								onComplete: function(ans)
								{
									$program.run_update( ans ); //.bind( $program );
																		
									//this.change_name(ans.name);
									this.unwait();
								}.bind(this)
							}).send();
						}.bind(this)
					};
		
		keyevents = {	"enter": events['popup_save_button'], "esc": events['popup_abort_button'] };
		
		fokus	= 'popup_input_newname';
		lock	= true;
		width	= 500;
		height	= 160;
		
		$popup.popup_HTML( "Blockname &auml;ndern", content, events, keyevents, lock, width, height );
		
		content[fokus].focus()
	},
	
	change_category: function( category )
	{
		if( $type(category) == "number" || $type(category) == "string" ){	category = $program.category.get( category.toInt() );	}
		this.category = category;
				
		this.event_instance.each(function(item)
		{	alert("asdf");	item.day.renummber_event_instances();	});
		
		this.display();
	},
	
	save_change_category: function()
	{
		popup_select = new Element('select').setStyles({'position': 'absolute', 'left': '290px', 'top': '75px', 'width': '180px', 'font-size': '11px'});
		$program.category.each(	function(item)
		{
			popup_option = new Element('option').set('html', escapeHTML(item.short + item.name)).set('value', item.id).inject(popup_select);
			if(this.category == item)	{ popup_option.set('selected', 'selected');	}
		}.bind(this) );
		
		var content = {
					'popup_image': new Element('img').setStyles({'position': 'absolute', 'left': '25px', 'top': '35px', 	'width': '100px', 'height': '100px'}).set('src', 'public/global/img/question.png'),
					'popup_div_oldname': new Element('div').setStyles({'position': 'absolute', 'left': '150px', 'top': '50px', 'width': '150px', 'font-size': '11px'}).set('html', "Alte Blockkategorie:"),
					'popup_div_newname': new Element('div').setStyles({'position': 'absolute', 'left': '150px', 'top': '80px', 'width': '150px', 'font-size': '11px'}).set('html', "Neue Blockkategorie:"),
					'popup_div_oldname_display': new Element('div').setStyles({'position': 'absolute', 'left': '290px', 'top': '50px', 'width': '180px', 'font-size': '11px'}).set('html', escapeHTML(this.category.short + this.category.name) ),
					'popup_select_category': popup_select,
					'popup_save_button': new Element('input').setStyles({'position': 'absolute', 'right': '180px', 'top': '130px', 'width': '100px'}).set('type', 'button').set('value', 'Sichern'),
					'popup_abort_button': new Element('input').setStyles({'position': 'absolute', 'right': '50px', 'top': '130px', 'width': '100px'}).set('type', 'button').set('value', 'Abbrechen')
					};
		var events 	= { 
					'popup_abort_button': 	function(){	$popup.hide_popup();	},
					'popup_save_button': 	function()
						{
							args = new Hash({
												"app": "program",
												"cmd": "change_category",
												"event_id": this.id,
												"category_id": 	$('popup_select_category').get('value'),
												"time": $program.last_update_time
											});
							load_url = "index.php?" + args.toQueryString();
							this.wait();
							$popup.hide_popup();
							
							new Request.JSON(
							{
								url: load_url, 
								onComplete: function( ans )
								{
									$program.run_update( ans );
									this.unwait();
								}.bind(this)
							}).send();
						}.bind(this)
					};
					
		keyevents = {	"enter": events['popup_save_button'], "esc": events['popup_abort_button'] };
					
		fokus	= 'popup_select_category';
		lock	= true;
		width	= 500;
		height	= 160;
		
		$popup.popup_HTML( "Kategorie &auml;ndern", content, events, keyevents, lock, width, height );
		
		content[fokus].focus();
	},
	
	add_responsible_user: function( user )
	{
		if($type(user) == "number" || $type(user) == "string")	{	user = $program.user.get(user.toInt());	}
		
		this.responsible.erase( user );
		this.responsible.include( user );
		this.event_instance.each(function(item){	item.display();	});
	},
	
	remove_responsible_user: function( user )
	{
		if($type(user) == "number" || $type(user) == "string")	{	user = $program.user.get(user.toInt());	}
		
		this.responsible.erase( user );
		this.event_instance.each(function(item){	item.display();	});
	},
	
	save_change_responsible_user: function()
	{
		resp_user = new Element('ul');
		user_pool = new Element('ul');
		
		resp_user.setStyle( 'overflow-y', 'scroll' );
		user_pool.setStyle( 'overflow-y', 'scroll' );
		
		$program.user.each(function(user)
		{
			if(this.responsible.contains(user))
			{	new Element('li').inject(resp_user).set( 'html', escapeHTML(user.get_name()) ).set('id', user.id).setStyles( {'cursor': 'move', 'display': 'inline-table', 'margin-right': '4px'} );		}
			else
			{	new Element('li').inject(user_pool).set( 'html', escapeHTML(user.get_name()) ).set('id', user.id).setStyles( {'cursor': 'move', 'display': 'inline-table', 'margin-right': '4px'} );		}
		}.bind(this));
		
		new Sortables([resp_user, user_pool], { 'clone': true } );
		
		var content = {
					'popup_image': new Element('img').setStyles({'position': 'absolute', 'left': '25px', 'top': '35px', 	'width': '100px', 'height': '100px'}).set('src', 'public/global/img/question.png'),
					'popup_div_leader': new Element('div').setStyles({'position': 'absolute', 'left': '160px', 'top': '30px', 'width': '150px', 'font-size': '11px'}).set('html', "Leiter:"),
					'popup_div_resp': new Element('div').setStyles({'position': 'absolute', 'left': '320px', 'top': '30px', 'width': '150px', 'font-size': '11px'}).set('html', "Verantwortliche:"),
					'popup_user_pool': user_pool.setStyles({'position': 'absolute', 'left': '160px', 'top': '45px', 'width': '150px', 'height': '75px', 'font-size': '11px', 'list-style-type': 'none', 'border': '1px solid black'}),
					'popup_resp_user': resp_user.setStyles({'position': 'absolute', 'left': '320px', 'top': '45px', 'width': '150px', 'height': '75px', 'font-size': '11px', 'list-style-type': 'none', 'border': '1px solid black'}),
					'popup_save_button': new Element('input').setStyles({'position': 'absolute', 'right': '180px', 'top': '130px', 'width': '100px'}).set('type', 'button').set('value', 'Sichern'),
					'popup_abort_button': new Element('input').setStyles({'position': 'absolute', 'right': '50px', 'top': '130px', 'width': '100px'}).set('type', 'button').set('value', 'Abbrechen')
					};
		var events 	= { 
					'popup_abort_button': 	function(){	$popup.hide_popup();	},
					'popup_save_button': 	function()
						{
							resp_user = new Array();
							user_pool = new Array();
							
							$$('#popup_resp_user li').each(function(item){	resp_user.include( item.id ); });
							$$('#popup_user_pool li').each(function(item){	user_pool.include( item.id ); });
							
							args = new Hash({ 
												"app":			"program",
												"cmd":			"change_responsible_user",
												"event_id": 	this.id,
												"resp_user": 	resp_user,
												"user_pool": 	user_pool,
												"time": 		$program.last_update_time
											});
							load_url = "index.php?" + args.toQueryString();
							
							this.wait();
							$popup.hide_popup();
							
							new Request.JSON(
							{
								url: load_url, 
								onComplete: function(ans)
								{
									$program.run_update( ans );
									this.unwait();
								}.bind(this)
							}).send(); 
						}.bind(this)
					};
					
		keyevents = {	"enter": events['popup_save_button'], "esc": events['popup_abort_button'] };
					
		fokus	= 'popup_user_pool';
		lock	= true;
		width	= 500;
		height	= 160;
		
		$popup.popup_HTML( "Verantwortliche &auml;ndern", content, events, keyevents, lock, width, height );
		
		content[fokus].focus()
	},
	
	add_event_instance: function( event_instance )
	{	this.event_instance.include( event_instance );	},
	
	remove_event_instance: function (event_instance )
	{	this.event_instance.erase( event_instance );	},
	
	wait: function()
	{
		this.waiting = true;
		this.event_instance.each(function( item ){	item.wait_div.removeClass('hidden');	});
	},
	
	unwait: function()
	{
		this.waiting = false;
		this.event_instance.each(function( item )
		{	if( !(item.event.waiting || item.waiting) ){ item.wait_div.addClass('hidden');	}	});
	},
	
	save_force_unlock: function()
	{
		$popup.popup_yes_no(
			"Zwangsentsperren", 
			"M&ouml;chtest du diesen Block wirklich Zwangsentsperren?",
			function()
			{	
				load_url = "index.php?app=program&cmd=unlock_event&event_id=" + this.id;
				new Request({ 
								url: load_url,
								onSuccess: function(){		this.change_in_edition(0, "0");	}.bind(this)
							}).send();
			}.bind(this), 
			$empty, 
			'popup_no_button');
	},
	
	show: function()
	{	this.event_instance.each( function( item ){	item.show();		});	},
	
	highlight: function()
	{	this.event_instance.each( function( item ){	item.highlight();	});	},
	
	lowlight: function()
	{	this.event_instance.each( function( item ){	item.lowlight();	});	},
	
	remove: function()
	{
		this.event_instance.each(function(item){	item.remove();	});
		$program.event.erase(this.id);
	}
});