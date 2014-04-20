<?php
class vFormSwitch extends vFormElement
{
	public function __construct($id, $value = false, $option = array())
	{
		$option = array_merge(array(
			'on_label' => s('yes'),
			'off_label' => s('no')
		),$option);
		
		parent::__construct($id,$value,$option);
		addJs('$("#'.$this->id.'").switchButton({
			labels_placement: "right",
			on_label: "'.$this->option['on_label'].'",		
            off_label: "'.$this->option['off_label'].'"
		});');
	}
	
	public function render()
	{
		$chk = '';
		if($this->value)
		{
			$chk = ' checked';
		}
		return $this->wrapper('<div><input type="checkbox" name="'.$this->id.'" id="'.$this->id.'"'.$chk.'></div>');
	}
}