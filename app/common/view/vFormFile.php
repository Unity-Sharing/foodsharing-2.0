<?php
class vFormFile extends vFormElement
{
	public $attributes;
	private $type;
	
	public function __construct($id, $value = '', $option = array())
	{
		parent::__construct($id,$value, $option);
		$this->attributes = '';
		$this->type = 'file';
	}
	
	public function setPassword()
	{
		$this->type = 'password';
	}
	
	public function addAttribute($attr,$value)
	{
		$this->attributes .= ' '.$attr.'="'.$value.'"';
	}
	
	public function render()
	{		
		return $this->wrapper('<input'.$this->attributes.' placeholder="'.$this->label.'" type="'.$this->type.'" name="'.$this->name.'" id="'.$this->id.'" value="'.$this->value.'">');
	}
}