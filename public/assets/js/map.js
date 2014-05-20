var map;

google.maps.event.addDomListener(window, 'load', function() {

	map = new google.maps.Map(document.getElementById('map-canvas'), {
		zoom: 15,
		panControl: false,
		mapTypeControl: false,
		streetViewControl: false,
		zoomControlOptions: { style: google.maps.ZoomControlStyle.SMALL },
		center: new google.maps.LatLng(41.096795,-73.8695105),
	    mapTypeControlOptions: {
	    	mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
    	}
	});

	map.mapTypes.set('map_style', new google.maps.StyledMapType([
		{
			stylers: [
				{ hue: "#4B5245" },
				{ saturation: -20 }
			]
		},{
			featureType: "road",
			elementType: "geometry",
			stylers: [
				{ lightness: 100 },
				{ visibility: "simplified" }
			]
		},{
			featureType: "road",
			elementType: "labels",
			stylers: [
				{ visibility: "off" }
			]
		}
	], {name: "Styled Map"}));
	map.setMapTypeId('map_style');

	var infowindow = new google.maps.InfoWindow({
		content: '<div style="height:160px">'+
		'<h3 style="margin-top:5px;margin-right:5px;">Hudson Valley Writers Center</h3>'+
		'<p style="font-size:15px;">300 Riverside Drive<br>Sleepy Hollow, New York 10591</p>'+
		'<p><a class="btn btn-primary btn-xs" href="http://maps.apple.com/maps?daddr=300+Riverside+Drive+Sleepy+Hollow,+New+York+10591" target="_blank">Directions</a></p>'
	});

	var marker = new google.maps.Marker({
	  position: new google.maps.LatLng(41.094595,-73.8695105),
	  map: map,
	  title: 'Hudson Valley Writers Center'
	});

	infowindow.open(map,marker);

	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
	});

});
