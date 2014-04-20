<?php 
/*
 * Global Array that will save all ids on current page
 */
$g_ids = array();

/**
 * Toolkit Class called T for simpler use
 * 
 * @author Raphael Wintrich
 *
 */
class T
{
	/**
	 * Redirect to an internal or external URL
	 * 
	 * @param String $url
	 */
	public function go($url)
	{
		header('Location: '.$url);
		exit();
	}
	
	/**
	 * Return to digits of Number with 0 at first place if its smaller than 10
	 * 
	 * @param Integer $num
	 * @return string
	 */
	public static function preZero($num)
	{
		return str_pad ( $num, 2, '0', STR_PAD_LEFT );
	}
	
	/**
	 * will return the current URI without GET parameters
	 * 
	 * @return String
	 */
	public static function getSelf()
	{
		$out = explode('?',$_SERVER['REQUEST_URI']);
		return $out[0];
	}
	
	/**
	 * Lets make the Text Shorter but dont cut words
	 * 
	 * @param String $str
	 * @param Integer $length
	 * @return string
	 */
	public static function tt($str,$length = 160)
	{
		if(strlen($str) > $length)
		{
			$str = preg_replace("/[^ ]*$/", '', substr($str, 0, $length)).' ...';
		}
		return $str;
	}
	
	public static function jsSafe($str,$quote = "'")
	{
		$replace = "\\'";
		if($quote == '"')
		{
			$replace = '\\"';
		}
		return str_replace($quote, $replace, $str);
	}
	
	/**
	 * Method to make an clean name can used for uri
	 * 
	 * @param String $name
	 * @return String
	 */
	public static function cleanUriName($name)
	{
		$name = strtolower($name);
		$name = trim($name);
		$name = str_replace(array('  ','	','_','/','\\'), ' ', $name);
		$name = str_replace(array(' ','ä','ö','ü','ß','é','á'), array('-','ae','oe','ue','ss','e','a'), $name);
		return preg_replace('/[^a-z0-9\-]/', '', $name);
	}
	
	/**
	 * replace url adresses with html links
	 * 
	 * @param String $text
	 * @param Boolean $new_window
	 * @return String
	 * 
	 */
	public static function linkify($text,$new_window = true) 
	{
		$target = '';
		if($new_window)
		{
			$target = ' target="_blank"';
		}
		$reg_exUrl = "/((http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?)/";
		if(preg_match($reg_exUrl, $text)) 
		{
			return preg_replace($reg_exUrl, '<a href="${1}" '.$target.'>${1}</a> ', $text);
		} 
		else 
		{
			return $text;
		}
	}
}