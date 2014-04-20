<?php


class vForm extends vCore
{
	private $items;
	private $action;
	private $submit;
	private $id;
	
	public function __construct($elements = array(),$option = array())
	{
		$option = array_merge(array(
			'id' => 'form',
			'submit' => 'save'
		),$option);
		
		$this->id = $this->id($option['id']);		
		$this->action = T::getSelf();
		
		$this->submit = false;
		if($option['submit'] !== false)
		{
			$this->submit = $option['submit'];
		}
		$this->items = $elements;
		$this->add(new vFormHidden('submitted',$this->id));
	}
	
	public function setSubmit($value)
	{
		$this->submit = $value;
	}
	
	public function setAction($action)
	{
		$this->action = $action;
	}
	
	public function add($item)
	{
		$this->items[] = $item;
	}
	
	public function addHidden($id,$value)
	{
		$this->add(new vFormHidden($id,$value));
	}
	
	public function render()
	{
		if($this->submit !== false)
		{
			$this->add(new vFormSubmit($this->submit));
		}
		$out = '
		<div class="form-body">
			<form id="'.$this->id.'" method ="post" action="'.$this->action.'" enctype="multipart/form-data">';
		$metrics = array();
		foreach ($this->items as $item)
		{
			$out .= $item->render();
			if($chk = $item->getChecker())
			{
				foreach ($chk as $p)
				{
					$metrics[] = '['.$p[0].','.$p[1].','.$p[2].']';
				}
				
			}
		}
		if(!empty($metrics))
		{
			addJs('$("#'.$this->id.'").nod([ '.implode(',',$metrics).' ]);');
		}
		
		
		$out .= '
			</form>
		</div>';
		return $out;
	}
}