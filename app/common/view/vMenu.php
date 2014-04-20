<?php

class vMenu extends vCore
{
	private $items;
	private $class;
	
	public function __construct($items = array())
	{
		$this->class = array('nav');
		$this->items = $items;
	}
	
	public function addClass($name)
	{
		$this->class[] = $name;
	}
	
	public function add($name,$href,$attributes = array(),$opt = array())
	{
		$item = new vMenuItem($name,$href,$attributes,$opt);
		$this->items[] = $item;
		return $item;
	}
	
	public function render()
	{
		$menu = '';
		foreach ($this->items as $item)
		{
			$menu .= $item->render();
		}
		return '<ul class="'.implode(' ', $this->class).'">'.$menu.'</ul>';
	}
}