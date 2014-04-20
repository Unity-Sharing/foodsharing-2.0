<?php
class vFormTinymce extends vFormElement
{
	public function __construct($id,$value='',$option = array())
	{
		parent::__construct($id,$value,$option);
		
		addScript('/js/tinymce/jquery.tinymce.min.js');
		
		$plugins = array('autoresize', 'link', 'image', 'media', 'table', 'contextmenu', 'paste', 'code', 'advlist', 'autolink', 'lists', 'charmap', 'print', 'preview', 'hr', 'anchor', 'pagebreak', 'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'insertdatetime', 'nonbreaking', 'directionality', 'emoticons', 'textcolor');
		$toolbar = array('styleselect', 'bold italic', 'alignleft aligncenter alignright', 'bullist outdent indent', 'media image link', 'paste', 'code');
	
		addJs('
		$("#'.$this->id.'").tinymce({
			script_url : "/js/tinymce/tinymce.min.js",
			theme : "modern",
			language : "de",
			menubar: false,
	    	statusbar: true,
			paste_as_text: true,
			plugins: "'.implode(' ', $plugins).'",
			toolbar: "'.implode(' | ', $toolbar).'",
			relative_urls: false,
			valid_elements : "a[href|name|target=_blank|class|style],span,strong,b,div[align|class],br,p[class],ul[class],li[class],ol,h1,h2,h3,h4,h5,h6,table,tr,td[valign=top|align|style],th,tbody,thead,tfoot,img[src|width|name|class]",
			convert_urls: false
		});');
	}
	
	public function render()
	{
		return $this->wrapper('
			<textarea id="'.$this->id.'" name="'.$this->id.'">'.$this->value.'</textarea>		
		');
	}
}