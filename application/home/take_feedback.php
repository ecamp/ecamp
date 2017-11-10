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

	
	$_page->html->set('main_macro', $GLOBALS[tpl_dir].'/global/content_box_fit.tpl/predefine');
	$_page->html->set('box_content', $GLOBALS[tpl_dir].'/application/home/taken.tpl/taken');
	$_page->html->set('box_title', 'Danke!');
	
	
	
	
	$feedback 	= utf8_decode(mysql_real_escape_string($_REQUEST['feedback']));
	$feedback = preg_replace("/\\\\n/","\n",$feedback);
	
	$type = mysql_real_escape_string($_REQUEST[type]);
	
	$mail = $_user->mail;
	$name = $_user->display_name . " [" . $_user->id . "]";
	
	
	$query = "INSERT INTO feedback (`name` ,`mail` ,`feedback`, `time`)
							VALUES ('$name', '$mail', '$feedback', NOW( ) )";
	
	//echo $query;
	
	mysql_query($query);
	
	$mailto = $GLOBALS[feedback_mail];
	
	$headers = "From: ".$name." <".$mail.">";
	

	if( $type == "feedback" )
		mail($mailto, "Feedback von: " . $name, $feedback, $headers);
	else if( $type == "help" )
		mail($mailto, "Supportanfrage von: " . $name, $feedback, $headers);
	
	
	
	$_page->html->set( 'feedback', 	( $type == "feedback" ) );
	$_page->html->set( 'help', 		( $type == "help" ) );
	
	/*
	header("Content-type: application/xml");
	$xml_replace[error] = 0;
	
	$xml = gettemplate_main( "ajax_response", $xml_replace ); 
	
    echo $xml;
    */
    
    
    
	//die();
?>