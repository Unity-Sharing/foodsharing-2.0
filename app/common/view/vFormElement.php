<?php

class vFormElement extends vCore
{
	public $label;
	public $name;
	public $id;
	public $required;
	public $wrapper;
	private $checker;
	public $desc;
	public $value;
	public $option;
	
	public function __construct($id,$value = '',$option = array())
	{
		// set default options
		$option = array_merge(array(
			'required' => false,
			'wrapper' => true,
			'desc' => true,
			'value' => $value
		),$option);
		
		$this->option = $option;
		
		$this->label = s($id);
		if($option['desc'])
		{
			$this->desc = s($id.'_desc');
		}
		
		$this->value = $option['value'];
		$this->name = $id;
		$this->id = $this->id($id);
		$this->required = $option['required'];
		$this->wrapper = $option['wrapper'];
		$this->checker = array();
	}
	
	public function setValue($value)
	{
		$this->value = $value;
	}
	
	public function setDesc($desc)
	{
		$this->desc = $desc;
	}
	
	public function setRequired()
	{
		$this->required = true;
	}
	
	public function setLabel($name)
	{
		$this->label = $name;
	}
	
	public function getChecker()
	{
		if(!empty($this->checker))
		{
			return $this->checker;
		}
		return false;
	}
	
	public function addChecker($message,$type = 'presence', $selector = false)
	{
		if(!$selector)
		{
			$selector = '#'.$this->id;
		}
		
		$this->checker[] = array('"'.$selector.'"','"'.$type.'"','"'.$message.'"');
		//$this->checker = "g_metrics[g_metrics.length] = ['".$selector."','".$type."','".T::jsSafe($message)."'];";
	}
	
	public function addCheckerJs($message, $pattern, $selector = false)
	{
		if(!$selector)
		{
			$selector = '#'.$this->id;
		}
		
		$this->checker[] = array('"'.$selector.'"',$pattern,'"'.$message.'"');
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function setWrapper($val = false)
	{
		$this->wrapper = $val;
	}
	
	public function wrapper($html)
	{
		if($this->required)
		{
			$this->addChecker(sv('form_cant_be_empty',array('name'=>$this->label)));
		}
		if($this->wrapper)
		{
			$desc = '';
			if($this->desc)
			{
				$desc = '<label for="'.$this->id.'">'.$this->desc.'</label>';
			}
			return '
			<div class="form-group">
				'.$desc.'
				'.$html.'
			</div>';
		}
		else
		{
			return $html;
		}
	}
}