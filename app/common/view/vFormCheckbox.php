<?php
class vFormCheckbox extends vFormElement
{
	private $displayField;
	private $values;
	
	public function __construct($id,$values,$value = array(),$options = array())
	{
		if(empty($value))
		{
			$value = array();
		}
		$this->values = $values;
		
		parent::__construct($id,$value,$options);		
	}
	
	public function render()
	{
		$desc = '';
		if($this->wrapper)
		{
			$desc = $this->desc;
			$label = $this->label;
			$this->desc = $this->label;
			
			if(!empty($desc))
			{
				$desc = '<p>'.$desc.'</p>';
			}
		}
		$out = $desc.'
		<ul class="list-unstyled '.$this->id.'">';
		$option = array_flip($this->value);
		foreach ($this->values as $val)
		{
			$ckh = '';
			if(isset($option[$val['id']]))
			{
				$ckh = ' checked';
			}
			$out .= '
			<li class="checkbox"><label><input type="checkbox" name="'.$this->id.'[]" value="'.$val['id'].'"'.$ckh.'> '.$val['name'].'</label></li>';
		}
		
		$out .= '
		</ul>';
		
		return $this->wrapper($out);
	}
}