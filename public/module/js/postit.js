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

$postit = new Hash(
{
	div: 0,
	id: 0,
	
	loadComment: function( comment_id )
	{
		if( $(this.div) )	{	this.div.destroy();	}
		this.div = new Element('div').inject('body');
		
		var ans = new Request.HTML(
		{
			url:		'index.php?app=popup&cmd=comment&comment_id=' + comment_id,
			onSuccess: 	function(responseTree, responseElements, responseHTML, responseJavaScript)
			{
				this.id = comment_id;
				this.div.set( 'html', responseHTML );
				load_dynamics.run();
			}.bind(this)
		}).send();
	},
	
	loadEvent: function( event_id )
	{
	},
	
	close: function()
	{
		this.id = 0;
		this.div.destroy();
	}
});
