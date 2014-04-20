<?php
class vFormRadio extends vFormElement
{
	private $values;
	public function __construct($id,$values,$value = false,$options = array())
	{
		parent::__construct($id,$value,$options);
		$this->values = $values;
	}
	
	public function render()
	{
		$out = '
			<ul id="'.$this->id.'" class="list unstyled">';
		
		foreach ($this->values as $v)
		{
			$sel = '';
			if($v['id'] == $this->value)
			{
				$sel = ' selected';
			}
			$out .= '
				<option value="'.$v['id'].'"'.$sel.'>'.$v['name'].'</option>';
		}
		
		$out .= '
			</div>';
		return $this->wrapper($out);
	}
}