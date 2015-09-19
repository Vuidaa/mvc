<?php 

namespace App\System;

use PDO;

class Database
{
	protected static $instance;

	public static function getInstance()
	{
		if(isset(self::$instance)){
			return self::$instance;
		}

		self::$instance = new PDO("mysql:dbname=".Config::get('database.dbname').";host=".Config::get('database.host'), Config::get('database.user'), Config::get('database.password'));
		return self::$instance;
	}
}