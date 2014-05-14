@extends('template')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div id="map-canvas" style="height: 400px;"></div>
		</div>
	</div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>
var map;

google.maps.event.addDomListener(window, 'load', function() {
	map = new google.maps.Map(document.getElementById('map-canvas'), {
		zoom: 15,
		panControl: false,
		mapTypeControl: false,
		zoomControlOptions: { style: google.maps.ZoomControlStyle.SMALL },
		center: new google.maps.LatLng(41.096795,-73.8695105),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	var contentString = '<div id="content">'+
	  '<h3 style="margin-top:5px;margin-right:5px;">Hudson Valley Writers Center</h3>'+
	  '<p style="font-size:15px;">300 Riverside Drive<br>Sleepy Hollow, New York 10591</p>'+
	  '<p><a class="btn btn-primary btn-xs" href="http://maps.apple.com/maps?daddr=300+Riverside+Drive+Sleepy+Hollow,+New+York+10591" target="_blank">Directions</a></p>';

	var infowindow = new google.maps.InfoWindow({
	  content: contentString,
	  width: 600
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
</script>	


@endsection