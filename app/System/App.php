<?php 

namespace App\System;

use Exception;

class App
{
	private $controller;

	private $router;

	public function __construct()
	{
		try {
			$this->loadRouter();
			$this->loadController();
			$this->loadMethod();
			var_dump($this->router);
		} catch (Exception $e) {
			echo  "<center style='margin-top: 200px;'><h2 style='color:red;'>Critical error:<br> ".$e->getMessage() ." - line ".$e->getLine().' '.$e->getFile()."</h2></center>";
		}
	}

	private function loadRouter()
	{
		$this->router = new Router;
	}

	private function loadMethod()
	{
		if(isset($this->controller))
		{
			$controller = $this->controller;
			$method = $this->router->getMethod();

			if(method_exists($controller,$method))
			{
				if(empty($this->router->getParameters()))
				{
					return $controller->$method();
				}

				$parameters = $this->router->getParameters();

				return call_user_func_array([$controller, $method], $parameters);
			}

			throw new Exception("Method - <u>".$this->router->getMethod()."</u> does not exist", 1);
			
		}
	}

	private function loadController()
	{
		$controller = $this->router->getController();

		if($controller != null)
		{
			if(file_exists(CONTROLLERS_ROOT.$controller.'.php') && class_exists('\App\Controllers\\'.$controller))
			{
				$controller = '\App\Controllers\\'.$controller;

				$this->controller = new $controller;

				return true;
			}

			throw new Exception("File - <u>".$controller.".php</u> was not found, or file name mismatch with class name.", 1);
		}
	}
}