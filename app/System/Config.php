<?php 

namespace App\System;

use Exception;

class Config
{

	public static $config;

	public static function get($part)
	{
		$config = self::load();

		if(is_array($config))
		{
			$part = explode('.', trim($part,'.'));

			if(count($part) != 2)
			{
				throw new Exception("Invalid config path.", 1);
			}

			if(array_key_exists($part[0], $config))
			{
				if(array_key_exists($part[1], $config[$part[0]]))
				{
					return $config[$part[0]][$part[1]];
				}
				else
				{
					throw new Exception("Configuration <u>".$part[0].'.'.$part[1]."</u> is not found at app/config/config.php.", 1);	
				}
			}
		}

		throw new Exception("Error processing config.php.", 1);	
	}

	private static function load()
	{
		if(isset(self::$config))
		{
			return self::$config;
		}
		else
		{
			self::$config = require_once APP_ROOT.'config/config.php';

			return self::$config;
		}
	}
}