<?php 
/*
 * start session
 */ 
S::init();


/*
 * MONGO Connect
*/
require_once DIR_CORE . 'DbConnect.php';

/*
 * init Autoloader
 */
require_once DIR_CORE . 'autoload.php';

/*
 * base routing
 */ 
Benchmark::out('include autoloader');
require_once DIR_CORE . 'Router.php';
Router::init(array(
	'imprint' => array('main','imprint'),
));
Benchmark::out('Routing');


/*
 * important assets
 */
addScript('//code.jquery.com/jquery-1.11.0.min.js');
addScript('//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js');
addScript('/js/script.js');

addCss('//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css');
addCss('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css');
addCss('/css/style.css');

/*
 * boot the controller
 */
$controller = Router::$controller;
$action = Router::$action;
	
$app = new $controller();
if(method_exists($app,$action))
{
	$app->$action();
		
	/*
	 * get messages
	*/
	S::initMessages();
	
	/*
	 * Include the template file which is defined in Controller default is default.php
	 */
	include $app->getTemplate();
}
else
{
	T::go('/');
}

?>