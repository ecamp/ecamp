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

//alert( $('dp_mat_buy_add_input') );
alert( "debug" );
alert( $('dp_mat_buy_add_input') );
alert( $_var_from_php.mat_article_list );
alert( Autocompleter.Local );

new Autocompleter.Local( $('dp_mat_buy_add_input'), $_var_from_php.mat_article_list, {
	'minLength': 1, // We need at least 1 character
	'selectMode': 'type-ahead', // Instant completion
	'multiple': false // Tag support, by default comma separated
});

alert( "debug" );
alert( $$('ul.autocompleter-choices') );

$$('ul.autocompleter-choices').setStyle( 'z-index', 1100 );

alert( "TEST" );

$$('.dp_mat_buy_add').addEvent('click', function()
{
	args = new Hash(
	{
		"app": 		"event",
		"cmd": 		"action_change_mat",
		"todo":		"add",
		"event_id":	$event.id,
		"article":	$( 'dp_mat_buy_add_input' ).get('value'),
		"quantity":	$( 'dp_mat_buy_add_quantity' ).get('value')
		//"article":	$('article').get('value')
	});
	
	load_url = "index.php?" + args.toQueryString();
	
	alert( load_url );
	
	new Request.JSON(
	{
		url: load_url, 
		onComplete: function(ans)
		{
			if(ans.ans == "saved")
			{
				$popup.hide_popup();
				
				row = new Element('tr').inject( $('dp_mat_buy_list') );
				quant = new Element('td').set('html', args.quantity).inject( row );
				name = new Element('td').set('html', args.article ).inject( row );
				
				//alert( $('dp_mat_buy_list') );
			}
			
			if( ans.ans == "aks_concat_seperate" )
			{
				alert( "Dieses Material haben sie bereits hinzugefügt. Erhöhen sie die Zahl." );
			}
		}.bind(this)
	}).send();
});