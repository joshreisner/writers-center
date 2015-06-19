@extends('page')

@section('content')
	<div class="indent">
		<h1>Contact</h1>
	</div>

	<div id="map-canvas"></div>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<script>
		var map;

		google.maps.event.addDomListener(window, 'load', function() {

			map = new google.maps.Map(document.getElementById('map-canvas'), {
				zoom: 15,
				panControl: false,
				mapTypeControl: false,
				streetViewControl: false,
				zoomControlOptions: { style: google.maps.ZoomControlStyle.SMALL },
				center: new google.maps.LatLng(41.097795,-73.8695105),
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
				content: '<div class="infowindow">'+
				'<h3>Hudson Valley Writers Center</h3>'+
				'<p>300 Riverside Drive<br>Sleepy Hollow, New York<br>10591</p>'+
				'<p><a class="btn btn-primary" href="http://maps.apple.com/maps?daddr=300+Riverside+Drive+Sleepy+Hollow,+New+York+10591" target="_blank">Directions</a></p>'
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

@section('side')
	<div class="wallpaper" style="background-image:url('{{ App\Http\Controllers\ImageController::wallpaper('contact') }}');">
		<h4>Contact Information</h4>
		<ul class="navigation">
			<li><a href="tel:9143325953"><i class="fa fa-phone"></i> (914) 332-5953</a></li>
			<li><a href="tel:9143324825"><i class="fa fa-fax"></i> (914) 332-4825</a></li>
			<li><a href="mailto:info@writerscenter.org"><i class="fa fa-envelope"></i> info@writerscenter.org</a></li>
		</ul>
		<h4>Social Media</h4>
		<ul class="navigation">
			<li><a href="https://www.facebook.com/hvwriterscenter"><i class="fa fa-facebook"></i> Facebook</a></li>
			<li><a href="https://twitter.com/HVWritersCenter"><i class="fa fa-twitter"></i> Twitter</a></li>
			<li><a href="http://instagram.com/hudson_valley_writers_center"><i class="fa fa-instagram"></i> Instagram</a></li>
			<li><a href="https://www.youtube.com/channel/UCMyCsXkxuNPK-A0mT8MA8LQ"><i class="fa fa-youtube"></i> YouTube</a></li>
		</ul>
	</div>
@endsection