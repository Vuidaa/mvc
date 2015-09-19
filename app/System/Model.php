<?php 

namespace App\System;

class Model
{
	protected $db;

	protected function db()
	{
		if(isset($this->db)){
			return $this->db;
		}

		$this->db = Database::getInstance();

		return $this->db;
	}
}