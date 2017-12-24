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

$aim1 = null;
$aim2 = null;

function select_aim1($id)
{
	$aim1 = $id;
    
	$$('.aim1_selected').addClass('aim1_default');
	$$('.aim1_selected').removeClass('aim1_selected');
	
	$$('#aim1_' + $aim1).removeClass('aim1_default');
	$$('#aim1_' + $aim1).addClass('aim1_selected');

	$$('.aim1_box').addClass('hidden');
	$$('#aim1_box_' + $aim1).removeClass('hidden');
	
	$aim2 = null;
	select_aim2(-1);
	$$('#aim2_default').removeClass('hidden');
}

function select_aim2($id)
{
	$aim2 = $id;
	
	$$('.aim2_selected').addClass('aim2_default');
	$$('.aim2_selected').removeClass('aim2_selected');
	
	$$('#aim2_' + $aim2).removeClass('aim2_default');
	$$('#aim2_' + $aim2).addClass('aim2_selected');
	
	$$('.aim2_box').addClass('hidden');
	$$('#aim2_box_' + $aim2).removeClass('hidden');
	
}

function new_aim1()
{
	// Popup aufrufen
	content = $_var_from_php['template_aim1'];
	events = {
		'button_cancel':	function(){	$popup.hide_popup();	},
		'button_ok':		function(){ 
							new Request.JSON(
							{
								method: 'get',
								url: "index.php",
								data: "app=aim&cmd=action_edit_aim&new=1&pid=&" + $('popup_form').toQueryString(),
								onComplete: new_aim1_save
							}).send();
							$popup.hide_popup(); }};
	
	keyevents = { "esc": events['button_cancel']	};
	
	$popup.popup_HTML_src("Neues Leitziel:", content, events, keyevents, true, 450, 225);	
}

function new_aim1_save( $data )
{
	$new_value = $data.text;
	$id = $data.id;
	
	// neuer Eintrag
	$new_html1 =      '<div class="aim1 aim1_default" id="aim1_'+$id+'" onclick="javascript:select_aim1('+$id+');" ondblclick="javascript:edit_aim1('+$id+');">'
					+ '  <img src="public/global/img/del.png" onclick="delete_aim1('+$id+');" class="del"/>'
					+ '  <img src="public/global/img/edit.png" onclick="edit_aim1('+$id+');" class="edit"/>'
					+ '  &nbsp;'
					+ '  <span id="aim1_'+$id+'_value">'+$new_value+'</span>'
					+ '</div>';
	
	$new_html2 = '<div id="aim1_box_'+$id+'" class="aim1_box hidden" >'
			  +  '<input type="button" value="Neues Ausbildungsziel" style="margin-bottom:15px" onclick="javascript:new_aim2();"/>'
			  +  '<div id="aim1_hasnochild_'+$id+'"><i>[keine Ausbildungsziele zu diesem Leitziel]</i></div>'
			  +  '<div id="list_aim2_'+$id+'">'
			  +  '</div>';
	
	// Eintrag hinzufügen
	$html = $$('#list_aim1').get('html');
	$$('#list_aim1').set('html', $html + $new_html1);
	
	// "Platz" für Ausbildungsziele einfügen
	$html = $$('#list_aim2_full').get('html');
	$$('#list_aim2_full').set('html', $html + $new_html2);
	
	
	// neuer Eintrag selektieren
	select_aim1($id);
}



function new_aim2()
{
	// Popup aufrufen
	content = $_var_from_php['template_aim2'];
		events = {
		'button_cancel':	function(){	$popup.hide_popup();	},
		'button_ok':		function(){ 
							new Request.JSON(
							{
								method: 'get',
								url: "index.php",
								data: "app=aim&cmd=action_edit_aim&new=1&pid="+$aim1+"&" + $('popup_form').toQueryString(),
								onComplete: new_aim2_save
							}).send();
							$popup.hide_popup(); }};
	
	keyevents = { "esc": events['button_cancel']	};
	
	$popup.popup_HTML_src("Neues Ausbildungsziel:", content, events, keyevents, true, 450, 225);	
}

function new_aim2_save($data)
{	
	// per Ajax speichern
	$new_value = $data.text;
	$id = $data.id;
	
	// neuer Eintrag
	$new_html = '<div class="aim2 aim2_default" id="aim2_'+$id+'" onclick="javascript:select_aim2('+$id+');" ondblclick="javascript:edit_aim2('+$id+');">'
                +'<img src="public/global/img/del.png" onclick="delete_aim2('+$id+');" class="del"/>'
                +'<img src="public/global/img/edit.png" onclick="edit_aim2('+$id+');" class="edit"/>'
                +' &nbsp;'
                +'<span id="aim2_'+$id+'_value">'+$new_value+'</span>'
                +'</div>';
	
	// Eintrag anfügen
	$html = $$('#aim1_box_' + $aim1).get('html');
	$$('#aim1_box_' + $aim1).set('html', $html + $new_html);
	
	// Anzeige "kein Eintrag" löschen
	$$('#aim1_hasnochild_' + $aim1).addClass('hidden');
	
	// Platz für Events schaffen
	$new_html = '<div id="aim2_box_'+$id+'" class="aim2_box hidden">'
        		+ '<div><i>[keine verknüpften Programmblöcke]</i></div>'
                + '</div>';
    $html = $$('#event_box').get('html');
	$$('#event_box').set('html', $html + $new_html);
	
	
	// neuer Eintrag selektieren
	select_aim2($id);
}

function edit_aim1( $id )
{
	select_aim1($id);
	
	// Popup aufrufen
	content = $_var_from_php['template_aim1'];
	events = {
		'button_cancel':	function(){	$popup.hide_popup();	},
		'button_ok':		function(){ 
							new Request.JSON(
							{
								method: 'get',
								url: "index.php",
								data: "app=aim&cmd=action_edit_aim&edit=1&id=" + $id + "&" + $('popup_form').toQueryString(),
								onComplete: edit_aim1_save
							}).send();
							$popup.hide_popup();
							 }};
	
	keyevents = { "esc": events['button_cancel']	};
		
	$popup.popup_HTML_src("Leitziel:", content, events, keyevents, true, 450, 225);
	
	$('popup_form').text.value = unescapeHTML( $$('#aim1_' + $id + '_value').get('html') );
}

function edit_aim1_save($data)
{	
	$new_value = $data.text;
	
	// Wert zurückschreiben
	$$('#aim1_' + $aim1 + '_value').set('html', $new_value );
}

function edit_aim2($id)
{
	select_aim2($id);
	
	// Popup aufrufen
	content = $_var_from_php['template_aim2'];
	events = {
		'button_cancel':	function(){	$popup.hide_popup();	},
		'button_ok':		function(){ 
							new Request.JSON(
							{
								method: 'get',
								url: "index.php",
								data: "app=aim&cmd=action_edit_aim&edit=1&id=" + $id + "&" + $('popup_form').toQueryString(),
								onComplete: edit_aim2_save
							}).send();
							$popup.hide_popup(); }};
		
	keyevents = { "esc": events['button_cancel']	};
	
	$popup.popup_HTML_src("Ausbildungsziel:", content, events, keyevents, true, 450, 225);
	
	$('popup_form').text.value = unescapeHTML( $$('#aim2_' + $id + '_value').get('html') );
}

function edit_aim2_save( $data )
{
	// popup aufrufen
	$new_value = $data.text;
	
	// Wert zurückschreiben
	$$('#aim2_' + $aim2 + '_value').set('html', $new_value );
}


function delete_aim1($id)
{
	if( confirm("Willst du das Leitziel und alle zugehörigen Ausbildungsziele tatsächlich löschen?") )
	{
		new Request.JSON(
		{
			method: 'get',
			url: "index.php",
			data: "app=aim&cmd=action_edit_aim&del=1&id="+$id,
			onComplete: delete_aim1_do
		}).send();
	}
}

function delete_aim1_do($data)
{
	// Eintrag löschen
	$('aim1_' + $data.id).destroy();
	$('aim1_box_' + $data.id).destroy();
	
	// Default-Eintrag anzeigen
	$$('#aim1_default').removeClass('hidden');
	$$('#aim2_default').removeClass('hidden');
}

function delete_aim2($id)
{
	if( confirm("Willst du das Ausbildungsziel tatsächlich löschen?") )
	{
		new Request.JSON(
		{
			method: 'get',
			url: "index.php",
			data: "app=aim&cmd=action_edit_aim&del=1&id="+$id,
			onComplete: delete_aim2_do
		}).send();
	}
}
		
function delete_aim2_do($data)
{
	// Eintrag löschen
	$('aim2_' + $data.id).destroy();
	$('aim2_box_' + $data.id).destroy();
	
	// Default-Eintrag anzeigen
	$$('#aim2_default').removeClass('hidden');
}