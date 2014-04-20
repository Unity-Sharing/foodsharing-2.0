<?php
class vFormTextarea extends vFormElement
{
	public function __construct($id,$value = '',$option = array())
	{
		parent::__construct($id,$value,$option);
	}
	
	public function render()
	{
		addJs('$("#'.$this->id.'").autosize();');
		return $this->wrapper('<textarea name="'.$this->name.'" id="'.$this->id.'"  placeholder="'.$this->label.'" class="form-control" rows="3">'.$this->value.'</textarea>');
	}
}