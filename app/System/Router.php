<?php 

namespace App\System;

use Exception;

class Router
{
	protected $routes;

	protected $url;

	protected $controller;

	protected $method;

	protected $parameters = [];

	public function __construct()
	{
		$this->loadRoutes();
		$this->parseUrl();
		$this->getRouteFromUrl();
	}

	private function parseUrl()
	{
		$url = $this->getUrl();

		if($url == '/')
		{
			$this->url = '/';
			
			return;
		}

		$this->url = rtrim(filter_var($url, FILTER_SANITIZE_URL),'/');
		
		return;
	}

	private function routeExists()
	{
		$url = $this->url;

		if(array_key_exists($url, $this->routes))
		{
			$this->controller = $this->routes[$url][0];
			$this->method = $this->routes[$url][1];

			return true;
		}

		return false;
	}

	private function parameterRouteExists()
	{
		$url = explode('/',$this->url);

		if(count($url) == 1)
		{
			foreach ($this->routes as $key => $value) 
			{
				if(substr($key, 0,1) == '{' && substr($key, -1, 1) == '}')
				{
					$this->controller = $this->routes[$key][0];
					$this->method = $this->routes[$key][1];
					$this->parameters[] = $url[0];

					return true;
				}
				
			}

			return false;
		}
	}
	
	private function complexRouteExists()
	{
		$url = explode('/',$this->url);

		foreach ($this->routes as $key => $value) 
		{
			if($key != '/')
			{
				$parts = explode('/', $key);
				$match = 0;
				$params = [];

				if(count($url) == count($parts))
				{

					for ($i=0; $i < count($url); $i++) 
					{ 
						if($url[$i] == $parts[$i])
						{
							$match++;
						}
						else
						{
							if(substr($parts[$i], 0,1) == '{' && substr($parts[$i], -1, 1) == '}')
							{
								$match++;
								$params[] = $url[$i];
							}
						}
					}

					if($match == count($url))
					{
						$this->controller = $this->routes[$key][0];
						$this->method = $this->routes[$key][1];
						$this->parameters = $params;
					}
				}
			}
			
		}
	}

	private function getRouteFromUrl()
	{
		if(!$this->routeExists())
		{
			if(!$this->parameterRouteExists())
			{
				$this->complexRouteExists();

					if(!isset($this->controller))
					{
						throw new Exception("Route - <u>".$this->url."</u> was not defined at app/routes.php.", 1);
					}
			}
		}
	}


	private function loadRoutes()
	{
		$routes = APP_ROOT.'\\routes.php';

		if(file_exists($routes))
		{
			$routes = require_once $routes;
			
			if(!is_array($routes))
			{
				throw new Exception("routes.php file is empty (no routes defined).", 1);
			}

			foreach ($routes as $key => $value) 
			{
				if($key != '/')
				{
					$key = trim($key,'/');
				}
					
				$this->routes[$key] = $value;
			}

			return true;
		}

		throw new Exception("File routes.php was not found.", 1);
	}

	public function getParameters()
	{
		return $this->parameters;
	}

	public function getController()
	{
		return $this->controller;
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function getUrl()
	{
		return (isset($_GET['url'])) ? $_GET['url'] : '/';
	}
}