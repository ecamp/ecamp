<?php
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

  function secure_input_nr( $value )
  {
  	return $value;
  }
  
  function secure_input_filename( $value )
  {
    return $value;
  }

  function txt2html( $textfield )
  {
          $textfield = preg_replace("/\&/", "&amp;", $textfield);
          $textfield = preg_replace("/ä/", "&auml;", $textfield);
          $textfield = preg_replace("/ö/", "&ouml;", $textfield);
          $textfield = preg_replace("/ü/", "&uuml;", $textfield);
          $textfield = preg_replace("/Ä/", "&Auml;", $textfield);
          $textfield = preg_replace("/Ö/", "&Ouml;", $textfield);
          $textfield = preg_replace("/Ü/", "&Uuml;", $textfield);
          $textfield = preg_replace("/\"/", "&quot;", $textfield);
          $textfield = preg_replace("/>/", "&gt;", $textfield);
          $textfield = preg_replace("/</", "&lt;", $textfield);
          $textfield = preg_replace("/\r\n/", "<br>", $textfield);

           # Javascript-Code
          $textfield = preg_replace("/'/", "&#145;", $textfield);

          return $textfield;
  }

  function html2txt( $textfield )
  {
          $textfield = preg_replace("/<br>/", "\r\n", $textfield);
          $textfield = preg_replace("/&lt;/", "<", $textfield);
          $textfield = preg_replace("/&gt;/", ">", $textfield);
          $textfield = preg_replace("/&quot;/", "\"", $textfield);

          $textfield = preg_replace("/&auml;/", "ä", $textfield);
          $textfield = preg_replace("/&ouml;/", "ö", $textfield);
          $textfield = preg_replace("/&uuml;/", "ü", $textfield);
          $textfield = preg_replace("/&Auml;/", "Ä", $textfield);
          $textfield = preg_replace("/&Ouml;/", "Ö", $textfield);
          $textfield = preg_replace("/&Uuml;/", "Ü", $textfield);

          $textfield = preg_replace("/&amp;/", "&", $textfield);

          # Javascript-Code
          $textfield = preg_replace("/\'/", "'", $textfield);

          return $textfield;
  }

  function txt2securetxt( $textfield )
  {
          $textfield = preg_replace("/\"/", "\\\"", $textfield);
          $textfield = preg_replace("/\'/", "\\'", $textfield);

          return $textfield;
  }

  # Erlaube HTML-Tags
  function html2securehtml( $textfield )
  {
          $textfield = preg_replace("/>/", "&gt;", $textfield);
          $textfield = preg_replace("/</", "&lt;", $textfield);

          # <br>
          $textfield = preg_replace("/&lt;br&gt;/", "<br />", $textfield);

          # <a></a>
          $textfield = allowTag( "a", $textfield );

          # <b></b>
          $textfield = allowTag( "b", $textfield );

          # <i></i>
          $textfield = allowTag( "i", $textfield );

          # <u></u>
          $textfield = allowTag( "u", $textfield );

          # <h[1-6]></h[1-6]>
          $textfield = allowTag( "h[1-6]", $textfield );

          # <p></p>
          $textfield = allowTag( "p", $textfield );

          # <nobr></nobr>
          $textfield = allowTag( "nobr", $textfield );

          #<pre></pre>
          $textfield = allowTag( "pre", $textfield );

          # <ul></ul>
          $textfield = allowTag( "ul", $textfield );

          # <li></li>
          $textfield = allowTag( "li", $textfield );

          # <ol></ol>
          $textfield = allowTag( "ol", $textfield );

          # <span></span>
          $textfield = allowTag( "span", $textfield );

          # <div></div>
          $textfield = allowTag( "div", $textfield );

          # <blockquote></blockquote>
          $textfield = allowTag( "blockquote", $textfield );

          # <font></font>
          $textfield = allowTag( "font", $textfield );

          return $textfield;
  }

  // Erlaubt spezielle HTML-Tags
  function allowTag( $tag, $textfield )
  {
          $textfield = eregi_replace("(&lt;)(".$tag.")([^<>/&]*)(&gt;)", "<\\2\\3>", $textfield );
          $textfield = eregi_replace("(&lt;)(/".$tag.")([^<>/&]*)(&gt;)", "<\\2\\3>", $textfield );

          # evtl. Anzahl Tag's zählen
          return $textfield;
  }
?>