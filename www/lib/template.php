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

  # TAG   zu    <!-- TAG -->    erweitern
  function add_tag( $replace )
  {
    $return = array();
	
	foreach($replace as $key => $value)
	{	$return["<!-- " . $key . " -->"] = $value;	}
	
	return $return;
  }

  # Template-Datei auslesen
  function gettemplate( $template, $replace, $endung, $folder )
  {
  	return;
	
	if (file_exists($folder."/".$template.".".$endung))
	{
		// Tag anpassen
		$replace = add_tag ( $replace );
		
		$templatecontent = strtr(implode("", file($folder."/".$template.".".$endung)), $replace);
     }
     else
	 {	error_message( "Template nicht gefunden: ".$folder."/".$template.".".$endung );	}
		
	 return $templatecontent;
  }

  function gettemplate_main( $template, $replace=array(), $endung="tpl" )
  {
	  return gettemplate( $template, $replace, $endung, $GLOBALS[template_global_dir] );
  }
  
  function gettemplate_module( $template, $module, $replace=array(), $endung="tpl" )
  {
	  return gettemplate( $template, $replace, $endung, $GLOBALS[template_module_dir] . "/" . $module );
  }
  
  function gettemplate_app( $template, $replace=array(), $endung="tpl" )
  {
      return gettemplate( $template, $replace, $endung, $GLOBALS[template_app_dir] . "/" . $_page[app] );
  }
  
  function gettemplate_manual( $template, $folder, $replace=array(), $endung="tpl" )
  {
      return gettemplate( $template, $replace, $endung, $folder );
  }
?>