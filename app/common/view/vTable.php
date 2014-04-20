<?php
class vTable
{
	private $rowCount;
	private $rows;
	private $headrow;
	private $width;
	private $order;
	
	public function __construct()
	{
		$this->rowCount = 0;
		$this->rows = array();
		$this->headrow = array();
		$this->width = array();
		$this->order = array();
	}
	
	public function addRow($cols = array())
	{
		$this->rows[] = $cols;
	}
	
	public function setHeadRow($cols = array()) 
	{
		$this->headrow = $cols;
	}
	
	public function setWidth($index,$width)
	{
		$this->width[$index] = $width;
	}
	
	public function setOrder($index,$name)
	{
		$this->order[$index] = $name;
	}
	
	public function render()
	{
		$out = '
		<table class="table table-hover">';
		
		if($this->headrow)
		{
			
			$out .= '
			<thead>
				<tr>';
			foreach ($this->headrow as $i => $col)
			{
				$width = '';
				if(isset($this->width[$i]))
				{
					$width = ' width="'.$this->width[$i].'"';
				}
				
				if(!is_string($col))
				{
					$col = $col->render();
				}
				
				if(isset($this->order[$i]))
				{
					$l = 1;
					$caret = 'caret-reverse';
					if(isset($_GET['l']) && $_GET['l'] == 1)
					{
						$l = 0;
						$caret = 'caret';
					}
					$col = '<a href="'.T::getSelf().'?o='.$this->order[$i].'&l='.$l.'">'.$col.' <span class="'.$caret.'"></span></a>';
				}
				
				$out .= '
					<th'.$width.'>'.$col.'</th>';
				
			}
			$out .= '
				</tr>
			</thead>';
		}
		$out .= '
			<tbody>';
		foreach ($this->rows as $row)
		{
			$out .= '
				<tr>';
			foreach ($row as $col)
			{
					$out .= '
					<td>'.$col['cnt'].'</td>';
			}
			$out .= '
				</tr>';
		}
		$out .= '
			</tbody>
		</table>';
		return $out;
	}
}