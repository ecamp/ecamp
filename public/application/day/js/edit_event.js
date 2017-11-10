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

var edit_event = function( event_instance )
{
	
	popup_input_cat = new Element('select').setStyles({'position': 'absolute', 'left': '270px', 'top': '55px', 'width': '200px', 'height': '15px', 'font-size': '11px'});
	$_var_from_php.categories.each(	function(item)	{	new Element('option').set('html', item.short_name + ': ' + item.name).set('value', item.id).inject(popup_input_cat);	}.bind(this) );
	popup_input_cat.set( 'value', event_instance.category_id );
	
	popup_input_start_h = new Element('select').setStyles({'position': 'absolute', 'left': '270px', 'top': '80px', 'width': '50px', 'height': '15px', 'font-size': '11px'});
	(24).times(function(h){	new Element('option').set('html', h).set('value', h).inject(popup_input_start_h);	});
	popup_input_start_h.set( 'value', ( event_instance.starttime / 60 ).toInt() % 24 );
	
	popup_input_start_min = new Element('select').setStyles({'position': 'absolute', 'left': '330px', 'top': '80px', 'width': '50px', 'height': '15px', 'font-size': '11px'});
	(4).times(function(h){	new Element('option').set('html', (15 * h)).set('value', (15*h) ).inject(popup_input_start_min);	});
	popup_input_start_min.set( 'value', event_instance.starttime % 60 );
	
	popup_input_length_h = new Element('select').setStyles({'position': 'absolute', 'left': '270px', 'top': '105px', 'width': '50px', 'height': '15px', 'font-size': '11px'});
	(24).times(function(h){	new Element('option').set('html', h).set('value', h).inject(popup_input_length_h);	});
	popup_input_length_h.set( 'value', ( event_instance.length / 60 ).toInt() );
	
	popup_input_length_min = new Element('select').setStyles({'position': 'absolute', 'left': '330px', 'top': '105px', 'width': '50px', 'height': '15px', 'font-size': '11px'});
	(4).times(function(h){	new Element('option').set('html', (15 * h)).set('value', (15*h) ).inject(popup_input_length_min);	});
	popup_input_length_min.set( 'value', event_instance.length % 60 );
	
		
	content = {
				'popup_image': new Element('img').setStyles({'position': 'absolute', 'left': '25px', 'top': '35px', 	'width': '100px', 'height': '100px'}).set('src', 'public/global/img/question.png'),
				'popup_div_name': new Element('div').setStyles({'position': 'absolute', 'left': '150px', 'top': '30px', 'width': '150px', 'height': '15px', 'font-size': '11px'}).set('html', "Blockname:"),
				'popup_input_name': new Element('input').setStyles({'position': 'absolute', 'left': '270px', 'top': '30px', 'width': '200px', 'height': '15px', 'font-size': '11px'}).set('type', 'text').set('value', event_instance.name),
				'popup_div_cat': new Element('div').setStyles({'position': 'absolute', 'left': '150px', 'top': '55px', 'width': '150px', 'height': '15px', 'font-size': '11px'}).set('html', "Kategorie:"),
				'popup_input_cat': popup_input_cat,
				'popup_div_start_h':  new Element('div').setStyles({'position': 'absolute', 'left': '150px', 'top': '80px', 'width': '150px', 'height': '15px', 'font-size': '11px'}).set('html', "Startzeit: (h:min)"),
				'popup_input_start_h': popup_input_start_h,
				'popup_input_start_min': popup_input_start_min,
				'popup_div_length_h':  new Element('div').setStyles({'position': 'absolute', 'left': '150px', 'top': '105px', 'width': '150px', 'height': '15px', 'font-size': '11px'}).set('html', "Zeitdauer: (h:min)"),
				'popup_input_length_h': popup_input_length_h,
				'popup_input_length_min': popup_input_length_min,
				
				
				'popup_save_button': new Element('input').setStyles({'position': 'absolute', 'right': '180px', 'bottom': '10px', 'width': '100px'}).set('type', 'button').set('value', 'Sichern'),
				'popup_abort_button': new Element('input').setStyles({'position': 'absolute', 'right': '50px', 'bottom': '10px', 'width': '100px'}).set('type', 'button').set('value', 'Abbrechen')
				};
	events 	= { 
				'popup_abort_button': 	function(){	$popup.hide_popup();	},
				'popup_save_button': 	function()
					{
						args = new Hash({
											"day_id":				event_instance.day_id,
											"event_id":				event_instance.event_id,
											"event_instance_id":	event_instance.id,
											"name": 				$('popup_input_name').get('value'),
											"category_id":			$('popup_input_cat').get('value'),
											"start_h":				$('popup_input_start_h').get('value'),
											"start_min":			$('popup_input_start_min').get('value'),
											"length_h":				$('popup_input_length_h').get('value'),
											"length_min":			$('popup_input_length_min').get('value')
										});
						load_url = "index.php?app=day&cmd=save_edit_event&" + args.toQueryString();
						
						$popup.hide_popup();
						
						new Request.JSON(
						{
							url: load_url, 
							onComplete: function(ans)
							{
								if( ans.error )	{	alert( ans.error_msg );	}
								else			{	document.location = document.location + "&";	}	
							}
						}).send();
					}.bind(this)
				};
	keyevents = {	'enter': 	events['popup_save_button'],
					'esc':		events['popup_abort_button'] };
	
	fokus	= 'popup_input_name';
	lock	= true;
	width	= 500;
	height	= 170;
	
	$popup.popup_HTML( "Neuer Block:", content, events, keyevents, lock, width, height );
	
	content['popup_input_name'].focus();
}