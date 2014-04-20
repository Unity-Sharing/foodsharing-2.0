<?php
/*
 * Core Routing Engine
 */

/**
 * Here are only the core routy can be defined,
 * default options is that the first URI will define
 * the controller name and the 2nd the action
 * if no 2nd controller is defined the action is index
 * more deep routes can be defined in th controller self
 * so i think we have no overhead
 * 
 * @author Raphael Wintrich
 * 
 */

Class Router
{
	public static $controller;
	public static $action;
	public static $uri;
	
	public static function init($routes)
	{
		global $g_config;
		
		$uri = explode('?', $_SERVER['REQUEST_URI']);
		$uri = $uri[0];
		
		self::$uri = explode('/', $uri);
		
		$class = self::$uri[1];
		
		if(isset($routes[$class]))
		{
			$method = $routes[$class][1];
			$class = $routes[$class][0];
		}
		else if(count(self::$uri) == 2)
		{
			$method = 'index';
		}
		else
		{
			$method = self::$uri[2];
		}
		
		if(empty($class))
		{
			$class = 'main';
		}
		if(empty($method))
		{
			$method = 'index';
		}
		
		$folder = $class;
		$class = ucfirst($class);
		
		require_once DIR_LANG . Conf::$LANG. '.php';
		if(is_dir(DIR_MODULE.$folder))
		{
			require_once DIR_MODULE.$folder.'/'.$folder.'.db.php';
			require_once DIR_MODULE.$folder.'/'.$folder.'.view.php';
			require_once DIR_MODULE.$folder.'/'.$folder.'.controller.php';
			include_once DIR_LANG.$folder.'.lang.' . Conf::$LANG . '.php';
			
			self::$controller = $class . 'Controller';
			/*
			 * security reason give the action a prefix
			*/
			self::$action = 'action'.ucfirst($method);
		}
		else
		{
			T::go('/');
		}
	}
}
