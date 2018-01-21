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
	
	class page
	{
		public $cssFiles = array();
		public $jsFiles  = array();
		
		public $cssRealpath = array();
		public $jsRealpath = array();
		
		public $app;
		public $cmd;
		public $html;
		
		function addCssFile( $file )
		{
			if( is_file( $file ) && !in_array( realpath( $file ), $this->cssRealpath ) )
			{
				$this->loadFileDependency( $file );

				array_push( $this->cssFiles, $file );
				array_push( $this->cssRealpath, realpath( $file ) );
			}
		}
		
		function addJsFile( $file )
		{
			if( is_file( $file ) && !in_array( realpath( $file ), $this->jsRealpath ) )
			{
				$this->loadFileDependency( $file );

				array_push( $this->jsFiles, $file );
				array_push( $this->jsRealpath, realpath( $file ) );
			}
		}
		
		function addCssConfig( $config )
		{
			foreach( $config as $file => $type )
			{
				if( $type == "app" )
				{	$this->addCssFile( $GLOBALS['public_app_dir'] . "/" . $this->app . "/css/" . $file );	}
				
				if( $type == "global" )
				{	$this->addCssFile( $GLOBALS['public_global_dir'] . "/css/" . $file );	}
				
				if( $type == "module" )
				{	$this->addCssFile( $GLOBALS['public_module_dir'] . "/css/" . $file );	}
			}
		}
		
		function addJsConfig( $config )
		{
			foreach( $config as $file => $type )
			{
				if( $type == "app" )
				{	$this->addJsFile( $GLOBALS['public_app_dir'] . "/" . $this->app . "/js/" . $file );	}
				
				if( $type == "global" )
				{	$this->addJsFile( $GLOBALS['public_global_dir'] . "/js/" . $file );	}
				
				if( $type == "module" )
				{	$this->addJsFile( $GLOBALS['public_module_dir'] . "/js/" . $file );	}
			}
		}
		
		function loadFileDependency( $file )
		{
			if( ! is_file( $file ) )
			{	return;	}
			
			$fh = fopen( $file, "r" );
			
			if( trim( fgets( $fh ) ) != "/** eCampConfig" )
			{	return;	}
		
			while( !feof( $fh ) )
			{
				$line = trim( fgets( $fh ) );
				
				if( $line == "**/" ){	break;		}
				if( $line == "" )	{	continue;	}
				
				//preg_match_all( "/\<depend *on *= *\"([^\"]*?)\".*\/\>/", $line, $depTags, PREG_SET_ORDER );
				preg_match_all( "/\<depend (.*?) \/\>/", $line, $depTags, PREG_SET_ORDER );
				
				foreach( $depTags as $dep )
				{
					$type = "";
					$path = "";
					
					preg_match_all( "/(on|type) *= *\"([^\"]*?)\"/", $dep[1], $args, PREG_SET_ORDER );
					
					foreach( $args as $arg )
					{
						if( $arg[1] == "on" )	{	$path = $arg[2];	continue;	}
						if( $arg[1] == "type" )	{	$type = $arg[2];	continue;	}
					}
					
					if( $type == "" ){	$type = end( pathinfo( $path, PATHINFO_EXTENSION ) );	}
					
					if( $type == "js" )	{	$this->addJsFile( $path );	continue;	}
					if( $type == "css")	{	$this->addCssFile( $path );	continue;	}				
				}
			}
			
			fclose( $fh );
		}
	}
	
	class user
	{
		public $id;
		public $ip;
		public $mail;
		public $scoutname;
		public $firstname;
		public $surname;
		public $display_name;
		public $admin;
		public $active;
		
		function load_data($data)
		{
			if( isset( $data['id'] ) )			{	$this->id = $data['id'];						}
			if( isset( $data['ip'] ) )			{	$this->ip = $data['ip'];						}
			if( isset( $data['mail'] ) )			{	$this->mail = $data['mail'];					}
			if( isset( $data['scoutname'] ) )		{	$this->scoutname = $data['scoutname'];		}
			if( isset( $data['firstname'] ) )		{	$this->firstname = $data['firstname'];		}
			if( isset( $data['surname'] ) )		{	$this->surname = $data['surname'];			}
			if( isset( $data['display_name'] ) )	{	$this->display_name = $data['display_name'];	}
			if( isset( $data['admin'] ) )			{	$this->admin = $data['admin'];				}
			if( isset( $data['active'] ) )		{	$this->active = $data['active'];				}
		}
	}
	
	class user_camp
	{
		public $id;
		public $function_id;
		public $auth_level;
		
		function load_data( $data )
		{
			if( isset( $data['id'] ) )			{	$this->id = $data['id'];						}
			if( isset( $data['function_id'] ) )	{	$this->function_id = $data['function_id'];	}
			if( isset( $data['auth_level'] ) )	{	$this->auth_level = $data['auth_level'];		}
		}
	}
	
	class camp
	{
		public $id;
		public $short_name;
		public $group_name;
		public $is_course;
		public $type;
		public $creator_user_id;
		
		function load_data($data)
		{
			if( isset( $data['id'] ) )				{	$this->id = $data['id'];	}
			if( isset( $data['short_name'] ) )		{	$this->short_name = $data['short_name'];	}
			if( isset( $data['group_name'] ) )		{	$this->group_name = $data['group_name'];	}
			if( isset( $data['type'] ) )				{	$this->type = $data['type'];	}
			if( isset( $data['is_course'] ) )			{	$this->is_course = $data['is_course'];	}
			if( isset( $data['creator_user_id'] ) )	{	$this->creator_user_id = $data['creator_user_id'];	}
		}

		function category( $id )
		{	return $this->check( "SELECT id FROM category WHERE id = $id AND camp_id = $this->id" );	}
		
		function course_aim( $id )
		{	return $this->check( "SELECT id FROM course_aim WHERE id = $id AND camp_id = $this->id" );	}
		
		function day( $id )
		{	return $this->check( "SELECT day.id FROM day, subcamp WHERE day.id = $id AND day.subcamp_id = subcamp_id AND subcamp.camp_id = $this->id" );	}
		
		function event( $id )
		{	return $this->check( "SELECT id FROM event WHERE id = $id AND camp_id = $this->id" );	}
		
		function event_aim( $id )
		{	return $this->check( "SELECT event_aim.id FROM event_aim, event WHERE event_aim.id = $id AND event_aim.event_id = event.id AND event.camp_id = $this->id" );	}
		
		function event_checklist( $id )
		{	return $this->check( "SELECT event_checklist.id FROM event_checklist, event WHERE event_checklist.id = $id AND event_checklist.event_id = event.id AND event.camp_id = $this->id" );	}
		
		function event_comment( $id )
		{	return $this->check( "SELECT event_comment.id FROM event_comment, event WHERE event_comment.id = $id AND event_comment.event_id = event.id AND event.camp_id = $this->id" );	}
		
		function event_detail( $id )
		{	return $this->check( "SELECT event_detail.id FROM event_detail, event WHERE event_detail.id = $id AND event_detail.event_id = event.id AND event.camp_id = $this->id" );	}
		
		function event_document( $id )
		{	return $this->check( "SELECT event_document.id FROM event_document, event WHERE event_document.id = $id AND event_document.event_id = event.id AND event.camp_id = $this->id" );	}
		
		function event_instance( $id )
		{
			return $this->check( "	SELECT event_instance.id FROM event_instance, event, day, subcamp 
									WHERE event_instance.id = $id AND event_instance.event_id = event.id AND event.camp_id = $this->id AND
									event_instance.day_id = day.id AND day.subcamp_id = subcamp.id AND subcamp.camp_id = $this->id" );
		}
		
		function event_responsible( $id )
		{	return $this->check( "SELECT event_responsible.id FROM event_responsible, event WHERE event_responsible.id = $id AND event_responsible.event_id = event.id AND event.camp_id = $this->id" );	}
		
		function job( $id )
		{	return $this->check( "SELECT id FROM job WHERE id = $id AND camp_id = $this->id" );	}
		
		function job_day( $id )
		{
			return $this->check( "	SELECT job_day.id FROM job_day, job, day, subcamp
									WHERE job_day.job_id = job.id AND job.camp_id = $this->id AND
									job_day.day_id = day.id AND day.subcamp_id = subcamp.id AND subcamp.camp_id = $this->id" );
		}
		
		function mat_event( $id )
		{	return $this->check( "SELECT mat_event.id FROM mat_event, event WHERE mat_event.id = $id AND mat_event.event_id = event.id AND event.camp_id = $this->id" );	}
		
		function mat_list( $id )
		{	return $this->check( "SELECT id FROM mat_list WHERE id = $id AND camp_id = $this->id" );	}
		
		function subcamp( $id )
		{	return $this->check( "SELECT id FROM subcamp WHERE id = $id AND camp_id = $this->id" );	}
		
		function todo( $id )
		{	return $this->check( "SELECT id FROM todo WHERE id = $id AND camp_id = $this->id" );	}
		
		function todo_user_camp( $id )
		{	return $this->check( "SELECT id FROM todo_user_camp, todo WHERE todo_user_camp.id = $id AND todo_user_camp.todo_id = todo.id AND todo.camp_id = $this->id" );	}
		
		function user( $id )
		{	return $this->check( "SELECT user_id FROM user_camp WHERE user_id = $id AND camp_id = $this->id AND active = 1" );	}

		function check( $query )
		{
			$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
			if( mysqli_error($GLOBALS["___mysqli_ston"]) )
			{	return 0;	}
			else
			{	return mysqli_num_rows( $result );	}
		}
	}
	
	class js_env
	{
		private $data = array();
		
		function add( $name, $value ){  $this->data[$name] = $value;   }
		
		function get_js_code()
		{
			$code = "";
			
		    if( isset($this->data) )
			  $code = "\$_var_from_php = ".json_encode($this->data).";";
			
			return $code;
		}
	}
	
	class news
	{
		function load( $user_id = 0 )
		{
			global $_user;
			if( !$user_id )	{	$user_id = $_user->id;	}
			
			$query = "SELECT news FROM user WHERE id = " . $user_id;
			$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );
			$news = mysqli_result( $result,  0,  'news' );
			
			$news = json_decode( $news, true ) or $news = array();
			krsort( $news );
			
			return $news;
		}
		
		function add2camp( $title, $text, $date = 0, $camp_id = 0 )
		{
			global $_camp;
			
			if( !$date )		{	$date = time();	}
			if( $camp_id == 0 )	{	$camp_id = $_camp->id;	}

			$query ="	SELECT user.id, user.news 
						FROM user, user_camp 
						WHERE 
							user_camp.active = 1 AND
							user_camp.camp_id = $camp_id AND
							user.id = user_camp.user_id";
			$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query );

			while( $user = mysqli_fetch_assoc( $result ) )
			{	$this->add2user( $title, $text, $date, $user['id'] );	}
		}
		
		function add2user( $title, $text, $date = 0, $user_id = 0 )
		{
			if( !$date )	{	$date = time();	}
			if( !$user_id )	{	$_user->id;		}

			$news = $this->load( $user_id );

			while( array_key_exists( $date, $news ) )	{	$date ++;	}
			$news[$date] = array( "key" => $date, "date" => date( "d.m.Y H:i", $date ), "title" => $title, "text" => $text );
			
			krsort( $news );
			
			if( count( $news ) > $GLOBALS['news_num'] )
			{	$news = array_slice( $news, count( $news ) - $GLOBALS['news_num'], $GLOBALS['news_num'], true );	}

			$this->save( $news, $user_id );
		}
		
		function remove( $key, $user_id = 0 )
		{
			global $_user;
			if( !$user_id )	{	$user_id = $_user->id;	}
			
			$news = $this->load( $user_id );

			$news[$key] = null;
			$news = array_filter( $news );

			$this->save( $news, $user_id );
		}
		
		function save( $news, $user_id = 0 )
		{			
			global $_user;
			if( !$user_id )	{	$user_id = $_user->id;	}
			
			$news = json_encode( $news );
			$news = addslashes( $news );
			
			$query = "UPDATE user SET `news` = '$news' WHERE id = " . $user_id;
			mysqli_query($GLOBALS["___mysqli_ston"],  $query );
		}
	}
