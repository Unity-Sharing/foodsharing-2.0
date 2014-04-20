<?php
class vFormVideo extends vFormElement
{
	public function __construct($id,$value = array(),$option = array())
	{
		parent::__construct($id,$value,$option);
		
		/*  <div class="col-xs-6 col-md-3"><a class="thumbnail" href="#"><img style="height: 180px; width: 100%; display: block;" src="\'+vid.thumb+\'"></a></div>
      */
		
		
		addJs('			
			$.jVideo("#'.$this->id.'");
		');	
			
	}
	
	public function render()
	{
		
		//print_r($this->value);die();
		
		/*
		 * 
		[0] => Array
        (
            [code] => 6C99zDU4Xp8
            [url] => http://www.youtube.com/watch?v=6C99zDU4Xp8&list=PLgPtEAlwxgklMgOWe5_v4yN7Y6zT4Dxp9
            [thumb] => http://img.youtube.com/vi/6C99zDU4Xp8/0.jpg
            [thumb_small] => http://img.youtube.com/vi/6C99zDU4Xp8/2.jpg
        )

   		[1] => Array
        (
            [code] => 803Ukvp-5NY
            [url] => http://www.youtube.com/watch?v=803Ukvp-5NY&list=PLgPtEAlwxgklMgOWe5_v4yN7Y6zT4Dxp9
            [thumb] => http://img.youtube.com/vi/803Ukvp-5NY/0.jpg
            [thumb_small] => http://img.youtube.com/vi/803Ukvp-5NY/2.jpg
        )
		 * 
		 */
		
		addJsFunc('
			function g_'.$this->id.'_deleteVideo(code)
			{
				$(".d-"+code).hide();
				$("#'.$this->id.'-videos").append(\'<input type="hidden" name="'.$this->id.'-delete[]" value="\'+code+\'">\');
				
			}
		');
		
		$thumbs = '';
		if(!empty($this->value))
		{
			foreach ($this->value as $v)
			{
				$thumbs .= '
					<div class="jvideo-thumb d-'.$v['code'].' col-xs-6 col-md-3"><a onclick="return false;" href="#" class="thumbnail"><span style="display:block;height:140px;background-image:url(\''.$v['thumb'].'\');background-size:cover;background-position:center;text-align:right;"><button onclick="g_'.$this->id.'_deleteVideo(\''.$v['code'].'\');" class="vid-remove btn glyphicon glyphicon-remove" type="button"></button></span></a></div>
				';
			}
		}
		
		
		return $this->wrapper('
			<div class="input-group">
				<input id="'.$this->id.'-input" placeholder="'.s('paste_youtube_url').'" type="text" class="form-control">
				<span class="input-group-btn">
					<button id="'.$this->id.'-button" class="btn btn-default" type="button"><span class="glyphicon glyphicon-facetime-video"></span> '.s('add_video').'</button>
				</span>
			</div>
			<div id="'.$this->id.'-videos" style="display:none;">
				
			</div>
			<div class="row" id="'.$this->id.'-thumbs">
				'.$thumbs.'
    		</div>
		');
	}
}