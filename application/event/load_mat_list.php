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

	$query = "	SELECT
					id as id,
					name as name
				FROM
					mat_article
				
				UNION
				
				SELECT
					mat_article.id as id,
					concat( mat_article_alias.name, ' (', mat_article.name, ')' ) as name
				FROM
					mat_article,
					mat_article_alias
				WHERE
					mat_article_alias.mat_article_id = mat_article.id
				
				ORDER BY name";
	
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
	
	$mat_article = array();
	
	while( $row = mysqli_fetch_assoc( $result ) )
	{	$mat_article[] = $row['name'];	}
	
	//$mat_article = array( "test"  , "tast" );
	//print_r( $mat_article );
	
	$_js_env->add( 'mat_article_list', $mat_article );	
