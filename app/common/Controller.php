<?php
/**
 * Base Controler for alle the Controllers
 * they will output html to the Browser
 * every Controller will extending this class 
 * so all the common stuff that we need everywhere
 * willl be comme in here
 * 
 * @author Raphael Wintrich
 *
 */
class Controller extends CoreController
{
	private $template;
	private $breadcrumps;
	
	/**
	 * The Constructor has 3 Jobs
	 * 
	 * 1. set the default template
	 * 2. init breadcrumps
	 * 3. If no geolocation of the user is detected add some JS Code to do it
	 */
	public function __construct()
	{
		$this->setTemplate('default');
		$this->breadcrumps = array();
		
		addJs('
				$("a[href=\''.T::getSelf().'\']").parent("li").addClass("active");
		');
		$this->addBread(S('start'), '/');
		
		if(!S::getLocation())
		{
			addJs('
			$.getJSON("http://www.geoplugin.net/json.gp?ip='.$_SERVER['REMOTE_ADDR'].'&jsoncallback=?", function(data) {
			    if(data.geoplugin_status != undefined && data.geoplugin_status >= 200 && data.geoplugin_status < 300)
				{
					$.getJSON("http://www.geoplugin.net/extras/postalcode.gp?lat="+data.geoplugin_latitude+"&long="+data.geoplugin_longitude+"&format=json&jsoncallback=?", function(plz){
						if(plz.geoplugin_place != undefined)
						{
							ajreq({
								app:"karte",
								action:"setlocation",
								data: {
									lat: data.geoplugin_latitude,
									lng: data.geoplugin_longitude,
									city: plz.geoplugin_place,
									zip: plz.geoplugin_postCode
								}
							});
						}
					});
				}
			});
		');
			
		}
	}
	
	/**
	 * Set Content and define the position where it will be dispatched
	 * All those positions are accessable in Templates with getContent()
	 * 
	 * @param String $content
	 * @param string $position
	 */
	public function setContent($content,$position = 'main')
	{
		global $g_content;
		
		$g_content[$position] = $content;
	}
	
	/**
	 * Send File Content to Browser and make the Download secret MIME Type is detecting automaticly
	 * 
	 * @param String $file
	 * @param string $name
	 */
	public function fileDownload($file,$name = null)
	{
		$file  = new fFile($file);
		
		$file->output(true,$name);
	}
	
	/**
	 * Here you can change the Template file
	 * 
	 * @param String $name
	 */
	public function setTemplate($name)
	{
		$this->template = $name;
	}
	
	/**
	 * simply returns an Template file
	 * 
	 * @return String
	 */
	public function getTemplate()
	{
		return DIR_TEMPLATE.$this->template.'.php';
	}
	
	/**
	 * Add an Breadcrump Item
	 * 
	 * @param String $name
	 * @param String $url
	 */
	public function addBread($name,$url)
	{
		$this->breadcrumps[] = array(
			'url' => $url,
			'name' => $name
		);
	}
	
	
	/**
	 * Returnd Rendered Breadcrumps
	 * 
	 * @return String 
	 */
	public function getBread()
	{
		return $this->view->breadcrumps($this->breadcrumps);
	}
	
	/**
	 * Checks URI - is it an Integer? and return it if true
	 * 
	 * @param Integer $index
	 * @return number|boolean
	 */
	public function uriInt($index)
	{
		if(($val = (int)$this->uri($index)) !== false)
		{
			return $val;
		}
		return false;
	}
	
	/**
	 * Check URI by POsition - Is it an String and return it if true
	 * 
	 * @param Integer $index
	 * @return String|boolean
	 */
	public function uriStr($index)
	{
		if(($val = $this->uri($index)) !== false)
		{
			return preg_replace('/[^a-z0-9\-]/','',$val);
		}
		return false;
	}
	
	/**
	 * Checks by position of URI is it an Mongo ID?
	 * 
	 * @param Integer $index
	 * @return mixed|boolean
	 */
	public function uriMongoId($index)
	{
		if(($val = $this->uri($index)) !== false)
		{
			return preg_replace('/[^a-z0-9]/','',$val);
		}
		return false;
	}
	
	/**
	 * Checks an URI by position if it is named like the 1. param
	 * 
	 * @param String $name to check
	 * @param Integer $index
	 * @return boolean
	 */
	public function isUri($name, $index = 3)
	{
		if($this->uri($index) == $name)
		{
			return true;
		}
		return false;
	}
	
	/**
	 * Get the URI Item by position
	 * 
	 * @param Integer $index
	 * @return String|boolean
	 */
	public function uri($index)
	{
		if(isset(Router::$uri[$index]))
		{
			return Router::$uri[$index];
		}
		return false;
	}
	
	/**
	 * Adds an Meta-Title String
	 * 
	 * @param String $title
	 */
	public function addTitle($title)
	{
		Conf::$PAGE_TITLE[] = $title;
	}
	
	/**
	 * Return rendered Meta-Title
	 * 
	 * @return string
	 */
	public function getTitle()
	{
		global $g_config;
		return implode(Conf::$PAGE_TITLE_SEPERATOR, Conf::$PAGE_TITLE);
	}
	
	/**
	 * Checks is an default form is beeing submittet, it checks the hidden field named "submitted"
	 * 
	 * @param string $form
	 * @return boolean
	 */
	public function isSubmitted($form = false)
	{
		if(isset($_POST['submitted']))
		{
			if($form !== false && $_POST['submitted'] != $form)
			{
				return false;
			}
			return true;
		}
		return false;
	}
	
	public function out($arr)
	{
		return $arr;
	}
	
	/**
	 * Add an info message and will be outputted directly
	 * 
	 * @param String $msg
	 */
	public function info($msg)
	{
		addJs('info(\''.T::jsSafe($msg).'\');');
	}
	
	/**
	 * Add an error Message an output directly
	 * 
	 * @param String $msg
	 */
	public function error($msg)
	{
		addJs('error(\''.T::jsSafe($msg).'\');');
	}
}