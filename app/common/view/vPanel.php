<?php
class vPanel extends vCore
{
	private $elements;
	private $title;
	private $description;
	private $buttons;
	
	public function __construct($title, $description = '', $element = false)
	{
		$this->title = $title;
		$this->description = $description;
		$this->buttons = array();
		$this->elements = array();
		if($element)
		{
			$this->addElement($element);
		}
	}
	
	public function addButton($name,$link,$icon = false)
	{
		$ic = '';
		if ($icon)
		{
			$ic = '<i class="glyphicon glyphicon-'.$icon.'"></i> ';
		}
		$this->buttons[] = '<a href="'.$link.'" class="btn btn-default btn-xs">'.$ic.$name.'</a>';
	}
	
	public function addElement($element)
	{
		$this->elements[] = $element;
	}
	
	public function render()
	{
		$content = '';
		foreach ($this->elements as $el)
		{
			if(is_string($el))
			{
				$content .= $el;
			}
			else
			{
				$content .= $el->render();
			}
		}
		$desc = '';
		if(!empty($this->description))
		{
			$desc = '
				<div class="panel-body">
					<p>'.$this->description.'</p>
				</div>';
		}
		$btn = '';
		if(!empty($this->buttons))
		{
			$btn = '
			<div class="btn-group pull-right">';
			foreach ($this->buttons as $b)
			{
				$btn .= $b;
			}
			$btn .= '
				<div class="clearfix"></div>
			</div>';
		}
		
		return '
		<div class="panel panel-default">
			<div class="panel-heading">'.$this->title.''.$btn.'</div>
				'.$desc.'
				<div class="panel-content">
					'.$content.'
				</div>
		</div>';
	}
}