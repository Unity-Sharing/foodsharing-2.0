<?php
class vButtonToolbar
{
	private $buttons;
	
	public function __construct($buttons = array())
	{
		$this->buttons = array();
		foreach ($buttons as $btn)
		{
			$this->addButton($btn);
		}
	}
	
	public function addButton($options = array())
	{
		$this->buttons[] = array_merge(array(
			'name' => '',
			'href' => false,
			'click' => false	,
			'icon' => false
		),$options);
	}
	
	public function render()
	{
		$out = '
		<div role="toolbar" class="btn-toolbar">
			<div class="btn-group">';
		
		foreach ($this->buttons as $btn)
		{
			$class = '';
			$attr = '';
			$cnt = '';
			if($btn['icon'])
			{
				$cnt .= '<span class="glyphicon glyphicon-'.$btn['icon'].'"></span>';
			}
			
			
			if($btn['click'])
			{
				$attr .= ' onclick="'.$btn['click'].'"';
			}
			if($btn['title'])
			{
				$attr .= 'title="'.$btn['title'].'"';
			}
			
			if($btn['href'])
			{
				$attr .= ' href="'.$btn['href'].'"';
			}
			
			if($btn['name'])
			{
				$cnt .= $btn['name'];
			}


			$out .= '
			<a class="btn btn-default'.$class.'" type="button"'.$attr.'>'.$cnt.'</a>';
		}
		
		$out .= '
			</div>
		</div>';
		
		return $out;
	}
}