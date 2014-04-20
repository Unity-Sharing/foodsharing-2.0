<?php

/*
 * Register Autoloader
 * this is an option, with this first letter technic we can easily use the flourish framework an increase the performance,
 * should we stay simple and stupid? ;)
 */

function __autoload($class_name)
{
	$folder = '';
	switch (substr($class_name, 0,1))
	{
		case 'f' : $folder =  DIR_LIB . 'flourishlib/'; break;
		case 'v' : $folder = DIR_COMMON . 'view/'; break;
		case 'm' : $folder = DIR_COMMON . 'model/'; break;
		default: break;
	}
	
	include_once $folder . $class_name . '.php';
}
