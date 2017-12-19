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

/** eCampConfig
	<depend on="public/global/js/mootools-core-1.4.js" type="js" /> <depend on="public/global/js/mootools-more-1.4.js" type="js" />
**/


/******************************************************************************************************************************************************
//**
//**	SHOW's A POPUP
//**  ==================
//**
//**	$popup.popup_warning("TITLE", "WARNING");
//**	$popup.popup_error("TITLE", "ERROR");
//**	$popup.popup_yes_no("TITLE", "WASTION", yes_function, no_function, fokus: {	popup_yes_button; popup_no_button});
//**	$popup.popup_HTML("TITLE", content:†{/list of HTML-Element/}, events: {/list with events/}, screenlock: {true, false}, width, height);
//**
//****************************************************************************************************************************************************/

var popup_class = new Class({
    initialize: function()
	{
		this.keyEvents = new Array();
		
		this.popups = new Array();
		this.actuall_popup = $empty;
	},
	
	show_next_popup: function()
	{		
		if(this.actuall_popup == $empty)
		{
			this.actuall_popup = this.popups[0] || $empty;
			if( this.actuall_popup != $empty && $type(this.actuall_popup) == "object" )
			{	this.create_popup(this.actuall_popup);	}
			else
			{	this.actuall_popup = $empty;	}
		}
	},
	
	hide_popup: function ()
	{
		//window.removeEvents('esc');
		//window.removeEvents('enter');
		$each( this.keyEvents, function( eventFunc )
		{	window.removeEvent('keydown', eventFunc );	});
		
		
		if($defined(this.fullscreen))	{	this.fullscreen.dispose();	}
		this.popups.shift();
		this.actuall_popup = $empty;
		this.show_next_popup();
	},
	
	add_popup: function( item )
	{		
		this.popups.include( item );
		this.show_next_popup();
	},
	
	popup_warning: function( title, text )
	{
		var warning = new Object();
		warning.type = "warning";
		warning.title = title;
		warning.warning = text;
		this.add_popup( warning );
		
	},
	
	popup_error: function( title,  text )
	{
		var error = new Object();
		error.type = "error";
		error.title = title;
		error.error = text;
		this.add_popup( error );
	},
	
	popup_yes_no: function( title, question, yes_function, no_function, fokus )
	{		
		var yes_no = new Object();
		yes_no.type = "yes_no";
		yes_no.title = title;
		yes_no.question = question;
		yes_no.yes_function = yes_function;
		yes_no.no_function = no_function;
		yes_no.fokus = fokus;
		this.add_popup( yes_no );
	},
	
	popup_HTML: function( title, content, events, keyevents, lock, width, height )
	{
		var lock = lock || false;
		var width = width || 500; 
		var height = height || 160;
		var HTML = new Object();
		HTML.type = "HTML";
		HTML.title = title;
		HTML.content = content;
		HTML.events = events;
		HTML.keyevents = keyevents;
		HTML.lock = lock;
		HTML.width = width;
		HTML.height = height;
		this.add_popup( HTML );
	},
	
	popup_HTML_src: function( title, content, events, keyevents, lock, width, height )
	{
		var lock = lock || false;
		var width = width || 500; 
		var height = height || 160;
		var HTML = new Object();
		HTML.type = "HTML_src";
		HTML.title = title;
		HTML.content = content;
		HTML.events = events;
		HTML.keyevents = keyevents;
		HTML.lock = lock && true;
		HTML.width = width;
		HTML.height = height;
		this.add_popup( HTML );
	},
	
	create_popup: function( item )
	{		
		
		var title;
		var content;
		var events;
		var keyevents;
		var fokus;
		var width;
		var height;
		
		if(item.type == "warning")
		{
			title		= item.title;
			content 	= {
								'popup_image': new Element('img').setStyles({
																				'position': 'absolute', 
																				'left': '25px', 'top': '35px', 
																				'width': '100px;', 'height': '100px'
																			}).set('src', 'public/global/img/warning.png'),
								'popup_div': new Element('div').setStyles({
																				'position': 'absolute', 
																				'left': '150px', 'top': '30px', 
																				'width': '320px', 'height': '90px', 
																				'font-size': '13px'
																			}).set('html', item.warning),
								'popup_ok_button': new Element('input').setStyles({	
																			 	'position': 'absolute', 
																				'right': '100px', 'top': '130px', 
																				'width': '100px'
																			}).set('type', 'button').set('value', 'OK')
							};
			events 		= { 'popup_ok_button': function(){	$popup.hide_popup();	}	};
			keyevents	= {
								'esc': 		function(){	$popup.hide_popup();	}, 
								'enter':	function(){	$popup.hide_popup();	}
							};
			fokus		= 'popup_ok_button';
			lock		= true;
			width		= 500;
			height		= 160;
		}
		else if(item.type == "error")
		{
			title 		= item.title;
			content		= {
								'popup_image': new Element('img').setStyles({
																				'position': 'absolute', 
																				'left': '25px', 'top': '35px', 
																				'width': '100px;', 'height': '100px'
																			}).set('src', 'public/global/img/error.png'),
								'popup_div': new Element('div').setStyles({
																				'position': 'absolute', 
																				'left': '150px', 'top': '30px', 
																				'width': '320px', 'height': '90px', 
																				'font-size': '13px'
																			}).set('html', item.error),
								'popup_ok_button': new Element('input').setStyles({	
																			 	'position': 'absolute', 
																				'right': '100px', 'top': '130px', 
																				'width': '100px'
																			}).set('type', 'button').set('value', 'OK')
							};
			events		= { 'popup_ok_button': function(){	$popup.hide_popup();	}	};
			keyevents	= {
								'esc': 		function(){	$popup.hide_popup();	}, 
								'enter':	function(){	$popup.hide_popup();	}
							};
			fokus		= 'popup_ok_button';
			lock		= true;
			width		= 500;
			height		= 160;
		}
		else if(item.type == "yes_no")
		{
			
			title		= item.title;
			content		= {
								'popup_image': (new Element('img')).setStyles({
																				'position': 'absolute', 
																				'left': '25px', 'top': '35px', 
																				'width': '100px', 'height': '100px'
																			}).set('src', 'public/global/img/question.png'),
								'popup_div': (new Element('div')).setStyles({
																				'position': 'absolute', 
																				'left': '150px', 'top': '30px', 
																				'width': '320px', 'height': '90px', 
																				'font-size': '13px'
																			}).set('html', item.question),
								'popup_yes_button': (new Element('input')).setStyles({	
																				'position': 'absolute', 
																				'right': '170px', 'top': '130px', 
																				'width': '100px'
																			}).set('type', 'button').set('value', 'Ja'),
								'popup_no_button': (new Element('input')).setStyles({
																				'position': 'absolute', 
																				'right': '50px', 'top': '130px', 
																				'width': '100px'
																			}).set('type', 'button').set('value', 'Nein')
							};
			events		= { 
								'popup_yes_button':	function(){	item.yes_function();	$popup.hide_popup();	},
								'popup_no_button':	function(){	item.no_function();		$popup.hide_popup();	}
							};
			keyevents	= {
								'esc': 		function(){	item.no_function();		$popup.hide_popup();	}, 
								'enter':	function(){	item.yes_function();	$popup.hide_popup();	}
							};
			fokus		= item.fokus;
			lock 		= true;
			width		= 500;
			height		= 160;
			
		}
		else if(item.type == "HTML")
		{
			title		= item.title;
			content		= item.content;
			events		= item.events;
			fokus		= "";
			lock		= item.lock;
			width		= item.width;
			height		= item.height;
			keyevents 	= item.keyevents;
		}
		
		else if(item.type == "HTML_src")
		{
			title		= item.title;
			events		= item.events;
			fokus		= "";
			lock		= item.lock;
			width		= item.width;
			height		= item.height;
			
			content = {	'content': new Element('div').setStyles({
														'position': 'absolute', 
														'left': '0px', 'right':'0px', 
														'top': '15px' , 'bottom': '0px',
														'border': '1px solid black',
														'font-size': '13px',
														'padding' : '20px'
													  }).set('html', item.content )
					}
			keyevents 	= item.keyevents;
		}
		
		var marginleft = ( width / -2 ) + 'px';
		var margintop  = ( height / -2 ) + 'px';
		var margintop_title = ( height / -2 ) - 16  + 'px';
		width = width + 'px';
		height = height + 'px';
		
		
		this.fullscreen = new Element('div');
		this.fullscreen.setStyles({
									'position': 'fixed', 
									'left': '0px', 'right': '0px', 
									'top': '0px', 'bottom': '0px'
									}).setStyle('z-index', 1000);
		if(lock) {	this.fullscreen.setStyle('background-image', 'url(public/global/img/transparent.png)');	}
		this.fullscreen.inject(document.body);
		
		
		popup_frame = new Element('div');
		popup_frame.setStyles({
								'position': 'absolute', 
								'left': '50%', 'top':'50%', 
								'width': width , 'height': height, 
								'margin-left': marginleft, 'margin-top': margintop, 
								'background-color':'#dddddd', 
								'border': '1px solid black',
								'-moz-border-radius': '5px',
								'-khtml-border-radius': '5px'
							});
		popup_frame.inject(this.fullscreen);
		
		
		popup_title = new Element('div');
		popup_title.setStyles({
								'position': 'absolute', 
								'left': '0px', 'right':'0px', 
								'top': '0px' , 'height': '15px',  
								'background-color':'#000000', 
								'border': '1px solid black',
								'font-size': '13px',
								'color': '#dddddd'
							  });
		popup_title.set('align', 'center');
		popup_title.inject(popup_frame);
		popup_title.set('html', title);
		
		
		
		$each(content, 	function(element, index){	element.inject(popup_frame).set('id', index);	});
		$each(events, 	function(element, index){	$(index).addEvent('click', element);	});
		
		$each(keyevents, function( f, index )	
		{
			eventFunc =  function( e ){	if(e.key == index){	f.run();	} };
			
			this.keyEvents.include( eventFunc );
			
			window.addEvent( 'keydown', eventFunc );
		}.bind(this) );
		
		if($defined(fokus) && fokus != ""){	$(fokus).focus();	}
		
	}
});

var $popup = new popup_class();


/*
var temp = {	'test': "Hallo", 2: "Hallo"	};
$each(temp, function(item, index){	alert(index + ": " + item);	});
*/
