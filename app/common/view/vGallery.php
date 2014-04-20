<?php
class vGallery extends vCore
{
	private $items;
	private $id;
	private $thumbsize;
	
	public function __construct($items = array(),$type = 'image')
	{
		$this->id = $this->id('gallery');
		
		$this->addList($items,$type);
		//addCss('/css/ekko-lightbox.css');
		//addScript('/js/ekko-lightbox.js');
		$this->thumbsize = array(100,100);
		
		addJs('
			$(document).delegate("*[data-toggle=\'lightbox\']", "click", function(event) { event.preventDefault(); $(this).ekkoLightbox(); }); 		
		');
	}
	
	public function setThumbSize($width,$height)
	{
		$this->thumbsize = array($width,$height);
	}
	
	public function add($item,$type = 'image')
	{
		$this->items[] = array(
			'type' => $type,
			'item' => $item
		);
	}
	
	public function addList($items = array(),$type = 'image')
	{
		foreach ($items as $i)
		{
			$this->add($i,$type);
		}
	}
	
	public function render()
	{
		$out = '';
		if(is_array($this->items) && !empty($this->items))
		{
			$out = '		
				<div class="row gallery" id="'.$this->id.'">
					';
			foreach ($this->items as $item)
			{
				if($item['type'] == 'image')
				{
					$out .= '						
					<a data-gallery="gal-'.$this->id.'" data-footer="'.$item['item']['desc'].'" data-title="'.$item['item']['name'].'" data-toggle="lightbox" href="/'.$item['item']['folder'].'800x0'.'-'.$item['item']['file'].'" title="'.$item['item']['name'].'">
						<img class="img-thumbnail img-responsive" src="/'.$item['item']['folder'].$this->thumbsize[0].'x'.$this->thumbsize[1].'-'.$item['item']['file'].'" alt="'.$item['item']['name'].'">
					</a>';
				}
			}
			$out .= '
					
				</div>';
		}
		return $out;
	}
}