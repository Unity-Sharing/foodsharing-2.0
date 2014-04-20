<?php
class vFormLocation extends vFormElement
{
	private $elements = array();
	private $show_address;
	
	public function __construct($id = 'location',$values = array(),$options = array())
	{
		addScriptTop('http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places');
		//addScript('/js/jquery.geocomplete.js');
		
		parent::__construct($id,$values,$options);
		
		$this->elements = array();
		$this->show_address = true;
		
		
		
		
	}
	
	public function setAddressField($val = true)
	{
		$this->show_address = $val;
	}
	
	public function render()
	{
		$search = new vFormText($this->id.'_search_address');
		
		
		$this->value = array_merge(array(
				$this->id.'_city' => '',
				$this->id.'_coords' => getLocation(),
				$this->id.'_street' => '',
				$this->id.'_street_number' => '',
				$this->id.'_zip' => ''
		),$this->value);
		
		if(!empty($this->value[$this->id.'_street']))
		{
			$search->setValue($this->value[$this->id.'_street'].' '.$this->value[$this->id.'_street_number'].', '.$this->value[$this->id.'_city']);
		}
		
		if(!is_array($this->value[$this->id.'_coords']))
		{
			$this->value[$this->id.'_coords'] = getLocation();
		}
		
		if($this->show_address)
		{
			$zip = new vFormText($this->id.'_zip');
			$city = new vFormText($this->id.'_city');
			$street = new vFormText($this->id.'_street');
			
			addJs('
				// location-map-wrapper
				$("#'.$this->id.'-map").css({
					"width": ($("#location-map-wrapper").width()-353)+"px"
				});
				$("#'.$this->id.'-map-wrapper").css({
					"display":"none",
					"opacity":0,
					"height":"0px"
				});
				$("#'.$search->getId().'").focus(function(){
					$("#'.$this->id.'-map-wrapper").css({
							"display":"block"
					}).animate({
						"opacity":1,
						"height":"155px"
					},200,function(){
						$("#'.$search->getId().'").geocomplete({
							map: "#'.$this->id.'-map",
							markerOptions: {
							    draggable: true
							  },
							details: "#'.$this->id.'-details",
							detailsAttribute: "data-geo",
							location: ['.implode(',', $this->value[$this->id.'_coords']).']
						}).bind("geocode:dragged", function(event, latLng){
				          $("#'.$this->id.'_lat").val(latLng.lat());
				          $("#'.$this->id.'_lng").val(latLng.lng());
				          $("#reset").show();
				        });
					});
				});
			');
		}
		else
		{
			addJs('
				$("#'.$search->getId().'").geocomplete({
					details: "#'.$this->id.'-details",
					detailsAttribute: "data-geo",
					location: ['.implode(',', $this->value[$this->id.'_coords']).']
				});
			');
		}
		$street = new vFormText($this->id.'_address');
		$street->addAttribute('data-geo', 'route');
		
		$street = new vFormText($this->id.'_address');
		$street->addAttribute('data-geo', 'route');
		
		$this->elements[] = $search->render();
		
		if($this->show_address)
		{
		
			$this->elements[] = '
			<div id="'.$this->id.'-map-wrapper">
				<div id="'.$this->id.'-map" class="picker-map pull-left hidden-xs hidden-sm"></div>
				<div id="'.$this->id.'-details">
					<input type="hidden" name="'.$this->id.'_lat" id="'.$this->id.'_lat" data-geo="lat" value="'.$this->value[$this->id.'_coords'][0].'">
					<input type="hidden" name="'.$this->id.'_lng" id="'.$this->id.'_lng" data-geo="lng" value="'.$this->value[$this->id.'_coords'][1].'">
					<label>'.s('street_number').'</label>
					<div class="form-group">
						<input type="text" value="'.$this->value[$this->id.'_street'].'" class="form-control form-street" id="'.$this->id.'_street" name="'.$this->id.'_street" placeholder="'.s('street').'" data-geo="route">
						<input type="text" value="'.$this->value[$this->id.'_street_number'].'" class="form-control form-number" id="'.$this->id.'_street_number" name="'.$this->id.'_street_number" placeholder="'.s('street_number').'" data-geo="street_number">
		
					</div>
					<label>'.s('zip_city').'</label>
					<div class="form-group">
						<input type="text" value="'.$this->value[$this->id.'_zip'].'" class="form-control form-zip" id="'.$this->id.'_zip" name="'.$this->id.'_zip" placeholder="'.s('zip').'" data-geo="postal_code">
						<input type="text" value="'.$this->value[$this->id.'_city'].'" class="form-control form-city" id="'.$this->id.'_city" name="'.$this->id.'_city" placeholder="'.s('city').'" data-geo="locality">
					</div>
				</div>
				<div style="clear:both;"></div>
			</div>
			';
		}
		else
		{
			$this->elements[] = '
			<div id="'.$this->id.'-details" style="display:none;">
				<input type="hidden" name="'.$this->id.'_lat" id="'.$this->id.'_lat" data-geo="lat" value="'.$this->value[$this->id.'_coords'][0].'">
				<input type="hidden" name="'.$this->id.'_lng" id="'.$this->id.'_lng" data-geo="lng" value="'.$this->value[$this->id.'_coords'][1].'">
			</div>';
		}
		
		
		$out = '';
		
		foreach ($this->elements as $el)
		{
			$out .= $el;
		}
		
		return $out;
	}
}