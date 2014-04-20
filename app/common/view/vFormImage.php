<?php
class vFormImage extends vFormElement
{
	public function __construct($id, $value = array(), $option = array())
	{
		$option = array_merge(array(
			'max_file_count' => 5,
			'max_file_size' => 5,
			'file_types' => array(
				'gif','jpg','jpeg','png'
			)
		),$option);
		parent::__construct($id,$value, $option);
	}
	
	public function setImageCount($count)
	{
		$this->option['max_file_count'] = (int)$count;
	}
	
	public function render()
	{	
		
		$imgval = '';
		
		addJsFunc('
			function g_'.$this->id.'_deleteImage(file,id)
			{
				$("#'.$this->id.'-files").append(\'<input type="hidden" name="'.$this->id.'-delete[]" value="\'+file+\'">\');
				$("."+id).remove();
			}
		');
		
		if(!empty($this->value))
		{
			foreach ($this->value as $i => $img)
			{
				$id = 'i-inDb-'.$i;
				$imgval .= '
				<div class="'.$id.' jimage-thumb col-xs-6 col-md-3"><a class="thumbnail" href="#" onclick="return false;"><span style="display:block;text-align:right;background-image:url(/'.$img['folder'].'150x150-'.$img['file'].');background-size:cover;height:140px;background-position:center;"><button onclick="g_'.$this->id.'_deleteImage(\''.$img['file'].'\',\''.$id.'\');" style="" class="vid-remove btn glyphicon glyphicon-remove" type="button" data-code="'.$id.'"></button></span></a></div>';
			}
		}
		
		
		addJs('
			$("#'.$this->id.'-progress").hide();
			"use strict";
		    $("#'.$this->id.'").fileupload({
		        url: "/fileupload/",
		    	add: function (e, data) {
			        var goUpload = true;
			        var uploadFile = data.files[0];
			        if (!(/\.('.implode('|', $this->option['file_types']).')$/i).test(uploadFile.name)) {
			            error("'.s('error_wrong_file_type').'");
			            goUpload = false;
			        }
			        if (uploadFile.size > '.(int)$this->option['max_file_size'].'000000) { 
			            error("'.sv('error_max_filesize',(int)$this->option['max_file_size']).'");
			            goUpload = false;
			        }
			        if($("#'.$this->id.'-files .thumbnail").length >= '.(int)$this->option['max_file_count'].')
			        {
			            error("'.s('error_to_many_images').'");
			        }
			        if (goUpload == true) {
			            data.submit();
			        }
			        $("#'.$this->id.'-progress").show();
			    },
		        dataType: "json",
			    stop: function()
			    {
			       info(\''.s('upload_ready').'\');	
			       $("#'.$this->id.'-progress").fadeOut();
			    },
		        done: function (e, data) {
			       	
		            $.each(data.result.files, function (index, file) {
			            		
			            // attetion dity :o)
			           id = "i-"+file.name.replace(/[^a-z0-9A-Z]/g,"");
			            		
		                $("#'.$this->id.'-files").prepend(\'<div class="\' + id + \' jimage-thumb col-xs-6 col-md-3"><a onclick="return false;" href="#" class="thumbnail"><span style="display:block;text-align:right;background-image:url(\'+file.thumbnailUrl+\');background-size:cover;height:140px;background-position:center;"><button data-code="\' + id + \'" type="button" class="vid-remove btn glyphicon glyphicon-remove" style=""></button></span></div>\');
		                $("#'.$this->id.'-files").prepend(\'<input class="\' + id + \'" type="hidden"\ name="'.$this->id.'[]" value="\'+file.name+\'">\');
		                $(".vid-remove").click(function(ev){
		                	ev.preventDefault();
							id = $(this).attr("data-code");	
		                	$("." + id).remove();
						});
		            });
		            
		        },
		        progressall: function (e, data) {
		            var progress = parseInt(data.loaded / data.total * 100, 10);
		            $("#'.$this->id.'-progress .progress-bar").css(
		                "width",
		                progress + "%"
		            );
		           
		        }
		    }).prop("disabled", !$.support.fileInput)
		        .parent().addClass($.support.fileInput ? undefined : "disabled");		
		');
		return $this->wrapper('
			<div class="row">
			
				<div class="col-md-2">
				
					<span class="btn btn-primary fileinput-button">
					   <i class="glyphicon glyphicon-upload"></i>
					   <span>'.s('select_files').'</span>
					   <input id="'.$this->id.'" type="file" name="files[]" multiple>
					</span>
				</div>
				<div class="col-md-9 col-md-offset-1">
					<div id="'.$this->id.'-progress" class="progress progress-striped">
					  <div class="progress-bar progress-bar-success" role="progressbar" style="width: 0%">
					  </div>
					</div>
				</div>
				
			</div>

			<br>
  			<div id="'.$this->id.'-files" class="files row">
				
				'.$imgval.'
				
			</div>
			<br>
	
		');
		//return $this->wrapper('<input placeholder="'.$this->label.'" type="text" name="'.$this->name.'" id="'.$this->id.'" class="form-control" value="'.$this->value.'">');
	}
}