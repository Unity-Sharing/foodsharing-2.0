<?php
class vMap extends vCore
{
	private $id;
	private $location;
	private $zoom;
	private $markercluster;
	private $searchpanel;
	private $default_marker;
	private $provider;
	private $provider_options;
	private $marker;
	private $home_marker;
	
	public function __construct($id = 'map')
	{
		$this->id = $this->id($id);
		$this->location = getLocation();
		$this->zoom = 13;
		$this->markercluster = false;
		$this->searchpanel = false;
		$this->default_marker = '/css/img/marker-icon.png';
		$this->provider_options = array();
		$this->marker = array();
		$this->setProviderCloudMade();
		$this->home_marker = false;
	}
	
	public function setSearchPanel($val = true)
	{
		$this->searchpanel = $val;
	}
	
	public function setProvider($provider,$options = array())
	{
		$this->provider = $provider;
		$this->provider_options = $options;
	}
	
	public function setProviderCloudMade($style_id = '113144',$api_key = '182f97c8608145c09f1fce4a266ed61f')
	{
		$this->setProvider('cloudmade',array(
			'key' => $api_key,
			'styleId' => $style_id
		));
	}
	
	public function setHomeMarker()
	{
		$this->home_marker = true;
	}
	
	public function setProviderMapbox($map = 'hlekmb0m',$user = 'raffelrocker')
	{
		$this->setProvider('mapbox',array(
			'user' => $user,
			'map' => $map
		));
	}
	
	public function setZoom($zoom)
	{
		$this->zoom = (int)$zoom;
	}
	
	public function setLocation($lat,$lng)
	{
		$this->location = array($lat,$lng);
	}
	
	public function setMarkerCluster($val = true)
	{
		$this->markercluster = $val;
	}
	
	public function addMarker($lat,$lng, $marker = 'default')
	{
		$this->marker[] = array(
			'lat' => $lat,
			'lng' => $lng
		);
	}
	
	public function render()
	{
		
		addJsFunc('
			var '.$this->id.'_latLng = ['.$this->location[0].','.$this->location[1].'];
			var '.$this->id.'_defaultIcon = L.icon({   iconUrl: "'.$this->default_marker.'",shadowUrl: \'/css/img/default-shadow.png\',iconSize: [25, 41],	iconAnchor: [12, 41],popupAnchor: [1, -34],shadowSize: [46, 41],shadowAnchor: [12, 41]});
		');
		if($this->home_marker)
		{
			addJsFunc('
			var '.$this->id.'_home_marker = null;		
			var '.$this->id.'_homeIcon = L.icon({   iconUrl: "/css/img/marker-home.png",shadowUrl: \'/css/img/default-shadow.png\',iconSize: [25, 41],	iconAnchor: [12, 41],popupAnchor: [1, -34],shadowSize: [46, 41],shadowAnchor: [12, 41]});
			');	
		}
		if($this->searchpanel === true)
		{
			addScriptTop('/js/leaflet.search.min.js');
			addScriptTop('https://maps.googleapis.com/maps/api/js?v=3&sensor=false');
			addCss('/css/leaflet.search.css');
		}
		elseif ($this->searchpanel !== false)
		{
			addScriptTop('http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places');
			//addScript('/js/jquery.geocomplete.js');
			
			$hm = '';
			if($this->home_marker)
			{
				$hm = $this->id.'_home_marker.setLatLng(new L.LatLng(latLng[0], latLng[1])).update();';
			}
			
			addJs('
			$("#'.$this->searchpanel.'").geocomplete().bind("geocode:result", function(event, result){
				latLng = [result.geometry.location.lat(),result.geometry.location.lng()];
				'.$this->id.'_latLng = latLng;
				$("#'.$this->id.'-latLng").val(JSON.stringify(latLng));
			    '.$this->id.'.setView(latLng,'.(int)$this->zoom.');
			    '.$hm.'
			 });
			');
		}
		
		if($this->markercluster)
		{
			addScriptTop('/js/leaflet.markercluster.js');
			addCss('/css/marker-cluster.css');
		}
		
		addScriptTop('http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.js');
		addCssTop('http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.css');
		
		addJsFunc('
			var '.$this->id.' = null;
			var '.$this->id.'_markers = null;	
			var '.$this->id.'_geocoder = null;	
		');		
		
		addJs(''.$this->id.' = L.map("'.$this->id.'").setView(['.$this->location[0].', '.$this->location[1].'], '.$this->zoom.');');
	
		switch ($this->provider)
		{
			case 'mapquest':
				addJs('
					L.tileLayer(\'http://{s}.mqcdn.com/tiles/1.0.0/vy/map/{z}/{x}/{y}.png\', {
						subdomains:["mtile01","mtile02","mtile03","mtile04"],
						attributionControl: false
					}).addTo('.$this->id.');
				');
				break;
			
			case 'mapbox':
					addJs('
					L.tileLayer(\'http://{s}.tiles.mapbox.com/v3/'.$this->provider_options['user'].'.'.$this->provider_options['map'].'/{z}/{x}/{y}.png\', {
					    attributionControl: false
					}).addTo('.$this->id.');
				');
				break;
				
			case 'cloudmade':
					addJs('
					L.tileLayer(\'http://{s}.tile.cloudmade.com/'.$this->provider_options['key'].'/'.$this->provider_options['styleId'].'/256/{z}/{x}/{y}.png\', {
					    attributionControl: false
					}).addTo('.$this->id.');
				');
				break;
		}
		if(!empty($this->marker))
		{
			foreach ($this->marker as $m)
			{
				addJs('L.marker(['.$m['lat'].', '.$m['lng'].'],{icon:'.$this->id.'_defaultIcon}).addTo('.$this->id.');');
			}
		}	
		
		if($this->home_marker)
		{
			addJs($this->id.'_home_marker = L.marker(['.$this->location[0].', '.$this->location[1].'],{icon:'.$this->id.'_homeIcon}).addTo('.$this->id.');');
		}
		
		if($this->markercluster)
		{
			addJsFunc('
			function '.$this->id.'_clearCluster()
			{
				if('.$this->id.'_markers != null && '.$this->id.'_markers != undefined)
				{
					'.$this->id.'.removeLayer('.$this->id.'_markers);
				}
				'.$this->id.'_markers = L.markerClusterGroup();
			}
				
			function '.$this->id.'_addMarker(options)
			{
				if(options.icon == undefined)
				{
					options.icon = '.$this->id.'_defaultIcon;
				}
				
				var marker = L.marker(new L.LatLng(options.lat, options.lng), { id: options.id, click: options.click, icon: options.icon });
				//marker.bindPopup(id);
				'.$this->id.'_markers.addLayer(marker);
			}
				
			function '.$this->id.'_commitCluster()
			{
				'.$this->id.'_markers.on("click", function(el){	
					if(el.layer.options.click != undefined)
					{
						el.layer.options.click();
					}
				});
				'.$this->id.'.addLayer('.$this->id.'_markers);
			}
			');
		}
		else
		{
			addJsFunc('
			function '.$this->id.'_addMarker(lat,lng,id)
			{
				L.marker([lat, lng]).addTo('.$this->id.');	
			}	
			');
		}
		
		if($this->searchpanel === true)
		{
			addJs('
				'.$this->id.'_geocoder = new google.maps.Geocoder();
				'.$this->id.'.addControl( new L.Control.Search({
					callData: '.$this->id.'_googleGeocoding,
					filterJSON: '.$this->id.'_filterJSONCall,
					markerLocation: true,
					autoType: false,
					autoCollapse: false,
					zoom: '.$this->zoom.',
					text: "'.T::jsSafe(s('search')).'"
				}) );
			');
			addJsFunc('
				function '.$this->id.'_googleGeocoding(text, callResponse)
				{
					'.$this->id.'_geocoder.geocode({address: text}, callResponse);
				}
			
				function '.$this->id.'_filterJSONCall(rawjson)
				{
					var json = {},
						key, loc, disp = [];
			
					for(var i in rawjson)
					{
						key = rawjson[i].formatted_address;
						
						loc = L.latLng( rawjson[i].geometry.location.lat(), rawjson[i].geometry.location.lng() );
						
						json[ key ]= loc;	//key,value format
					}
			
					return json;
				}		
			');
		}
		
		$this->initLocation();
		
		return '
		<div class="vmap" id="'.$this->id.'"></div><input type="hidden" name="latlng" id="'.$this->id.'-latLng" value="'.json_encode($this->location).'">';
	}
	
	private function initLocation()
	{
		if(!S::getLocation())
		{
			addJs('
			$.getJSON("http://www.geoplugin.net/json.gp?ip='.$_SERVER['REMOTE_ADDR'].'&jsoncallback=?", function(data) {
			    if(data.geoplugin_status != undefined && data.geoplugin_status >= 200 && data.geoplugin_status < 300)
				{
					$.getJSON("http://www.geoplugin.net/extras/postalcode.gp?lat="+data.geoplugin_latitude+"&long="+data.geoplugin_longitude+"&format=json&jsoncallback=?", function(plz){
						if(plz.geoplugin_place != undefined)
						{
							'.$this->id.'_latLng = [data.geoplugin_latitude, data.geoplugin_longitude];
							'.$this->id.'.setView([data.geoplugin_latitude, data.geoplugin_longitude],'.(int)$this->zoom.');
							ajreq({
								app:"karte",
								action:"setlocation",
								data: {
									lat: data.geoplugin_latitude,
									lng: data.geoplugin_longitude,
									city: plz.geoplugin_place,
									zip: plz.geoplugin_postCode
								}
							});
						}
					});
				}
			});
		');
				
		}
	}
}