<?php 
class vMiniGallery extends vCore
{
	private $images;
	private $id;
	private $rating;
	
	
	public function __construct($images = array())
	{
		$this->rating = false;
		$this->images = $images;
		$this->id = $this->id('mgallery');
	}
	
	public function setRating($val= true)
	{
		$this->rating = $val;
	}
	
	public function render()
	{
		
		if(is_array($this->images) && count($this->images) > 0)
		{
			addScript('/js/jquery.mGallery.js');
			
			$foot = '';
			if(count($this->images) > 4)
			{
				$foot = '<p class="foot"><a class="show" href="#">Alle Bilder ansehen</a></p>';
			}
			
			$rating = '';
			if($this->rating)
			{
				$rate = round($this->rating);
				$rating = '<span class="g_rating"><span class="rating" style="width:'.($rate*20).'px"></span><span class="rating hold" style="width:'.((5-$rate)*20).'px"></span></span>';
			}
			
			$out = '
			<div id="'.$this->id.'" class="mgallery">
				
				<a href="#" class="big" style="background-image:url(/'.$this->images[0]['folder'].'364x254-'.$this->images[0]['file'].');"><span class="img">'.$rating.'</span></a>
				
				<div class="small-wrapper">';
			
			$tmp = $this->images[0];
			unset($this->images[0]);
			$this->images[] = $tmp;
			
			foreach ($this->images as $i => $img)
			{
				$out .= '
					<a data-big="/'.$img['folder'].'364x254-'.$img['file'].'" class="small" href="#" style="background-image:url(/'.$img['folder'].'111x77-'.$img['file'].');"><span></span></a>';
			}
			
			$out .= '
					<div class="clearfix"></div>
				</div>
				'.$foot.'
			</div>';
			return $out;
		}
		return '';
	}
}