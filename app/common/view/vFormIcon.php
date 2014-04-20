<?php
class vFormText extends vFormElement
{
	public $attributes;
	private $type;
	
	public function __construct($id, $value = '', $option = array())
	{
		parent::__construct($id,$value, $option);
		$this->attributes = '';
	}
	
	public function addAttribute($attr,$value)
	{
		$this->attributes .= ' '.$attr.'="'.$value.'"';
	}
	
	public function render()
	{		
		return $this->wrapper('<input'.$this->attributes.' placeholder="'.$this->label.'" type="'.$this->type.'" name="'.$this->name.'" id="'.$this->id.'" class="form-control" value="'.$this->value.'">');
	}
}