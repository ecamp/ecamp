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

	$_page->html->set('main_macro', $GLOBALS['tpl_dir'].'/global/content_box_fit.tpl/predefine');
	$_page->html->set('box_content', $GLOBALS['tpl_dir'].'/application/leader/show_user.tpl/show_user');
	$_page->html->set('box_title', 'Leiterliste');
	
	$id	= mysql_real_escape_string( $_REQUEST['id'] );
	
	$_camp->user( $id ) || die( "error" );

	$query = "	SELECT 
					mail,
					scoutname, 
					firstname, 
					surname, 
					street, 
					zipcode, 
					city, 
					homenr, 
					mobilnr, 
					birthday, 
					ahv, 
					sex, 
					jspersnr, 
					jsedu, 
					pbsedu
				FROM
					user
				WHERE
					user.id = $id";
					
	$result = mysql_query( $query );
	
	$user = mysql_fetch_assoc( $result );

	// Sex:
	$query = "	SELECT	entry
				FROM	dropdown
				WHERE	list = 'sex'
				AND		item_nr = " . $user['sex'];
	$result = mysql_query( $query );
	
	if( mysql_num_rows( $result ) == 1 )
	{
		$sex_array = mysql_fetch_assoc( $result );
		$user['sex_str'] = $sex_array['entry'];
		
		$user['sex_symbol'] = ( $user['sex_str'] == "Weiblich" ) ? "&#9792;" : "&#9794;";
	}
	else
	{
		$user['sex_str'] = "";
		$user['sex_symbol'] = "";
	}
	
	// J+S Edu:
	$query = "	SELECT 	entry
				FROM 	dropdown
				WHERE	list = 'jsedu'
				AND		item_nr = '" . $user['jsedu'] . "'";
	$result = mysql_query( $query );
	
	if( mysql_num_rows( $result ) == 1 )
	{
		$jsedu_array = mysql_fetch_assoc( $result );
		$user['jsedu_str'] = $jsedu_array['entry'];
	}
	else
	{	$user['jsedu_str'] = "";	}
	
	// PBS Edu:
	$query = "	SELECT 	entry
				FROM 	dropdown
				WHERE	list = 'pbsedu'
				AND		item_nr = '" . $user['pbsedu'] . "'";
	$result = mysql_query( $query );
	
	if( mysql_num_rows( $result ) == 1 )
	{
		$pbsedu_array = mysql_fetch_assoc( $result );
		$user['pbsedu_str'] = $pbsedu_array['entry'];
	}
	else
	{	$user['pbsedu_str'] = "";	}

	// birthday:
	$user['birthday_str'] = "";
	
	if( is_numeric( $user['birthday'] ) )
	{
		$date = new c_date();
		
		$date->setDay2000( $user[ 'birthday' ] );
		$user['birthday_str'] = $date->getString( "d.m.Y" );
	}

	// Profile Pic:
	$user[ 'avatar' ] = "index.php?app=user_profile&cmd=show_avatar&show_user_id=" . $id;
	
	$_page->html->set( 'user_detail', $user );
