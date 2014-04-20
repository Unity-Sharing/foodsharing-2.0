<?php
class vFormTags extends vFormElement
{
	private $json;
	
	public function __construct($id,$value = '', $option = array())
	{
		parent::__construct($id,$value,$option);
		
		$this->json = '/xhr.php?a=main&m=tags';
		
			//addCss('/css/bootstrap-tagsinput.css');
			//addScript('/js/bootstrap-tagsinput.js');
			
			//addCss('/css/textext/textext.core.css');
			//addCss('/css/textext/textext.plugin.tags.css');
			//addCss('/css/textext/textext.plugin.autocomplete.css');
		/*
		addCss('/css/textext/textext.plugin.focus.css');
		addCss('/css/textext/textext.plugin.prompt.css');
		addCss('/css/textext/textext.plugin.arrow.css');
		*/
		
			//addScript('/js/textext/textext.core.js');
			//addScript('/js/textext/textext.plugin.tags.js');
			//addScript('/js/textext/textext.plugin.autocomplete.js');
		
		//addScript('/js/textext/textext.plugin.suggestions.js');
		//addScript('/js/textext/textext.plugin.filter.js');
		//addScript('/js/textext/textext.plugin.focus.js');
		//addScript('/js/textext/textext.plugin.prompt.js');
			//addScript('/js/textext/textext.plugin.ajax.js');
		//addScript('/js/textext/textext.plugin.arrow.js');
		
		$items = '';
		//addScript('/js/typeahead.js');
		
		if(!empty($this->value))
		{
			$items = ',tags: { items: '.json_encode($this->value).' }';
		}
		
		addJs('
		$("#'.$this->id.'").css("width",($("#'.$this->id.'").closest(".form-body").width())+"px");
		$("#'.$this->id.'")
        .textext({
            plugins : "tags autocomplete ajax",
			ajax : {
                url : "'.$this->json.'",
                dataType : "json",
                cacheResults : true
            }'.$items.'
        });
        ;
		');
		
	}
	
	public function setJson($src)
	{
		$this->json = $src;
	}
	
	public function render()
	{
		return $this->wrapper('<textarea value="sdf,df,vfdjn" name="'.$this->id.'" id="'.$this->id.'" class="form-tags" rows="1"></textarea>');
	}
}