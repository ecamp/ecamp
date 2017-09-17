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

Asset.css( "public/application/event/css/home.css" );
Asset.css( "public/application/event/css/autocompliter.css" );
Asset.css( "public/global/css/tips.css" );

$event = new Hash(
{
	div: 0,
	id: 0,
	loading: 0,
	update_background: function(){},
	mat_organize_select_content: 0,
	
	aim_checked: new Hash(),
	checklist_checked: new Hash(),
	
	edit: function( event_id ){
		if($(this.div)){this.div.destroy();}
		this.div = new Element('div').inject('body');
		
		this.show_loading();
		
		new Request.HTML({
			url:		'index.php?app=event&event_id=' + event_id,
			onSuccess: 	function( responseTree, responseElements, responseHTML, responseJavaScript )
			{
				this.id = event_id;
				
				this.div.set( 'html', '' );
				this.div.set( 'html', responseHTML );
				
				this.hide_loading();
				this.setup_function();
			}.bind(this)
		}).send();
	},
	
	close: function(){
		this.id = 0;
		this.div.destroy();
	},
	
	show_loading: function(){
		this.loading = new Element( 'div').inject('body');
		
		this.loading.setStyle( 'position', 'absolute' );
		this.loading.setStyle( 'border', '2px solid black' );
		this.loading.addClass( 'bgcolor_dp_dark' );
		
		this.loading.setStyle( 'left', '50%' );
		this.loading.setStyle( 'top', '50%' );
		
		this.loading.setStyle( 'width', '200px' );
		this.loading.setStyle( 'height', '50px' );
		
		this.loading.setStyle( 'margin-left', '-100px' );
		this.loading.setStyle( 'margin-top', '-25px' );
		
		this.loading.setStyle( 'text-align', 'center' );
		
		this.loading.set('html', '<h1 style="font-size:20px">Laden...</h1>');
		this.loading.set( 'z-index', 10000)
	},
	
	hide_loading: function(){
		if( $( this.loading ) )		{	this.loading.destroy();	}
	},
	
	keydown: function( event ) {
		if( !this.id ){	return;	}
		
		if( event.key == "q" && event.meta )
		{
			new Event(event).stop();
			this.close();
		}
		
		if( event.key == "w" && event.meta )
		{
			new Event(event).stop();
			this.close();
		}
		
		if( event.key == "f4" && event.alt )
		{
			new Event(event).stop();
			this.close();
		}
	},
	
	setup_function: function() {
		//	Fortschritt:
		// ==============
		this.event_progress = new DI_SELECT('event_progress',{'args':{'app':'event','cmd':'action_change_progress','event_id':this.id},'changed':this.update_background,'min_level':40});
		if( auth.access( 40 )){this.event_progress.show_input.focus();}
		
		new DI_MSELECT($('event_dp_header_resp'),{'args':{'app':'event','cmd':'action_change_resp','event_id':this.id},'changed':this.update_background,'min_level':40});
		
		if( $('edit_aim') ) {
			this.aim_checked.empty();
			
			$each( $_var_from_php.course_aim, function( item )
			{	$each( item.childs, function( item )
				{	this.aim_checked.set( item.id, item.checked );	}.bind(this) );
			}.bind(this) );
			
			if( auth.access( 40 ) )
			{
				$('edit_aim').addEvent( 'click', function()
				{	this.edit_aim();	}.bind( this ));
			}
			else
			{	$('edit_aim').addClass('hidden');	}
		}
		
		if( $('edit_checklist') )
		{
			this.checklist_checked.empty();
			
			$each( $_var_from_php.course_checklist, function( item )
			{	$each( item.childs, function( item )
				{	this.checklist_checked.set( item.id, item.checked );	}.bind(this) );
			}.bind(this) );
		
			if( auth.access( 40 ) )
			{
				$('edit_checklist').addEvent( 'click', function()
				{	this.edit_checklist();	}.bind( this ));
			}
			else
			{	$('edit_checklist').addClass('hidden');	}
		}
		
		if( $('edit_aim') || $('edit_checklist') )
		{	this.setup_course();	}
		
		//	Dynamic Inputs:
		// =================
		new DI_TEXTAREA( 'event_dp_head_story',  { 'args': { 'app': 'event', 'cmd': 'action_change_story', 	'event_id': this.id }, "button_pos": "bottom", min_level: 40 } );
		new DI_TEXTAREA( 'event_dp_head_aim', 	 { 'args': { 'app': 'event', 'cmd': 'action_change_aim', 	'event_id': this.id }, "button_pos": "bottom", min_level: 40 } );
		new DI_TEXTAREA( 'event_dp_head_method', { 'args': { 'app': 'event', 'cmd': 'action_change_method', 'event_id': this.id }, "button_pos": "bottom", min_level: 40 } );
		new DI_TEXTAREA( 'event_dp_head_topics', { 'args': { 'app': 'event', 'cmd': 'action_change_topics', 'event_id': this.id }, "button_pos": "bottom", min_level: 40 } );
		
		new DI_TEXT( 'event_dp_header_place', 	 { 'args': { 'app': 'event', 'cmd': 'action_change_place', 	'event_id': this.id }, "button_pos": "bottom", min_level: 40 } );
		
		new DI_TEXTAREA( 'event_dp_siko_siko',	 { 'args': { 'app': 'event', 'cmd': 'action_change_siko', 	'event_id': this.id }, "button_pos": "bottom", min_level: 40 } );
		new DI_TEXTAREA( 'event_dp_siko_note', 	 { 'args': { 'app': 'event', 'cmd': 'action_change_notes', 	'event_id': this.id }, "button_pos": "bottom", min_level: 40 } );

		$$('#d_program_sort .dp_event_detail').each( this.event_detail_setup.bind(this) );
		
		if( auth.access( 40 ) )
		{	$$( 'input.dp_add_detail' ).addEvent( 'click', this.event_detail_add.bind(this) );	}
		else
		{	$$( 'input.dp_add_detail' ).addClass('hidden');	}

		//	Material:
		// ===========
		this.mat_available_di 	= new DI_TABLE( $( 'mat_available_table' ),{
			args:	{ 'app': 'event', 'cmd': 'action_change_mat_available', 'event_id': this.id },
			inputs:	{	1: {	'width': 0.1	},	2: {	'width': 0.8	},	3: {	'width': 0.1	}	},
			min_level: 40
		});
									
		this.mat_organize_di	= new DI_TABLE( $( 'mat_organize_table' ),{
			args:	{ 'app': 'event', 'cmd': 'action_change_mat_organize', 'event_id': this.id },
			inputs: {
				1:	{	'width': 0.1, 'type': 'text', 'value': ''	},
				2:	{	'width': 0.6, 'type': 'text', 'value': ''	},
				3:	{	'width': 0.2, 'type': 'select', 'options': $_var_from_php.mat_organize_resp },
														
				4:	{	'width': 0.1	}
			},
			min_level: 40
		});
		
		if(auth.access( 40 )){
			new Autocompleter.Local(this.mat_organize_di.inputs.get(2),$_var_from_php.mat_article_list,{'minLength':1,'selectMode':'type-ahead','multiple':false});
			$$('ul.autocompleter-choices').setStyle( 'z-index', 1100 );
			
			this.mat_organize_di.inputs.get(1).set('maxlength',10);
			this.mat_available_di.inputs.get(1).set('maxlength',10);
		}
		
		//	File-Upload:
		// ==============
		$$( '#dp_pdf_button input' ).addEvent( 'click', function(){	this.$file_upload.open_uploader();	}.bind(this) );
		$$( 'tbody.event_document_list tr' ).each( this.file_setup.bind(this) );

		//	Comments:
		// ===========
		$('comment_save').addEvent('click', function()
		{
			args = new Hash(
			{
				"app":		"event",
				"cmd":		"action_add_comment",
				"event_id":	this.id,
				"text":		$('comment_text').get('value')
			});
			
			
			new Request.JSON(
			{
				url: "index.php?" + args.toQueryString(),
				onComplete: function( ans )
				{
					if( ans.error )
					{	alert( ans.error_msg );	}
					else
					{
						new_title 	= $('comment_head_example').clone();
						new_content = $('comment_content_example').clone();
						
						new_title.getElement('i.name').set('html', ans.user );
						new_title.getElement('td.date').set('html', ans.date );
						new_content.getElement('td.text').set('html', ans.text );
						
						new_title.addClass( ans.id );
						new_content.addClass( ans.id );
						new_title.getElement('input').addClass( 'comment_id' ).set( 'value', ans.id );
						
						new_title.inject( 'comment_tbody' );
						new_content.inject( new_title, 'after' );
						
						new_title.removeClass('hidden');
						new_content.removeClass('hidden');
						
						$('comment_text').set('value', '');
						
						this.comment_setup( ans.id );
					}
				}.bind(this)
			}).send();
		}.bind(this));
				
		$('comment_tbody').getElements( 'tr td input.comment_id' ).each( function( comment )
		{	if( comment.get('value') ){	this.comment_setup( comment.get('value' ) );	}	}.bind( this ));

		//	Tool-Tip:
		//============
		$$('.tooltip').each(function(element,index)
		{
			var content = element.get('title').split('::');
			element.store('tip:title', content[0]);
			element.store('tip:text', content[1]);
		});
		new Tips('.tooltip').addEvent('show', function(tip){	tip.setStyle('z-index', 5000);	});
	},

	setup_course: function()
	{
		$('course_aim_list').empty();
		$('course_checklist_list').empty();
		
		$each( $_var_from_php.course_aim, function( item )
		{	$each( item.childs, function( item )
			{
				if( this.aim_checked.get(item.id) == 1 )
				{	new Element('li').set('html', escapeHTML(item.aim) ).inject( 'course_aim_list' );	}
			}.bind(this) );
		}.bind(this) );
		
		$each( $_var_from_php.course_checklist, function( item )
		{	$each( item.childs, function( item )
			{
				if( this.checklist_checked.get( item.id ) == 1 )
				{	new Element('p').set('html', escapeHTML(item.display) ).inject( 'course_checklist_list' );	}
			}.bind(this) );
		}.bind(this) );
	},

	event_detail_setup: function( detail )
	{
		new DI_MULTIPLE([
			{ "type": "text", 		"element": detail.getElement('.d_program_cell_time    input'), 	  "options": { "args": {}, "buttons": false } },
			{ "type": "textarea", 	"element": detail.getElement('.d_program_cell_content textarea'), "options": { "args": {}, "buttons": false } },
			{ "type": "textarea", 	"element": detail.getElement('.d_program_cell_resp    textarea'), "options": { "args": {}, "button_pos": "bottom" } },
			{ "type": "hidden",		"element": detail.getElement('.detail_id'), 					  "options": { "args": {} } }
		],
		{ 'args': { 'app': 'event', 'cmd': 'action_change_detail' }, 'uni_height': false, "single_save": true });
		
		detail.getElement('.d_program_cell_option .delete').addEvent( 'click', this.event_detail_delete.pass( detail ) );
		
		detail.getElement('.d_program_cell_option .up').addEvent( 'click', this.event_detail_move_up.pass( detail ) );
		detail.getElement('.d_program_cell_option .down').addEvent( 'click', this.event_detail_move_down.pass( detail ) );
	},
	
	event_detail_add: function()
	{
		args = new Hash(
		{
			"app": 		"event",
			"cmd": 		"action_add_detail",
			"event_id": this.id
		});
		
		load_url = "index.php?" + args.toQueryString();
		
		new Request.JSON(
		{
			url: load_url,
			onComplete: function( ans )
			{
				if( ans.error )
				{	alert( ans.error_msg );	}
				else
				{
					new_detail = $('dp_event_detail_example').clone();
					new_detail.removeClass('hidden').inject( $('d_program_sort'), 'bottom' );
					new_detail.getElement( 'input.detail_id' ).set( 'value', ans.event_detail_id );
					
					this.event_detail_setup( new_detail );
				}
			}.bind(this)
		}).send();
	},
	
	event_detail_delete: function( event_detail )
	{
		$popup.popup_yes_no( 
			"Löschen", 
			"Möchtest du dieses Detail löschen?", 
			function()
			{
				args = new Hash(
				{
					"app": 			"event",
					"cmd": 			"action_delete_detail",
					"detail_id":	event_detail.getElement('.detail_id').get('value')
				});
				
				load_url = "index.php?" + args.toQueryString();
				
				new Request.JSON(
				{
					url: load_url, 
					onComplete: function( ans )
					{
						if( ans.error )
						{	alert( ans.error_msg );	}
						else
						{	event_detail.destroy();	}
					}
				}).send();
			}, 
			function(){}, 
			'popup_yes_button'
		);
	},
	
	event_detail_move_up: function( event_detail )
	{
		var prev = event_detail.getPrevious('.dp_event_detail');
		if( prev )
		{
			args = new Hash(
			{
				"app":			"event",
				"cmd":			"action_move_detail",
				"direction":	"up",
				"detail_id":	event_detail.getElement('.detail_id').get('value')
			});
			
			load_url = "index.php?" + args.toQueryString();
			
			new Request.JSON(
			{
				url: load_url,
				onComplete: function( ans )
				{
					if( ans.error )	{	alert( ans.error_msg );	}
					else			{	event_detail.grab( prev, 'after' );	}
				}
			}).send();
		}
	},
	
	event_detail_move_down: function( event_detail )
	{
		var next = event_detail.getNext('.dp_event_detail');
		if( next )
		{
			args = new Hash(
			{
				"app":			"event",
				"cmd":			"action_move_detail",
				"direction":	"down",
				"detail_id":	event_detail.getElement('.detail_id').get('value')
			});
			
			load_url = "index.php?" + args.toQueryString();
			
			new Request.JSON(
			{
				url: load_url,
				onComplete: function( ans )
				{
					if( ans.error )	{	alert( ans.error_msg );	}
					else			{	event_detail.grab( next, 'before' );	}
				}
			}).send();
		}
	},
	
	
	file_setup: function( item )
	{
		file_id = item.getElement('input.file_id').get('value');
		
		item.getElement('td img.file_del').addEvent( 'click', function()
		{
			$popup.popup_yes_no("Datei löschen", "Datei wirklich löschen?", this.file_delete.pass( item ), function(){}, "popup_no_button" );
		}.bind(this) );
		
		item.getElement('td input.file_print').addEvent('click', function()
		{
			this.file_print(
				item.getElement('td input.file_print').get('value'),
				item.getElement('td input.file_id').get('value')
			);
		}.bind(this));
	},

	file_delete: function( item )
	{
		args = new Hash(
		{
			"app": 		"event",
			"cmd": 		"action_file_delete",
			"file_id":	item.getElement('input.file_id').get('value')
		});
		
		load_url = "index.php?" + args.toQueryString();
		
		new Request.JSON(
		{
			url: load_url,
			onComplete: function( ans )
			{
				if( ans.error )
				{	alert( ans.error_msg );	}
				else
				{	item.destroy(); }
			}
		}).send();
	},
	
	file_print: function( print, document_id )
	{
		args = new Hash(
		{
			"app":					"event",
			"cmd":					"action_file_print",
			"event_document_id":	document_id,
			"print":				print
		});
		
		load_url = "index.php?" + args.toQueryString();
		
		new Request.JSON(
		{
			url: load_url,
			onComplete: function( ans )
			{
				if( ans.error )	{	alert( ans.error_msg );	}
				else			{		}
			}
		}).send();
	},
	
	$file_upload: new Hash(
	{
		open_uploader: function()
		{
			args = new Hash(
			{
				"app":		"event",
				"cmd":		"file_upload_form",
				"event_id":	$event.id
			});
			
			load_url = "index.php?" + args.toQueryString();
			var content = {
				'iframe':	new IFrame({ src: load_url}).setStyles({'position': 'absolute', 'left': '0px', 'width': '400px', 'top': '20px', 'height': '180px', 'border': 'none' })
			};
			var events 	= {};
			var keyevents = {};
			
			lock	= true;
			width	= 400;
			height	= 200;
			
			$popup.popup_HTML( "Datei hinzufügen", content, events, keyevents, lock, width, height );
		},
		
		add_file: function( file )
		{
			new_file = $$( 'tr.event_document_sample' ).clone();
			new_file.inject( $$('tbody.event_document_list').getLast(), 'bottom' );
			
			new_file.getElement('td.name').set( 'html', file.filename );
			new_file.getElement('input.file_id').set('value', file.id );
			new_file.getElement('img.file_icon').set('src', file.type_img_src );
			new_file.getElement('a.download_link').set('href', file.download_link );
			
			new_file.removeClass( 'event_document_sample' );
			new_file.removeClass( 'hidden' );

			$event.file_setup( new_file );
		}
	}),
	
	comment_setup: function( comment_id )
	{
		$('comment_tbody').getElement( 'tr.' + comment_id + ' td img.del' ).setStyle( 'cursor', 'pointer' );
		$('comment_tbody').getElement( 'tr.' + comment_id + ' td img.del' ).addEvent( 'click', function()
		{
			$popup.popup_yes_no(
				"Kommentar löschne", 
				"Kommentar wirklich löschen?", 
				function()
				{
					args = new Hash(
					{
						"app":			"event",
						"cmd":			"action_del_comment",
						"comment_id":	comment_id,
						"event_id":		$event.id
					});
					load_url = "index.php?" + args.toQueryString();
					
					new Request.JSON(
					{
						url: load_url,
						onComplete: function( ans )
						{
							if( ans.error )	{	alert( ans.error_msg );	}
							else			{	$('comment_tbody').getElements( 'tr.' + comment_id ).destroy();	}
						}
					}).send();
				}, 
				function(){}, 
				"popup_no_button" 
			);
			//$('comment_tbody').getElements( 'tr.' + comment_id ).destroy();
		});
	},

	edit_aim: function()
	{
		inputs = new Array();
		
		outer_div = new Element( 'div' ).setStyles({'position': 'absolute', 'left': '10px', 'width': '380px', 'top': '25px', 'height': '340px'}).setStyle('overflow', 'auto' );
		table = new Element( 'table' ).setStyle( 'width', '100%' ).set('border', '0').inject( outer_div );
		
		$each( $_var_from_php.course_aim, function( item )
		{
			tr = new Element( 'tr' ).inject( table );
			td = new Element( 'td' ).set( 'colspan', '2' ).inject( tr );
			b = new Element( 'b' ).set( 'text', item.aim ).inject( td );
			
			$each( item.childs, function( item ){
				tr = new Element( 'tr' ).inject( table );
				td = new Element( 'td' ).inject( tr );
				input = new Element( 'input' ).set('id', 'aim_' + item.id ).set( 'name', item.id ).set( 'type', 'checkbox' ).inject( td );
								
				if( this.aim_checked.get( item.id ) == "1" )
				{	input.set('checked', 'checked');	}
				
				td = new Element( 'td' ).inject( tr );
				label = new Element( 'label' ).set( 'for', 'aim_' + item.id ).set( 'name', item.id ).set( 'text', item.aim ).inject( td );
				
				inputs.include( input );
			}.bind(this))
			
		}.bind(this));

		save_button = new Element( 'button' ).setStyles({'position': 'absolute', 'right': '10px', 'width': '100px', 'bottom': '5px' }).set('text', 'Sichern');
		cancel_button = new Element( 'button' ).setStyles({'position': 'absolute', 'right': '120px', 'width': '100px', 'bottom': '5px' }).set('text', 'Abbrechen');
		
		var content = { "outer_div" : outer_div, "save_button": save_button, "cancel_button": cancel_button };
		
		var events = { "cancel_button": function(){	$popup.hide_popup();	}, "save_button": this.save_aim.pass( [ inputs ], this ) };
		
		keyevents = {	"enter": events['save_button'], "esc": events['cancel_button'] };
		
		$popup.popup_HTML( "Ausbildungsziele auswählen", content, events, keyevents, true, 400, 400 );
	},
	
	edit_checklist: function()
	{
		inputs = new Array();
		
		outer_div = new Element( 'div' ).setStyles({'position': 'absolute', 'left': '10px', 'width': '480px', 'top': '25px', 'height': '340px'}).setStyle('overflow', 'auto' );
		table = new Element( 'table' ).setStyle( 'width', '100%' ).set('border', '0').inject( outer_div );
		
		$each( $_var_from_php.course_checklist, function( item )
		{
			tr = new Element( 'tr' ).inject( table );
			td = new Element( 'td' ).set( 'colspan', '2' ).inject( tr );
			h2 = new Element( 'h2' ).set( 'text', item.display ).inject( td );
			
			$each( item.childs, function( item ){
				tr = new Element( 'tr' ).inject( table );
				td = new Element( 'td' ).inject( tr );
				input = new Element( 'input' ).set('id', 'checklist_' + item.id ).set( 'name', item.id ).set( 'type', 'checkbox' ).inject( td );
				
				if( this.checklist_checked.get( item.id ) == "1" )
				{	input.set('checked', 'checked');	}
				
				td = new Element( 'td' ).inject( tr );
				label = new Element( 'label' ).set( 'for', 'checklist_' + item.id ).set( 'name', item.id ).set( 'text', item.display ).inject( td );
				
				inputs.include( input );
			}.bind(this))
		}.bind(this));
				
		save_button = new Element( 'button' ).setStyles({'position': 'absolute', 'right': '10px', 'width': '100px', 'bottom': '5px' }).set('text', 'Sichern');
		cancel_button = new Element( 'button' ).setStyles({'position': 'absolute', 'right': '120px', 'width': '100px', 'bottom': '5px' }).set('text', 'Abbrechen');
		
		var content = { "outer_div" : outer_div, "save_button": save_button, "cancel_button": cancel_button };
		
		var events  = { "cancel_button": function(){	$popup.hide_popup();	}, "save_button": this.save_checklist.pass( [ inputs ], this ) };
		
		var keyevents = {	"enter": events['save_button'], "esc": events['cancel_button'] };
		
		$popup.popup_HTML( "Checkliste ausfüllen", content, events, keyevents, true, 500, 400 );
	},
	
	save_aim: function( inputs )
	{
		i = new Hash();
		
		$each( inputs, function( input )
		{
			this.aim_checked.set( input.get('name'), input.get('checked') );
			i.set( input.get('name'), input.get('checked') );
		}.bind(this) );
		
		this.setup_course();
		
		load_url = "index.php?app=event&cmd=action_change_course_aim&event_id=" + $event.id + "&" + i.toQueryString( 'aim' );
		
		new Request.JSON(
		{
			url: load_url,
			onComplete: function( ans )
			{
				if( ans.error )	{	alert( ans.error_msg );	}
				else			{	$popup.hide_popup();	}
			}
		}).send();
	},
	
	save_checklist: function( inputs )
	{
		i = new Hash();
		
		$each( inputs, function( input )
		{
			this.checklist_checked.set( input.get('name'), input.get( 'checked') );
			i.set( input.get('name'), input.get('checked') );
		}.bind(this) );
		
		this.setup_course();
		
		load_url = "index.php?app=event&cmd=action_change_course_checklist&event_id=" + $event.id + "&" + i.toQueryString( 'checklist' );
		
		new Request.JSON(
		{
			url: load_url,
			onComplete: function( ans )
			{
				if( ans.error )	{	alert( ans.error_msg );	}
				else			{	$popup.hide_popup();	}
			}
		}).send();
	}
});

window.addEvent( 'keydown', $event.keydown.bind($event) );