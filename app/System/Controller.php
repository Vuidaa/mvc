<?php 

namespace App\System;

use Exception;
use PDO;

class Controller
{
	protected $db;

	protected function view($view, $data = [])
	{
		if(file_exists(VIEWS_ROOT.$view.'.php'))
		{
			include VIEWS_ROOT.$view.'.php';

			return true;
		}

		throw new Exception("View - <u>".$view.'.php</u> was not found.', 1);
		
	}

	protected function model($model)
	{
		if(file_exists(MODELS_ROOT.$model.'.php'))
		{
			if(class_exists('\App\Models\\'.$model))
			{
				$model = '\App\Models\\'.$model;

				return new $model;
			}
			else
			{
				throw new Exception("Model's <u>".$model."</u> file name mismatch with class name", 1);	
			}
		}

		throw new Exception("Model - <u>".$model.'</u> was not found.', 1);
		
	}

	protected function db()
	{
		if(isset($this->db))
		{
			return $this->db;
		}

		$this->db  = Database::getInstance();

		return $this->db;
	}
}