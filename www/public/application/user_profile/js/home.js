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
	
	var args = new Hash({ "app": "user_profile", "cmd": "action_save_change" });
	
	
	new DI_TEXT( 'user_profile_scoutname',	{ 'args': args.set('field', 'scoutname') } );
	new DI_TEXT( 'user_profile_firstname',	{ 'args': args.set('field', 'firstname') } );
	new DI_TEXT( 'user_profile_surname',	{ 'args': args.set('field', 'surname') } );
	new DI_TEXT( 'user_profile_street',		{ 'args': args.set('field', 'street') } );
	new DI_TEXT( 'user_profile_zipcode',	{ 'args': args.set('field', 'zipcode') } );
	new DI_TEXT( 'user_profile_city',		{ 'args': args.set('field', 'city') } );
	new DI_TEXT( 'user_profile_homenr',		{ 'args': args.set('field', 'homenr') } );
	new DI_TEXT( 'user_profile_mobilnr',	{ 'args': args.set('field', 'mobilnr') } );
	
	
	
	if( Browser.Engine.trident )
	{	new DI_TEXT( 'user_profile_birthday',	{ 'args': args.set('field', 'birthday') } );	}
	else
	{	new DI_DATE( 'user_profile_birthday',	{ 'args': args.set('field', 'birthday') } );	}
	
	new DI_TEXT( 'user_profile_ahv',		{ 'args': args.set('field', 'ahv') } );
	new DI_TEXT( 'user_profile_jspersnr',	{ 'args': args.set('field', 'jspersnr') } );
	
	
	
	new DI_SELECT( 'user_profile_sex',		{ 'args': args.set('field', 'sex') } );
	new DI_SELECT( 'user_profile_pbsedu',	{ 'args': args.set('field', 'pbsedu') } );
	new DI_SELECT( 'user_profile_jsedu',	{ 'args': args.set('field', 'jsedu') } );
	
	

	
	
	
	
	
		
	$('profile_avatar').addEvent('click', function()
	{
		form =	new Element('form').set('action', 'index.php').set('enctype', 'multipart/form-data').set('method', 'post');
		
		new Element('div').setStyles({ 'position': 'absolute', 'left': '40px', 'top': '50px'}).set('html', 'Neues Portrait:').inject(form);
		new Element('input').setStyles({ 'position': 'absolute', 'left': '150px', 'top': '45px', 'width': '300px'}).set('name', 'avatar').set('type', 'file').inject(form);
		
		new Element('input').set('name', 'app').set('value', 'user_profile').set('type', 'hidden').inject(form);
		new Element('input').set('name', 'cmd').set('value', 'action_save_change_avatar').set('type', 'hidden').inject(form);
		
		new Element('input').setStyles({ 'position': 'absolute', 'left': '230px', 'top': '80px', 'width': '100px' }).set('value', 'Senden').set('type', 'submit').inject(form);
		
		content = {	
					'form':		form,
					'cancel':	new Element('input').setStyles({ 'position': 'absolute', 'left': '350px', 'top': '80px', 'width': '100px' }).set('value', 'Abbrechen').set('type', 'button')
				};
		events	= {	'cancel':	function(){	$popup.hide_popup();	}	};
		
		keyevents = {	"esc": events['cancel'] };
		
		$popup.popup_HTML("Portrait ändern:", content, events, keyevents, true, 500, 120);
	});
	
	
	$('profile_del_avatar').addEvent('click', function()
	{
		form =	new Element('form').set('action', 'index.php').set('enctype', 'multipart/form-data');
		
		new Element('div').setStyles({ 'position': 'absolute', 'left': '40px', 'top': '50px'}).set('html', 'Möchtest du dein Portrait wirklich l&ouml;schen?').inject(form);
		
		new Element('input').set('name', 'app').set('value', 'user_profile').set('type', 'hidden').inject(form);
		new Element('input').set('name', 'cmd').set('value', 'action_delete_avatar').set('type', 'hidden').inject(form);
		
		new Element('input').setStyles({ 'position': 'absolute', 'left': '230px', 'top': '80px', 'width': '100px' }).set('value', 'Ja').set('type', 'submit').inject(form);
		
		content = {	
					'form':		form,
					'cancel':	new Element('input').setStyles({ 'position': 'absolute', 'left': '350px', 'top': '80px', 'width': '100px' }).set('value', 'Nein').set('type', 'button')
				};
		events	= {	'cancel':	function(){	$popup.hide_popup();	}	};
		
		keyevents = {	"esc": events['cancel'] };
		
		$popup.popup_HTML("Portrait löschen:", content, events, keyevents, true, 500, 120);});
	
	
	$('profile_pw').addEvent('click', function()
	{
		form =	new Element('form').addEvent('submit', function(){	return false; });
		
		new Element('input').setStyles({ 'position': 'absolute', 'left': '150px', 'top': '30px', 'width': '300px'}).set('name', 'old_pw').set('type', 'password').inject(form);
		new Element('input').setStyles({ 'position': 'absolute', 'left': '150px', 'top': '55px', 'width': '300px'}).set('name', 'pw1').set('type', 'password').inject(form);
		new Element('input').setStyles({ 'position': 'absolute', 'left': '150px', 'top': '80px', 'width': '300px'}).set('name', 'pw2').set('type', 'password').inject(form);
		new Element('input').set('name', 'app').set('value', 'user_profile').set('type', 'hidden').inject(form);
		new Element('input').set('name', 'cmd').set('value', 'action_save_change_pw').set('type', 'hidden').inject(form);
		
		
		
		
		content = {	
					'form':			form,
					'label_old_pw':	new Element('div').setStyles({ 'position': 'absolute', 'left': '40px', 'top': '35px'}).set('html', 'Altes Passwort:'),
					'lable_pw1':	new Element('div').setStyles({ 'position': 'absolute', 'left': '40px', 'top': '60px'}).set('html', 'Neues Passwort:'),
					'lable_pw2':	new Element('div').setStyles({ 'position': 'absolute', 'left': '40px', 'top': '85px'}).set('html', 'Wiederholen:'),
					
					'senden':		new Element('input').setStyles({ 'position': 'absolute', 'left': '230px', 'top': '110px', 'width': '100px' }).set('value', 'Senden').set('type', 'submit'),
					'cancel':		new Element('input').setStyles({ 'position': 'absolute', 'left': '350px', 'top': '110px', 'width': '100px' }).set('value', 'Abbrechen').set('type', 'button')
				};
		events	= {
					'senden':	function()
					{
						new Request.JSON(
						{
							method: 'get',
							url: 'index.php',
							data: form.toQueryString(),
							onComplete: function(ans)
							{	$popup.popup_warning("Passwort &auml;ndern", ans.ans);	}
						} ).send();
						$popup.hide_popup();
					},
					'cancel':	function(){	$popup.hide_popup();	}
				};
		
		keyevents = {	"enter": events['senden'], "esc": events['cancel'] };
		
		$popup.popup_HTML("Passwort &auml;ndern:", content, events, keyevents, true, 500, 150);
	});
	

});