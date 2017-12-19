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

	function lock_screen()
	{
	   	$('transparent_div').removeClass('hidden');
	   
	   	//$('transparent').width  = document.body.clientWidth;
	   
	   	if( document.documentElement.clientHeight == 0 )
		{
	   		$('transparent').height = document.body.clientHeight;
			$('transparent').width  = document.body.clientWidth;
		}
		else
		{
	   		$('transparent').height = document.documentElement.clientHeight;
			$('transparent').width  = document.documentElement.clientWidth;
		}
	}
	
	function check_date(date)
	{
		return suche = date.match(/\d+\.\d+\.\d+/);
	}
	
	function unlock_screen()
	{
		$('transparent_div').addClass('hidden');
	}
	
	function show_busy(){}
	
	function hide_busy(){}
	
	function utf8_encode(rohtext) 
	{
		 // dient der Normalisierung des Zeilenumbruchs
		 rohtext = rohtext.replace(/\r\n/g,"\n");
		 var utftext = "";
		 for(var n=0; n<rohtext.length; n++)
			 {
			 // ermitteln des Unicodes des  aktuellen Zeichens
			 var c=rohtext.charCodeAt(n);
			 // alle Zeichen von 0-127 => 1byte
			 if (c<128)
				 utftext += String.fromCharCode(c);
			 // alle Zeichen von 127 bis 2047 => 2byte
			 else if((c>127) && (c<2048)) {
				 utftext += String.fromCharCode((c>>6)|192);
				 utftext += String.fromCharCode((c&63)|128);}
			 // alle Zeichen von 2048 bis 66536 => 3byte
			 else {
				 utftext += String.fromCharCode((c>>12)|224);
				 utftext += String.fromCharCode(((c>>6)&63)|128);
				 utftext += String.fromCharCode((c&63)|128);}
			 }
		 return utftext;
 	}
	
	function utf8_decode(utftext) 
	{
		 var plaintext = ""; var i=0; var c=c1=c2=0;
		 // while-Schleife, weil einige Zeichen uebersprungen werden
		 while(i<utftext.length)
			 {
			 c = utftext.charCodeAt(i);
			 if (c<128) {
				 plaintext += String.fromCharCode(c);
				 i++;}
			 else if((c>191) && (c<224)) {
				 c2 = utftext.charCodeAt(i+1);
				 plaintext += String.fromCharCode(((c&31)<<6) | (c2&63));
				 i+=2;}
			 else {
				 c2 = utftext.charCodeAt(i+1); c3 = utftext.charCodeAt(i+2);
				 plaintext += String.fromCharCode(((c&15)<<12) | ((c2&63)<<6) | (c3&63));
				 i+=3;}
			 }
		 return plaintext;
	 }