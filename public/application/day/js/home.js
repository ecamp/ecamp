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

window.addEvent( 'load', function()
{
	var event_list = new Hash( $_var_from_php.event_list );
	
	var day_id = $('day_job_list').getElement( 'input[name=day_id]' ).get('value');
	
	
	args = new Hash();
	
	$('day_job_list').getElements('li').each( function( item )
	{
		var job_id = item.getElement( 'input[name=job_id]' ).get('value');
		
		args.set( 'app', 'day' );
		args.set( 'cmd', 'action_change_job_resp' );
		args.set( 'job_id', job_id );
		args.set( 'day_id', day_id );
		
		new DI_SELECT( item.getElement('select[name=user_id]'), { 'args': args, 'min_level': 40 } );
	});

	$('day_event_list').getElements( 'tr' ).each( function( tr )
	{
		//	EDIT EVENT_INSTANCE:
		// ======================
		if( auth.access( 40 ) )
		{
			tr.getElement( 'td.opt img.edit' ).setStyle( 'cursor', 'pointer' );
			tr.getElement( 'td.opt img.edit' ).addEvent( 'click', function()
			{
				var event_instance_id = tr.getElement( 'td.opt input[name=event_instance_id]' ).get( 'value' );
				
				edit_event( event_list.get( event_instance_id ) );
			});
			
			//  DELETE
			// ========
			tr.getElement( 'td.opt img.del' ).setStyle( 'cursor', 'pointer' );
			tr.getElement( 'td.opt img.del' ).addEvent( 'click', function()
			{
				var event_instance_id = tr.getElement( 'td.opt input[name=event_instance_id]' ).get( 'value' );
				
				new Request.JSON(
				{
					url: 'index.php?app=day&cmd=action_delete_event_instance&event_instance_id=' + event_instance_id,
					onComplete: function(ans)
					{
						if( ans.error )	{	alert( ans.error_msg );	}
						else			{	tr.destroy();	}
					}
				}).send();
			});
		}
		else
		{
			$$('td.opt img.edit').addClass( 'hidden' );
			$$('td.opt img.del').addClass( 'hidden' );
			
		}

		//	EDIT EVENT
		// ============
		tr.getElement( 'td.event_name b' ).setStyle( 'cursor', 'pointer' );
		tr.getElement( 'td.event_name b' ).addEvent( 'click', function()
		{
			var event_id = tr.getElement( 'td.event_name input[name=event_id]' ).get( 'value' );
			$event.edit( event_id );
			
			$event.update_background = function()
			{	tr.getElement('td.progress').set('html', $event.event_progress.value + "%" );	}
			
		});
	});

	if( auth.access(40) )
	{
		$('day_new_event').addEvent('click', function()
		{	new_event( day_id );	});
	}
	else
	{	$('day_new_event').addClass('hidden');	}
	
	new DI_TEXTAREA( 'day_story', { 'args': { 'app': 'day', 'cmd': 'action_change_story', 'day_id': day_id }, 'button_pos': 'bottom', 'min_level': 40 } );
	new DI_TEXTAREA( 'day_notes', { 'args': { 'app': 'day', 'cmd': 'action_change_notes', 'day_id': day_id }, 'button_pos': 'bottom', 'min_level': 40 } );
});

