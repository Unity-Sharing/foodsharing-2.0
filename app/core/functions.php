<?php

/**
 * Some Global functions that we will need overall
 * 
 */

$g_script = array();
$g_css_files = array();
$g_js = '';
$g_js_func = '';

function addScriptTop($src,$compress = false)
{
	global $g_script;
	$new = array();
	$new[$src] = $compress;
	foreach ($g_script as $src => $v)
	{
		$new[$src] = $v;
	}
	$g_script = $new;
}

function getListingCount()
{
	global $g_config;
	return $g_config['docs_listing_count'];
}

function addCssTop($src,$compress = false)
{
	global $g_css_files;
	$new = array();
	$new[$src] = $compress;
	foreach ($g_css_files as $src => $v)
	{
		$new[$src] = $v;
	}
	$g_css_files = $new;
}

function addScript($src,$compress = false)
{
	global $g_script;
	$g_script[$src] = $compress;
}

function addCss($src,$compress = false)
{
	global $g_css_files;
	$g_css_files[$src] = $compress;
}

function go($url)
{
	fURL::redirect($url);
}

function addJs($js)
{
	global $g_js;
	$g_js .= ' '.$js;
}

function addJsFunc($js)
{
	global $g_js_func;
	$g_js_func .= ' '.$js;
}

function getLocation()
{
	if($loc = S::getLocation())
	{
		return $loc;
	}
	return array(50.75592,10.283203);
}

function goLogin()
{
	go('/user/login?ref='.urldecode(T::getSelf()));
}

/*
 * info, error & success Messages will be stored in session and output after page is loaded
 */
function info($msg,$title = false)
{
	//addJs('info(\''.T::jsSafe($msg).'\');');
	S::addMsg($msg, 'info', $title);
}

function error($msg, $title = false)
{
	S::addMsg($msg, 'error',$title);
}

function success($msg, $title = false)
{
	S::addMsg($msg, 'success',$title);
}

/**
 * this function all nesssary head output for html5 templates
 */
function getHead()
{
	global $g_css_files;
	
	$out = '';
	
	foreach ($g_css_files as $src => $compress)
	{
		if(!$compress)
		{
			$out .= '
	<link rel="stylesheet" href="'.$src.'">';
		}
	}
	$out .= '
	<link rel="stylesheet" href="/css/style.min.css">';
	
	return $out;
}

/**
 * here we go if we need some footer output for each page
 * 
 * @return string
 */
function getFoot()
{
	global $g_js;
	global $g_js_func;
	global $g_script;
	
	$out = '';
	
	foreach ($g_script as $src => $compress)
	{
		if(!$compress)
		{
			$out .= '
	<script src="'.$src.'"></script>';
		}
	}
	$out .= '
	<script src="/js/script.min.js"></script>
	<script type="text/javascript">
		'.JSMin::minify(
					$g_js_func.'
		$(document).ready(function(){
			'.$g_js.'
		});
	
		').'
	</script>';
	
	return $out;
}

/**
 * this will access comfortably the global content array
 * 
 * @param String $index
 * @return Ambigous <>|string
 */
function getContent($index)
{
	global $g_content;
	if(isset($g_content[$index]))
	{
		return $g_content[$index];
	}
	return '';
}

/**
 * loadView, loadModel, loadApp to get functonality of another module if we need
 * 
 * @param String Name of the Model
 */
function loadApp($folder)
{
	require_once DIR_APP.$folder.'/'.$folder.'.model.php';
	require_once DIR_APP.$folder.'/'.$folder.'.view.php';
	require_once DIR_APP.$folder.'/'.$folder.'.controller.php';
	include DIR_LANG.$folder.'.lang.'.LANG.'.php';
	addJsFunc(file_get_contents(DIR_APP.$folder.'/'.$folder.'.script.js'));
	
	$class = ucfirst($folder).'Controller';
	
	return new $class();
}

function loadView($folder)
{
	require_once DIR_APP . $folder . '/'.$folder . '.view.php';
	addJsFunc(file_get_contents(DIR_APP . $folder . '/' . $folder . '.script.js'));

	$class = ucfirst($folder).'View';

	return new $class();
}

/**
 * load the Model of another Module
 * 
 * @param String $folder
 * @return Object
 */
function loadModel($folder)
{
	require_once DIR_APP . $folder . '/'.$folder . '.view.php';
	addJsFunc(file_get_contents(DIR_APP . $folder . '/' . $folder . '.script.js'));

	$class = ucfirst($folder).'View';

	return new $class();
}

/**
 * function to get String in current language
 * 
 * @param String $index
 * @return String
 */
function s($index)
{
	global $g_lang;
	global $g_config;
	
	if(!isset($g_lang[$index]))
	{
		//file_put_contents(DIR_LANG.$g_config['app']['folder'].'.lang.'.$g_config['lang'].'.php', "\n".'$g_lang[\''.$index.'\'] = \''.$index.'\';',FILE_APPEND);
		return $index;
	}
	else
	{
		return $g_lang[$index];
	}
}

/**
 * get string in current lang with vars
 * 
 * @param String $index
 * @param Array $var 
 * @return String
 */
function sv($index,$var)
{
	if(!is_array($var))
	{
		$var = array($var);
	}
	global $g_lang;
	global $g_config;
	
	if(!isset($g_lang[$index]))
	{
		$cnt = '';
		foreach ($var as $i => $v)
		{
			$cnt .= '{'.$i.'} ';
		}
		//file_put_contents(DIR_LANG.$g_config['app']['folder'].'.lang.'.$g_config['lang'].'.php', "\n".'$g_lang[\''.$index.'\'] = \''.$index.' '.$cnt.'\';',FILE_APPEND);
		return $index;
	}
	else
	{
		$search = array();
		$replace = array();
		foreach ($var as $name => $value)
		{
			$search[] = '{'.$name.'}';
			$replace[] = $value;
		}
		return str_replace($search, $replace, $g_lang[$index]);
	}
}
/**
 * Global function to catch all the debug output
 * 
 * @param Object|String|Array
 */
function debug($obj)
{
	// lets do it later ;)
	print_r($obj);
}

/**
 * Include an template file if it will be found
 *
 *@param String Template file name
 */
function getTemplate($tpl)
{
	if(file_exists(DIR_TEMPLATE.$tpl.'.php'))
	{
		include DIR_TEMPLATE.$tpl.'.php';
	}
	else
	{
		return $tpl.' template not found';
	}
}
