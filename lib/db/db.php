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

	
	/*
	$config = array(
		"camp" => array(
			"id" => NULL
		),
		"category" => array(
			"id" => NULL,
			"camp_id" => "camp"
		)
	);
	*/
	
	class o {}
	
	
	class db
	{
		public $_meta;
		
		function __construct($config )
		{
			$this->_meta = new o();
			$this->_meta->config = $config;
			$this->_meta->loaden_table = array();
		}
		
		function load_table( $table )
		{
			if( !array_key_exists( $table, $this->_meta->config ) )	{	return false;	}
			
			if( !in_array( $table, $this->_meta->loaden_table ) )
			{
				$this->$table = new db_table( $table, $this->_meta->config[$table], $this );
				
				foreach( $this->_meta->loaden_table as $t )
				{
					if( array_key_exists( $table, $this->$t->_meta->waiting_for_table ) )
					{	$this->$t->waiting_table_is_loaden( $table );	}
				}
				
				$this->_meta->loaden_table[] = $table;
			}
		}
		
	}
	
	class db_table
	{
		public $_meta;
		public $_data = array();
		
		function __construct($table,$config,$db )
		{
			$this->_meta = new o();
			$this->_meta->config = $config;
			$this->_meta->db = $db;
			$this->_meta->waiting_for_table = array();
			
			foreach( $this->_meta->config as $c => $t )
			{
				if( $t && !in_array( $t, $this->_meta->db->_meta->loaden_table ) )
				{	$this->_meta->waiting_for_table[$t] = $c;	}
			}
			
			global $_Q;
			
			$query = $_Q[$table];
			
			$result = mysql_query( $query );
			if( mysql_error() )	{	return false;	}
			
			
			while( $row = mysql_fetch_assoc( $result ) )
			{
				$id = $row['id'];
				$this->$id = new db_row( $row, $this->_meta->config, $this );
				$this->_data[$id] = $this->$id;
			}
			
		}
		
		function waiting_table_is_loaden( $t )
		{
			$c = $this->_meta->waiting_for_table[$t];
			
			foreach( $this->_data as $r )
			{
				$t_id = $r->$c;
				$r->$t = $this->_meta->db->$t->$t_id;
			}
			
			$this->_meta->waiting_for_table[$t] = null;
			$this->_meta->waiting_for_table = array_filter( $this->_meta->waiting_for_table );
		}
		
		function get_row( $id )
		{	return $this->$id;	}
	}
	
	class db_row
	{
		public $_meta;
		
		function __construct($row,$config,$db_table )
		{
			$this->_meta = new o();
			$this->_meta->config = $config;
			$this->_meta->db_table = $db_table;
			
			foreach( $row as $n => $c )
			{
				$this->$n = $c;
				
				$nn = $this->_meta->config[$n];
				if( $nn && in_array( $nn, $this->_meta->db_table->_meta->db->_meta->loaden_table ) )
				{	$this->$nn = $this->_meta->db_table->_meta->db->$nn;	}
			}
		}
		
		function get_cell( $name )
		{	return $this->$name;	}
	}
?>