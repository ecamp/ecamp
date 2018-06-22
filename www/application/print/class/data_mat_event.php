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

	
	class print_data_mat_event
	{
		
		public $pid;
		public $id;
		public $event_id;
		public $event;
		public $user_id;
		public $user;
		public $mat_list_id;
		public $mat_list;
		public $article_name;
		public $quantity;
		
		public $type;
		public $resp;
		
		function print_data_mat_event($data, $pid)
		{
			$this->pid = $pid;
			$this->id = $data['id'];
			$this->event_id = $data['event_id'];
			$this->user_id = $data['user_id'];
			$this->mat_list_id = $data['mat_list_id'];
			$this->article_name = $data['article_name'];
			$this->quantity = $data['quantity'];
			
			$this->event = $pid->event[$this->event_id];
			
			
			$this->type = "available";
			
			if ($this->user_id)
			{
				$this->user = $pid->user[$this->user_id];
				$this->type = "organize";
				$this->resp = "user";
			}
			
			if ($this->mat_list_id)
			{
				$this->mat_list = $pid->mat_list[$this->mat_list_id];
				$this->type = "organize";
				$this->resp = "mat_list";
			}
			
			
			if ($this->type == "available")
			{	$this->event->add_mat_available($this); }
			
			if ($this->type == "organize")
			{	$this->event->add_mat_organize($this); }
			
			
		}
		
	}
	
?>