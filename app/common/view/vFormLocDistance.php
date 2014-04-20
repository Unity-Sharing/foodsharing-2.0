<?php
class vFormLocDistance extends vFormElement
{
	private $show_address;
	private $distances;
	private $onchange;
	
	public function __construct($id = 'location', $distances, $values = array(), $options = array())
	{
		addScriptTop('http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places');
		//addScript('/js/jquery.geocomplete.js');
		
		parent::__construct($id,$values,$options);	
		$this->distances = $distances;
		$this->onchange = '';
	}
	
	/**
	 * Whant stupid js conde can use: 
	 *  - latLng array for coords
	 *  - distance for distance
	 * @param String $jscode
	 */
	public function onChange($jscode)
	{
		$this->onchange = $jscode;
	}
	
	public function render()
	{	
		
		$this->value = array_merge(array(
				$this->id.'_city' => '',
				$this->id.'_coords' => getLocation(),
				$this->id.'_street' => '',
				$this->id.'_street_number' => '',
				$this->id.'_zip' => ''
		),$this->value);
		
		if(!is_array($this->value[$this->id.'_coords']))
		{
			$this->value[$this->id.'_coords'] = getLocation();
		}
		
		addJs('
			$("#'.$this->id.'_search_address").geocomplete({
				details: "#'.$this->id.'-details",
				detailsAttribute: "data-geo",
				location: ['.implode(',', $this->value[$this->id.'_coords']).']
			}).bind("geocode:result", function(event, result){
				latLng = [result.geometry.location.lat(),result.geometry.location.lng()];
				distance = $("#'.$this->id.'_distance").val();
						
				'.$this->onchange.'

			 });
						
			$("#'.$this->id.'_distances a").click(function(ev){
				ev.preventDefault();
				distance = parseInt($(this).data("dis"));
				view = $(this).text();
				$("#'.$this->id.'_distances_view").html(view+\' <span class="caret"></span>\');
				$("#'.$this->id.'_distance").val(distance);
				latLng = [parseFloat($("#'.$this->id.'_lat").val()),parseFloat($("#'.$this->id.'_lng").val())];
				'.$this->onchange.'
			});
		');
		
		$distances = '';
		foreach ($this->distances as $value => $dis)
		{
			$distances .= '
			<li><a href="#" data-dis="'.$value.'">'.$dis.'</a></li>';
		}
		
		$out = '
		<div class="input-group">
			<span class="input-group-addon glyphicon glyphicon-home"></span>
		    <input type="text" class="form-control" id="'.$this->id.'_search_address" name="'.$this->id.'_search_address" placeholder="'.s('location_search').'">
		    		
		    <div class="input-group-btn">
		        <button id="'.$this->id.'_distances_view" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">'.reset($this->distances).' <span class="caret"></span></button>
		        <ul id="'.$this->id.'_distances" class="dropdown-menu pull-right">
		          '.$distances.'
		        </ul>
	      	</div>
		  
		</div>';
		
		
		$out .= '
		<div id="'.$this->id.'-details" style="display:none;">
			<input type="hidden" name="'.$this->id.'_distance" id="'.$this->id.'_distance" value="'.key($this->distances).'">
			<input type="hidden" name="'.$this->id.'_lat" id="'.$this->id.'_lat" data-geo="lat" value="'.$this->value[$this->id.'_coords'][0].'">
			<input type="hidden" name="'.$this->id.'_lng" id="'.$this->id.'_lng" data-geo="lng" value="'.$this->value[$this->id.'_coords'][1].'">
		</div>';
		
		return $out;
	}
}