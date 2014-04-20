<?php
/**
 * Global Configuration Class
 * 
 * @author Raphael Wintrich
 * 
 */
Class Conf
{
	public static	
		$LANG = 'de',
		$DB = 'fs2',
		$DB_HOST = '192.168.56.101',
		$DB_USER = 'fs',
		$DB_PASS = 'fs',
		$DB_PORT = 27017,
		$PAGE_TITLE = array('Foodsharing'),
		$PAGE_TITLE_SEPERATOR = ' - ',
		$EMAIL_INFO = 'kontakt@prographix.de';
}

/*
 * Display Errors
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
 * Directory constants
 */
define('DIR_CORE','../app/core/');
define('DIR_APP','../app/core/');
define('DIR_MODULE', '../app/module/');
define('DIR_LIB', '../lib/');
define('DIR_COMMON', '../app/common/');
define('DIR_TEMPLATE','../tpl/');
define('DIR_TMP','../tmp/');
define('DIR_LANG','../i18n/' . Conf::$LANG . '/');

