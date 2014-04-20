<?php
class vFormNone extends vFormElement
{	
	public function __construct($id, $value = '', $option = array())
	{
		parent::__construct($id,$value, $option);
	}
	
	public function render()
	{		
		return $this->wrapper('<div id="'.$this->id.'">'.$this->value.'</div>');
	}
}