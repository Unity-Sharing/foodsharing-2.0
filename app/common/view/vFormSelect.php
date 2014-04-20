<?php
class vFormSelect extends vFormElement
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
			<select id="'.$this->id.'" name="'.$this->id.'" class="form-control">';
		
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
			</select>';
		return $this->wrapper($out);
	}
}