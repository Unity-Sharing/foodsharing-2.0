<?php
class vFormOneCheck extends vFormElement
{
	public function __construct($id, $value = false, $option = array())
	{		
		parent::__construct($id,$value,$option);
	}
	
	public function render()
	{
		$chk = '';
		if($this->value)
		{
			$chk = ' checked';
		}
		return $this->wrapper('
			<ul class="list-unstyled">
		      <li class="checkbox"><label> <input type="checkbox" name="'.$this->id.'"'.$chk.'> '.$this->label.'</label></li>
		    </ul>');
	}
}