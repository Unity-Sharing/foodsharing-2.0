<?php
class vFormWysiwyg extends vFormElement
{
	public function __construct($id,$value='',$option = array())
	{
		parent::__construct($id,$value,$option);
		
		addCss('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css');
		addScript('/js/summernote.js');
		addCss('/css/summernote.css');
		
		addJs('
			$("#'.$this->id.'").summernote({
			  toolbar: [
			    ["style", ["bold", "italic", "underline", "clear"]],
			    ["para", ["ul", "ol", "paragraph"]]
			  ]
			});
		');
		
	}
	
	public function render()
	{
		return $this->wrapper('
			<textarea id="'.$this->id.'" name="'.$this->id.'">'.$this->value.'</textarea>		
		');
	}
}