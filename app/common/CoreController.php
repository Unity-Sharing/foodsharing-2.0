<?php
/**
 * The CoreController will be extendet by all Controllers
 * The Controllers that output only json and the big ones too
 * 
 * @author Raphael Wintrich
 *
 */
class CoreController
{
	
	public function strval($str)
	{
		require strip_tags($str);
	}
	
	public function intval($val)
	{
		return (int)$val;
	}
	
	public function htmlval($html)
	{
		return strip_tags($html,'<a><b><p><div><strong><table><th><td><tr><thead><tbody><tfoot><ul><li>');
	}
	
	public function getPostFile($file)
	{
		if(isset($_FILES[$file]) && (int)$_FILES[$file]['size'] > 0)
		{
			return true;
		}
		return false;
	}
	
	public function getPostLatLng($lat, $lng)
	{
		// later ;)
		if(($lat = $this->getPost($lat)) && ($lng = $this->getPost($lng)))
		{
			return array(floatval($lat),floatval($lng));
		}
		return false;
	}
	
	public function getPostZip($zip)
	{
		if($zip = $this->getPost($zip))
		{
			if((int)$zip > 100)
			{
				return preg_replace('/[^0-9]/', '', $zip);
			}
		}
		return false;
		
	}
	
	public function getPostHtml($name)
	{
		if($val = $this->getPost($name))
		{
			$val = strip_tags($val,'<p><ul><li><ol><strong><span><i><div><h1><h2><h3><h4><h5><br><img><table><thead><tbody><th><td><tr><i><a>');
			$val = trim($val);
			if(!empty($val))
			{
				return $val;
			}
		}
		return false;
	}
	
	public function getPostString($name)
	{
		if($val = $this->getPost($name))
		{
			$val = strip_tags($val);
			$val = trim($val);
			
			if(!empty($val))
			{
				return $val;
			}
		}
		return false;
	}
	
	public function getPostFloat($name)
	{
		if($val = $this->getPost($name))
		{
			$val = trim($val);
			return floatval($var);
		}
		return false;
	}
	
	public function getPostInt($name)
	{
		if($val = $this->getPost($name))
		{
			$val = trim($val);
			return (int)$val;
		}
		return false;
	}
	
	public function getPost($name)
	{
		if(isset($_POST[$name]) && !empty($_POST[$name]))
		{
			return $_POST[$name];
		}
		return false;
	}
	
	public function getPostRegEx($name,$pattern = '/[^a-z0-9A-Z]/')
	{
		if($val = $this->getPost($name))
		{
			$val = trim($val);
			$val = preg_replace($pattern, '', $val);
			if(!empty($val))
			{
				return $val;
			}
		}
		return false;
	}
	
	public function getPostInternUrl($name)
	{
		if($val = $this->getPost($name))
		{
			if(empty($val))
			{
				$val = '/';
			}
			
			if(substr($val, 0,1) == '/')
			{
				return $val;
			}
		}
		return false;
	}
	
	public function getPostArray($name)
	{
		$ids = array();
		if(isset($_POST[$name]) && is_array($_POST[$name]))
		{
			return $_POST[$name];
		}
		return false;
	}
	
	public function getPostTimeTable($name)
	{
		$ids = array();
		if(isset($_POST[$name]) && is_array($_POST[$name]))
		{
			return $_POST[$name];
		}
		return false;
	}
	
	public function getPostMongoIdArray($name)
	{
		$ids = array();
		if(isset($_POST[$name]) && is_array($_POST[$name]))
		{
			foreach ($_POST[$name] as $id)
			{
				$ids[] = $id;
			}
		}
		return $ids;
	}
	
	public function getPostEmail($name)
	{
		if($val = $this->getPost($name))
		{
			$val = trim($val);
			
			if(filter_var($val,FILTER_VALIDATE_EMAIL))
			{
				return $val;
			}
		}
		return false;
	}
	
	public function getPostUrl($name)
	{
		if($val = $this->getPost($name))
		{
			$val = trim($val);
			if(substr($val, 0,4) != 'http')
			{
				$val = 'http://'.$val;
			}
			if(filter_var($val,FILTER_VALIDATE_URL))
			{
				return $val;
			}
		}
		return false;
	}
}