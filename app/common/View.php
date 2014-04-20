<?php
/**
 * The is the base Class for all Views in a module
 * so shared view elements have theire place in here
 * 
 * @author Raphael Wintrich
 *
 */
class View
{
	/**
	 * Render the global Breadcrumps to bootstrap like html
	 * 
	 * @param Array $breadcrumps
	 * @return HTML-String
	 */
	public function breadcrumps($breadcrumps)
	{
		$out = '';
		
		if(!empty($breadcrumps))
		{
			$end = end($breadcrumps);
			$out = '<ol class="breadcrumb">';
			for($i=0;$i<(count($breadcrumps)-1);$i++)
			{
				$out .= '<li><a href="'.$breadcrumps[$i]['url'].'">'.$breadcrumps[$i]['name'].'</a></li>';
			}
			$out .= '<li>'.$end['name'].'</li>';
			$out .= '</ol>';
		}
		
		return $out;
	}
}