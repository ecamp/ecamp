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

window.addEvent('domready', function()
{
  var banner = new Element('div', {
    styles: {
      position: 'fixed',
      top: '0',
      left: '0',
      right: '0',
      'z-index': '9999',
      background: '#f5a623',
      color: '#333333',
      padding: '10px 40px 10px 15px',
      'font-size': '20px',
      'box-shadow': '0 2px 4px rgba(0,0,0,0.2)',
      'text-align': 'left'
    },
    html: '<strong style="font-size: 20px">eCamp v2 wird spätestens im Frühling 2027 abgeschaltet.</strong> Bitte erstelle keine neuen Lager mehr, exportiere jetzt deine Lagerdaten über die PDF-Export-Funktion und wechsle zum neuen <a href="https://ecamp3.ch" target="_blank" rel="noopener noreferrer" style="color:#333333;font-weight:bold;font-size:20px">ecamp3.ch</a>.'
  });

  banner.inject(document.body, 'top');
  var bodyDiv = document.getElement('div.body');
  if (bodyDiv) { bodyDiv.setStyle('top', banner.getSize().y + 'px'); }

	if( $( 'info_box_button_down') && $( 'info_box_button_up' ) )
	{
		$('info_box_button_down' ).addEvent( 'click', function()
		{
			$('info_box_button_down' ).addClass('hidden');
			$('info_box_button_up' ).removeClass('hidden');
			
			$('info_box_border').addClass('hidden');
		});
		
		$('info_box_button_up' ).addEvent( 'click', function()
		{
			$('info_box_button_up' ).addClass('hidden');
			$('info_box_button_down' ).removeClass('hidden');
			
			$('info_box_border').removeClass('hidden');
		});
	}
});