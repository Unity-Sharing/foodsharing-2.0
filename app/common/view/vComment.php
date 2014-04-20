<?php
class vComment extends vCore
{
	private $id;
	private $rating;
	private $colletion;
	private $mongo_id;
	
	public function __construct($collection,$mongo_id)
	{
		$this->id = $this->id('comments');
		$this->rating = false;
		
		$this->colletion = $collection;
		$this->mongo_id = $mongo_id;
	}
	
	public function setRating($from,$to)
	{
		$this->rating = array($from,$to);
	}
	
	public function render()
	{
		
		addJsFunc('
				
		function loadComment_'.$this->id.'()
		{
			ajreq({
				app: "comment",
				action: "load",
				data: {
					c: "'.$this->colletion.'",
					id: "'.$this->mongo_id.'"
				},
				success: function(ret)
				{
					if(ret.status == 1)
					{
						$("#'.$this->id.'-comments").html(ret.data);
					}
				}
			});	
		}	
		');
		addJs('loadComment_'.$this->id.'();$("#'.$this->id.'").autosize();');
		$out = '
			<div id="'.$this->id.'-comments">
				
			</div>';
		
		
		
		if(S::may())
		{
			addCss('/css/jquery.rating.css');
			addScript('/js/jquery.MetaData.js');
			addScript('/js/jquery.rating.js');
			
			$out .= '
			<div class="comment-post-wrapper" id="'.$this->id.'-wrapper">	
				<input id="'.$this->id.'-rating" type="hidden" name="'.$this->id.'-rating" value="-1">';
			
			addJsFunc('
				function commentAdd_'.$this->id.'()
				{
					var data = {
						c: "'.$this->colletion.'",
						id: "'.$this->mongo_id.'",
						t: $("#'.$this->id.'").val()
					};
								
					if(parseInt($("#'.$this->id.'-rating").val()) > -1)
					{
						data.r = parseInt($("#'.$this->id.'-rating").val());
					}
								
					ajreq({
						app: "comment",
						action: "add",
						data: data,
						success: function(){
							$("#'.$this->id.'-wrapper").animate({
								height: "1px",
								opacity: 0
							},700,function(){
								$("#'.$this->id.'-wrapper").remove();
								loadComment_'.$this->id.'();
								success("'.T::jsSafe(s('comment_add_success')).'");
							});
						}
					});
				}
			');
			
			addJs('
	
				$("#'.$this->id.'-submit").hide();
				$("#'.$this->id.'").focus(function(){
					$("#'.$this->id.'-submit").show();
				});
			');
			
			if($this->rating)
			{
				addJs('
					$("#'.$this->id.'-submit").click(function(){
						if(parseInt($("#'.$this->id.'-rating").val()) > 0)
						{
							commentAdd_'.$this->id.'();
						}
						else
						{
							alert("Bitte noch eine Bewertung angeben!");
						}
					});
					$(".'.$this->id.'-star").rating({ 
						callback: function(value, link)
						{ 
							$("#'.$this->id.'-rating").val(value);
							$("#'.$this->id.'-submit").show();
						} 
					}); 	
				');
				$out .= '
					<div class="form-group" id="'.$this->id.'-rating-wrapper">
						<div class="clearfix"></div>';
				for($i=$this->rating[0];$i<=$this->rating[1];$i++)
				{
					$out .= '<input name="'.$this->id.'-star" value="'.$i.'" type="radio" class="'.$this->id.'-star">';
				}
				
				$out .= '
						<div class="clearfix"></div>
					</div>';
			}
			else
			{
				addJs('
					$("#'.$this->id.'-submit").click(function(){
						commentAdd_'.$this->id.'();
					});	
				');
			}
			
			$out .= '
					<div class="form-group">
						<textarea maxlength="5000" id="'.$this->id.'" name="'.$this->id.'" class="form-control" rows="3" placeholder="'.s('add_comment').'"></textarea>
					</div>
					<div id="'.$this->id.'-submit" class="form-group">
						<button type="button" class="btn btn-primary">'.s('send_comment').'</button>
					</div>
				</div>';
		}
		return $out;
	}
}