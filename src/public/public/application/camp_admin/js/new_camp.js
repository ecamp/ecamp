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
	path = new select_class( 0, null,-1 );
	
	
	new Calendar({ 'camp_start': 'd.m.Y' , 'camp_end': 'd.m.Y'  }, { navigation: 2 , offset: 1 });
	
		
		
});

var global_counter = 0;

select_class = new Class(
{
	left_select:	null,
	right_select:	null,
	select_element:	null,
	wait:			null,
	
	value:			null,
	counter:	      0,
	
	initialize: function( pid, left_select, cnt )
	{
	    this.counter = cnt + 1;
	    global_counter = this.counter;
	    
		this.left_select = left_select;
		
		this.select_element = new Element('select');
		this.select_element.set('size', 10 );
		this.select_element.addClass('hidden');
		this.select_element.inject( $('new_camp_selects'), 'bottom' );
		
		//if( left_select == null ){	this.select_element.focus();	}
		
		this.select_element.addEvent('click', this.change.bind(this) );
		this.select_element.addEvent('change', this.change.bind(this) );
		this.select_element.addEvent('keydown', this.keyhandler.bind(this) );
		
		this.wait = new Element('option').set( 'text', 'laden...' );
		this.wait.inject( this.select_element );
		
		
		args = new Hash(
		{
			"app": "camp_admin",
			"cmd": "load_select",
			"pid": pid
		});
		
		new Request.JSON(
		{
			method: 'get',
			url: "index.php",
			data: args.toQueryString(),
			onComplete: this.build_options.bind(this)
		}).send();
		
	},
	
	keyhandler: function( event )
	{
		if( event.key == "right" )
		{
			this.right_select.select_element.focus();
			
			if( this.right_select.select_element.getSelected() == "" )
			{	this.right_select.select_first();	}
		}
		if( event.key == "left" )
		{
			this.left_select.select_element.focus();
			this.left_select.change();
		}
	},
	
	select_first: function()
	{
		this.select_element.getFirst('option').set('selected', 'selected');
		this.change();
	},
	
	build_options: function( ans )
	{
		this.select_element.empty();
		
		if( ans.num_values == 0 )
		{	this.select_element.destroy();	}
		else
		{
			ans.values.each( function( o ){
				option = new Element('option');
				option.set( 'value', o.id );
				option.set( 'text', o.text );
				option.store( 'o', o );
				
				option.inject( this.select_element );
			}.bind(this));
			
			this.select_element.removeClass('hidden');
			if( this.left_select == null ){	this.select_element.focus();	}
		}
	},
	
	change: function()
	{
		if( this.value != this.select_element.get('value') )
		{
			if( this.right_select )
			{	this.right_select.remove(); }
			
			pid = this.select_element.getSelected().getLast().get('value');
			this.right_select = new select_class( pid, this, this.counter );
			
			this.value = this.select_element.get('value');
		}
		else
		{
			if( this.right_select )
			{
				if( this.right_select.right_select )
				{	this.right_select.right_select.remove();	}
				
				this.right_select.select_element.getSelected().removeProperty( 'selected' );
				this.right_select.value = 0;
			}
			
			
			pid = this.select_element.getSelected().getLast().get('value');
		}
		
		
		$('new_camp_path').set('html', this.get_path() );
		$('camp_groups').set('value', pid );
		
		global_counter = this.counter+1;
	},
	
	remove: function()
	{
		if( this.right_select )
		{	this.right_select.remove(); }
		
		this.select_element.destroy();
	},
	
	get_path: function()
	{
		if( this.left_select )
		{	left = this.left_select.get_path() + " :: ";	}
		else
		{	left = "";	}
		
		o = this.select_element.getSelected().getLast().retrieve( 'o' );
		return left + o.short_prefix + " " + o.name;
	}
	
	
});

function new_course_check()
{
	var success = true;
	var text = "";
	
	if( $('camp_name').get('value') == "" )
	{
		success = false;
		text = text + "\n" + "- 'Kursbezeichnung' nicht ausgefüllt";
	}
	
	if( $('camp_short_name').get('value') == "" )
	{
		success = false;
		text = text + "\n" + "- 'Kurze Bezeichnung' nicht ausgefüllt";
	}
	
	if( $('camp_start').get('value') == "" )
	{
		success = false;
		text = text + "\n" + "- kein Startdatum gewählt";
	}
	
	if( $('camp_end').get('value') == "" )
	{
		success = false;
		text = text + "\n" + "- kein Enddatum gewählt";
	}
	
	if( $('course_type').getSelected().get('value') == "" )
	{
		success = false;
		text = text + "\n" + "- keine Kursart ausgewählt";
	}
	else if( $('course_type').getSelected().get('value') == 99 && $('course_type_text').get('value') == "" )
	{
		success = false;
		text = text + "\n" + "- Kursart 'Anderer Kurs' gewählt aber kein Freitext eingegeben";
	}
	
	if( global_counter < 2 )
	{
		success = false;
		text = text + "\n" + "- kein Kantonalverband gewählt";
	}

	
	if( success )
		return true;
	else
		return confirm("Etwas vergessen einzugeben?\n" + text + "\n\n" + "Trotzdem speichern?");
}

function new_camp_check()
{
	var success = true;
	var text = "";
	
	if( $('camp_name').get('value') == "" )
	{
		success = false;
		text = text + "\n" + "- 'Lagername' nicht ausgefüllt";
	}
	
	if( $('camp_short_name').get('value') == "" )
	{
		success = false;
		text = text + "\n" + "- 'Kurze Bezeichnung' nicht ausgefüllt";
	}
	
	if( $('camp_start').get('value') == "" )
	{
		success = false;
		text = text + "\n" + "- kein Startdatum gewählt";
	}
	
	if( $('camp_end').get('value') == "" )
	{
		success = false;
		text = text + "\n" + "- kein Enddatum gewählt";
	}
	
	if( global_counter < 4 )
	{
		success = false;
		text = text + "\n" + "- keine Abteilung gewählt";
	}

	
	if( success )
		return true;
	else
		return confirm("Etwas vergessen einzugeben?\n" + text + "\n\n" + "Trotzdem speichern?")
}

function new_check(isCourse)
{
	if( isCourse == 1 )
		return new_course_check()
	else
		return new_camp_check();
}

