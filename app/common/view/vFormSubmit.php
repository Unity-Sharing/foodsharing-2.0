<?php
class vFormSubmit extends vFormElement
{
	public function __construct($id)
	{
		parent::__construct($id);
		$this->wrapper = false;
		$this->label = s($id);
	}
	
	public function render()
	{
		return '<button type="submit" name="'.$this->id.'" id="'.$this->id.'" value="'.$this->label.'" class="btn btn-primary">'.$this->label.'</button>';
	}
}