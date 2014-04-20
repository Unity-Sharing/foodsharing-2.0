<?php

class vFormHidden extends vFormElement
{
	public function __construct($id,$value='')
	{
		$this->id = $this->id($id);
		$this->name = $id;
		$this->setValue($value);
	}
	
	public function render()
	{
		return '<input type="hidden" name="'.$this->name.'" value="'.$this->value.'" id="'.$this->id.'">';
	}
}