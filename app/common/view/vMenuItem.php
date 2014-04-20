<?php

class vMenuItem extends vCore
{
	private $type;
	private $items;
	private $attr;
	private $name;
	
	public function __construct($name,$href = '#',$attributes = array(), $opt = array())
	{
		$this->name = $name;
		$this->attr = $attributes;
		$this->items = array();
		$this->attr['href'] = $href;
		
		if(T::getSelf() == $href)
		{
			$this->attr['class'] = 'active';
		}
		
	}
	
	public function add($item)
	{
		$this->items[] = $item;
	}
	
	public function render()
	{
		$attributes = '';
		foreach ($this->attr as $attr => $value)
		{
			$attributes .= ' '.$attr.'="'.$value.'"';
		}
		
		$li_attr = '';
		$submenu = '';
		if(!empty($this->items))
		{
			$submenu = '<ul class="dropdown-menu">';
			if(!isset($this->attr['class']))
			{
				$this->attr['class'] = 'dropdown-toggle';
			}
			else
			{
				$this->attr['class'] .= ' dropdown-toggle';
			}
			$this->attr['data-toggle'] = 'dropdown';
			$this->name .= '<b class="caret"></b>';
			$li_attr = ' class="dropdown"';
			foreach ($this->items as $item)
			{
				$submenu .= $item->render();
			}
			$submenu .= '</ul>';
		}
		
		return '<li'.$li_attr.'><a'.$attributes.'>'.$this->name.'</a>'.$submenu.'</li>';
	}
}

?>