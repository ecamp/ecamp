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
 * along with eCamp.  If not, see <www.gnu.org/licenses/>.
 */

window.addEvent('load', function()
{	
	
	var args = new Hash({ "app": "camp", "cmd": "action_save_change" });
	
	new DI_TEXT( 'camp_group_name',	{ 'args': args.set('field', 'group_name'), 'min_level': 50 } );
	new DI_TEXT( 'camp_name',		{ 'args': args.set('field', 'name'), 'min_level': 50 } );
	new DI_TEXT( 'camp_slogan',		{ 'args': args.set('field', 'slogan'), 'min_level': 50 } );
	new DI_TEXT( 'camp_short_name',	{ 'args': args.set('field', 'short_name'), 'min_level': 50 } );
	
	new DI_TEXT( 'camp_ca_name',	{ 'args': args.set('field', 'ca_name'), 'min_level': 50 } );
	new DI_TEXT( 'camp_ca_street',	{ 'args': args.set('field', 'ca_street'), 'min_level': 50 } );
	plz =	new DI_TEXT( 'camp_ca_zipcode',	{ 'args': args.set('field', 'ca_zipcode'), 'min_level': 50 } );
	city =	new DI_TEXT( 'camp_ca_city',	{ 'args': args.set('field', 'ca_city'), 'min_level': 50 } );
	new DI_TEXT( 'camp_ca_tel',		{ 'args': args.set('field', 'ca_tel'), 'min_level': 50 } );

	
	coor = new DI_MULTIPLE([
						{ "type": "text", "element": "camp_ca_coor1", "options": { 'buttons': false, 'min_level': 50 } },
						{ "type": "text", "element": "camp_ca_coor2", "options": { 'buttons': false, 'min_level': 50 } },
						{ "type": "text", "element": "camp_ca_coor3", "options": { 'buttons': false, 'min_level': 50 } },
						{ "type": "text", "element": "camp_ca_coor4", "options": { 'buttons': true, 'min_level': 50 } }
					], { 'single_save': true, 'args': args.set( 'field', 'ca_coor' ), 'min_level': 50 } );
	

	
	var Map = new SearchChMap({ controls: "zoom", zoom: 2, circle:false, autoload: false });	
	var poi = new SearchChPOI({ html:"Lagerplatz" });
	Map.addPOI( poi );
	Map.disable("clickzoom");
	
	if( ! auth.access( 50 ) )
	{	Map.disable("all");	}
	
	
	if( coor.list[0].show_input.get('value') )
	{
		c1 = coor.list[0].show_input.get('value') + 
			 coor.list[1].show_input.get('value');
		c2 = coor.list[2].show_input.get('value') +
			 coor.list[3].show_input.get('value');
		poi.set({ center: [ c1, c2 ] });
		
		Map.set({ center: [ c1, c2 ] });
		Map.init();
	}
	else
	{
		if( plz.show_input.get( 'value' ) )
		{
			Map.set( { center: plz.show_input.get('value') } );
			Map.init();
		}
	}
	
	
	Map.addEventListener( 'change', function(e)
	{
		if( Map.get( 'center' ).capitalize() != city.show_input.get( 'value') ) 
		{
			if( Map.get('center').capitalize() != Map.get('center') )
			{
				city.edit_input.set( 'value', Map.get('center').capitalize() );
				city.save();
			}
		}
	});
	
	
	Map.addEventListener( 'mouseclick', function( e )
	{
		mx1 = (e.mx / 1000).floor();
		mx2 = e.mx - mx1 * 1000;
		
		my1 = (e.my / 1000).floor();
		my2 = e.my - my1 * 1000;
		
		$popup.popup_yes_no(
			"Neue Lagerplatz-Koordinaten", 
			"Sollen die neuen Lagerplatz-Koordinaten <br /> ( " + mx1 + "." + mx2 + " / " + my1 + "." + my2 + " ) gespeichert werden?",
			function()
			{
				coor.list[0].edit_input.set( 'value', mx1 );
				coor.list[1].edit_input.set( 'value', mx2 );
				coor.list[2].edit_input.set( 'value', my1 );
				coor.list[3].edit_input.set( 'value', my2 );
				
				poi.set({ center: [ e.mx, e.my ] });
				Map.set({ center: [ e.mx, e.my ] });

				coor.save();
				
				$popup.hide_popup();
			},
			function(){	$popup.hide_popup();	}, 
			"popup_yes_button"
		);
		
	});
	
	
	plz.addEventListener( 'change', function()
	{
		this.set( { center: plz.show_input.get('value') } );
		this.init();
	}.bind(Map));
	
	
	$$('.camp_input').each( function(item)
	{
		item.getElements('.display').addEvent('click', function()
		{
			item.getElements('.display').addClass('hidden');
			item.getElement('.input').removeClass('hidden');
		});
		
		item.getElements('.input form .cancel_button').addEvent('click', function()
		{
			item.getElements('.input').addClass('hidden');
			item.getElements('.display').removeClass('hidden');
		});	
		
		item.getElements('.input form .ok_button').addEvent('click', function()
		{
			item.getElements('.input').addClass('hidden');
			item.getElements('.wait').removeClass('hidden');
			
			new Request.JSON(
			{
				method: 'get',
				url: 'index.php',
				data: item.getElements('.input form').toQueryString(),
				onComplete: function(ans)
				{
					if(!ans.error)
					{
						item.getElements('.display input').set('value', ans.value );
						if( item.getElements('.input form .input_field') )
						{	item.getElements('.input form .input_field').set('value', ans.value );	}
						
						if( item.getElements('.input form .input_field1') )
						{	item.getElements('.input form .input_field1').set('value', ans.value1 );	}
						if( item.getElements('.input form .input_field2') )
						{	item.getElements('.input form .input_field2').set('value', ans.value2 );	}
						if( item.getElements('.input form .input_field3') )
						{	item.getElements('.input form .input_field3').set('value', ans.value3 );	}
						if( item.getElements('.input form .input_field4') )
						{	item.getElements('.input form .input_field4').set('value', ans.value4 );	}
					}
					else
					{	alert(ans.msg);	}
					
					item.getElements('.wait').addClass('hidden');
					item.getElements('.display').removeClass('hidden');
				}
			}).send();
		});
	});
	
	
	$('camp_show_map').addEvent( 'click', function()
	{
		
		link = new Hash(
		{
			"layer":	"sym,fg,circle",
			"zd":		"1",
			"w":		"1000",
			"h":		"700",
			"poi":		"verkehr,polizei,spital,apotheke,post,shop",
			"base":		$('camp_ca_coor1').get('value') + $('camp_ca_coor2').get('value') +
						"," + 
						$('camp_ca_coor3').get('value') + $('camp_ca_coor4').get('value')
		});
		url = "https://map.search.ch/chmap.jpg?" + link.toQueryString();
		
		window.open( url, "map" );
	});
	
	
	$$('.camp_subcamp').each( function(item)
	{
		item.getElements('td .delete').addEvent('click', function()
		{
			yes_function = function()
			{
				new Request.JSON(
				{
					method: 'get',
					url: 'index.php',
					data: item.getElement('td .delete_form').toQueryString(),
					onComplete: function(ans)
					{
						if(ans.error)
						{	alert(ans.msg);	}
						if(!ans.error)
						{	item.destroy();	}
					}
				}).send();
			}
			
			question = "M&ouml;chtest du den Lagerteil vom " + item.getElement('.date').get('html') + " wirklich l&ouml;schen? Alle enthaltenen Programmbl&ouml;cke werden unwiderruflich gel&ouml;scht!<br /><br />Datum: " + item.getElement('.date').get('html');
			$popup.popup_yes_no("Teillager l&ouml;schen", question, yes_function, function(){}, "popup_no_button");
		});
		
		
		
		item.getElements('td .change').addEvent('click', function()
		{			
			subcamp_start 	= item.getElement('.subcamp_start').get('value');
			subcamp_end 	= item.getElement('.subcamp_end').get('value');
			subcamp_id		= item.getElement('.subcamp_id').get('value');
			
			form = new Element('form');
			form.addEvent('submit', function(){	return false;	});
			
			new Element('div').setStyles({'position': 'absolute', 'left': '25px', 'top': '45px'}).set('text', 'Lagerteil Start:').inject(form);
			new Element('div').setStyles({'position': 'absolute', 'left': '25px', 'top': '75px'}).set('text', 'Lagerteil Ende:').inject(form);
			
			subcamp_new_start_div = new Element('div').setStyles({'position': 'absolute', 'left': '130px', 'top': '40px', 'width': '240px'}).inject(form);
			subcamp_new_start = new Element('input').setStyle('width', '200px').set('type', 'text').set('id', 'subcamp_start').set('name', 'subcamp_start').set('value', subcamp_start).inject(subcamp_new_start_div);
			//new Element('button').setStyles({'position': 'absolute', 'left': '330px', 'top': '40px'}).set('html', "...").inject(form);
			
			subcamp_new_end_div = new Element('div').setStyles({'position': 'absolute', 'left': '130px', 'top': '70px', 'width': '240px'}).inject(form);
			subcamp_new_end = new Element('input').setStyle('width', '200px').set('type', 'text').set('id', 'subcamp_end').set('name', 'subcamp_end').set('value', subcamp_end).inject(subcamp_new_end_div);
			//new Element('button').setStyles({'position': 'absolute', 'left': '330px', 'top': '70px'}).set('html', "...").inject(form);
			
			new Element('input').set('type', 'hidden').set('name', 'app').set('value', 'camp').inject(form);
			new Element('input').set('type', 'hidden').set('name', 'cmd').set('value', 'action_change_subcamp').inject(form);
			new Element('input').set('type', 'hidden').set('name', 'subcamp_id').set('value', subcamp_id).inject(form);
			
			ok_button = function()
			{
				$popup.hide_popup();
				new Request.JSON(
				{
					method: 'get',
					url: 'index.php',
					data: form.toQueryString(),
					onComplete: function(ans)
					{
						if(ans.error)	{	alert(ans.msg);	}
						if(!ans.error)
						{
							window.location.reload();
							
							/*
							item.getElement('.subcamp_start').set('value', ans.subcamp_start );
							item.getElement('.subcamp_end').set('value', ans.subcamp_end );
							
							item.getElement('.date').set('html', ans.subcamp_start + " - " + ans.subcamp_end);
							*/
						}
					}
				}).send();
			}
			
			content = {
						"form": 			form, 
						"cancel_button":	new Element('button').setStyles({'position': 'absolute', 'left': '190px', 'top': '105px', 'width': '85px'}).set('html', 'Abbrechen'),
						"ok_button":		new Element('button').setStyles({'position': 'absolute', 'left': '290px', 'top': '105px', 'width': '85px'}).set('html', 'Speichern')
					};
			events = {
						"ok_button":		ok_button, 
						"cancel_button":	function(){	$popup.hide_popup();	}
					};
			keyevents = {
						"enter":	ok_button, 
						"esc":		function(){	$popup.hide_popup();	}
					};
			
			
			$popup.popup_HTML("Lagerabschnitt ver&auml;ndern:", content, events, keyevents, true, 400, 140);
			
			var blocked_days = new Hash( $_var_from_php.blocked_days );
			blocked_days = blocked_days.filter( function( value, key ){ return ( key != subcamp_id ); } ).getValues().flatten()
			
			new Calendar({ 'subcamp_start': 'd.m.Y' , 'subcamp_end': 'd.m.Y'  }, { navigation: 2 , offset: 1, blocked: blocked_days });
		});
		
		
		
		item.getElements('td .move').addEvent('click', function()
		{
			subcamp_start 	= item.getElement('.subcamp_start').get('value');
			subcamp_id		= item.getElement('.subcamp_id').get('value');
			
			form = new Element('form');
			form.addEvent('submit', function(){	return false;	});
			
			new Element('div').setStyles({'position': 'absolute', 'left': '25px', 'top': '45px'}).set('text', 'Lagerteil Start:').inject(form);
			subcamp_new_start_div = new Element('div').setStyles({'position': 'absolute', 'left': '130px', 'top': '40px', 'width': '240px'}).inject(form);
			subcamp_new_start = new Element('input').setStyle('width', '200px').set('type', 'text').set('id', 'subcamp_start').set('name', 'subcamp_start').set('value', subcamp_start).inject(subcamp_new_start_div);
			
			new Element('input').set('type', 'hidden').set('name', 'app').set('value', 'camp').inject(form);
			new Element('input').set('type', 'hidden').set('name', 'cmd').set('value', 'action_move_subcamp').inject(form);
			new Element('input').set('type', 'hidden').set('name', 'subcamp_id').set('value', subcamp_id).inject(form);
			
			ok_button = function()
			{
				$popup.hide_popup();
				
				new Request.JSON(
				{
					method: 'get',
					url: 'index.php',
					data: form.toQueryString(),
					onComplete: function(ans)
					{
						if(ans.error)	{	alert(ans.msg);	}
						if(!ans.error)
						{
							window.location.reload();
							
							/*
							item.getElement('.subcamp_start').set('value', ans.subcamp_start );
							item.getElement('.subcamp_end').set('value', ans.subcamp_end );
							
							item.getElement('.date').set('html', ans.subcamp_start + " - " + ans.subcamp_end);
							*/
						}
					}
				}).send();
			}
			
			content = {
						"form": 			form, 
						"cancel_button":	new Element('button').setStyles({'position': 'absolute', 'left': '190px', 'top': '75px', 'width': '85px'}).set('html', 'Abbrechen'),
						"ok_button":		new Element('button').setStyles({'position': 'absolute', 'left': '290px', 'top': '75px', 'width': '85px'}).set('html', 'Speichern')
					};
			events = {
						"ok_button":		ok_button, 
						"cancel_button":	function(){	$popup.hide_popup();	}
					};
			keyevents = {
						"enter":	ok_button, 
						"esc":		function(){	$popup.hide_popup();	}
					};
			
			
			$popup.popup_HTML("Lagerabschnitt verschieben:", content, events, keyevents, true, 400, 110);
			
			var blocked_days = new Hash( $_var_from_php.blocked_days );
			blocked_days = blocked_days.filter( function( value, key ){ return ( key != subcamp_id ); } ).getValues().flatten()
			
			new Calendar({ 'subcamp_start': 'd.m.Y' }, { navigation: 2 , offset: 1, blocked: blocked_days });
		});
	});
	
	$$('.add_subcamp').addEvent('click', function()
	{
		form = new Element('form');
		form.addEvent('submit', function(){	return false;	});
		
		new Element('div').setStyles({'position': 'absolute', 'left': '25px', 'top': '45px'}).set('text', 'Lagerteil Start:').inject(form);
		new Element('div').setStyles({'position': 'absolute', 'left': '25px', 'top': '75px'}).set('text', 'Lagerteil Ende:').inject(form);
		
		subcamp_new_start_div = new Element('div').setStyles({'position': 'absolute', 'left': '130px', 'top': '40px', 'width': '240px'}).inject(form);
		subcamp_new_start = new Element('input').setStyle('width', '200px').set('type', 'text').set('id', 'subcamp_start').set('name', 'subcamp_start').inject(subcamp_new_start_div);
		//new Element('button').setStyles({'position': 'absolute', 'left': '330px', 'top': '40px'}).set('html', "...").inject(form);
		
		subcamp_new_end_div = new Element('div').setStyles({'position': 'absolute', 'left': '130px', 'top': '70px', 'width': '240px'}).inject(form);
		subcamp_new_end = new Element('input').setStyle('width', '200px').set('type', 'text').set('id', 'subcamp_end').set('name', 'subcamp_end').inject(subcamp_new_end_div);
		//new Element('button').setStyles({'position': 'absolute', 'left': '330px', 'top': '70px'}).set('html', "...").inject(form);
		
		//new Element('input').setStyles({'position': 'absolute', 'left': '130px', 'top': '40px', 'width': '180px'}).set('type', 'text').set('name', 'subcamp_start').inject(form);
		
		//new Element('input').setStyles({'position': 'absolute', 'left': '130px', 'top': '70px', 'width': '180px'}).set('type', 'text').set('name', 'subcamp_end').inject(form);
		
		new Element('input').set('type', 'hidden').set('name', 'app').set('value', 'camp').inject(form);
		new Element('input').set('type', 'hidden').set('name', 'cmd').set('value', 'action_add_subcamp').inject(form);
		
		
		ok_button = function()
		{
			new Request.JSON(
			{
				method: 'get',
				url: 'index.php',
				data: form.toQueryString(),
				onComplete: function(ans)
				{
					$popup.hide_popup();
					
					if(ans.error)	{	alert(ans.msg);	}
					if(!ans.error)	{	window.location.reload();	}
				}
			}).send();
		}
		
		content = {
					"form": 			form, 
					"cancel_button":	new Element('button').setStyles({'position': 'absolute', 'left': '190px', 'top': '105px', 'width': '85px'}).set('html', 'Abbrechen'),
					"ok_button":		new Element('button').setStyles({'position': 'absolute', 'left': '290px', 'top': '105px', 'width': '85px'}).set('html', 'Erstellen')
				};
		events = {
					"ok_button":		ok_button, 
					"cancel_button":	function(){	$popup.hide_popup();	}
				};
		keyevents = {
					"enter":	ok_button, 
					"esc":		function(){	$popup.hide_popup();	}
				};
		
		
		$popup.popup_HTML("Neuer Lagerabschnitt:", content, events, keyevents, true, 400, 140);
		
		var blocked_days = new Hash( $_var_from_php.blocked_days );
		blocked_days = blocked_days.getValues().flatten();
		
		new Calendar({ 'subcamp_start': 'd.m.Y' , 'subcamp_end': 'd.m.Y'  }, { navigation: 2 , offset: 1, blocked: blocked_days  });
	});
	
});
