<?php

class vCore 
{
	public function id($id)
	{
		global $g_ids;
		$tmp_id = $id;
		$i=0;
		while (isset($g_ids[$tmp_id]))
		{
			$i++;
			$tmp_id = $id.'_'.$i;
		}
		$g_ids[$tmp_id] = true;
		return $tmp_id;
	}
}