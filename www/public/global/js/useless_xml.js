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

	function get_xml_tag_data( xmldoc, tagname )
	{
		//alert("1");
	    var taglist = xmldoc.getElementsByTagName( tagname );
		//alert("2");
		
		// Tag nicht gefunden
		if( taglist.length == 0 ) {
			return "";
			//alert("2");
		}
		//alert("3");
		
		var tag = xmldoc.getElementsByTagName( tagname ).item(0);
		
		//alert("4");
		
		if( tag.firstChild )
		{
			//alert("5");
			return xmldoc.getElementsByTagName( tagname ).item(0).firstChild.data;
		}
		else
		{
			//alert("6");
			return ""; // Tag enthält keine Daten
		}
	}