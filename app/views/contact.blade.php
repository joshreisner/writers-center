@extends('page')

@section('content')
	<div id="map-canvas"></div>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<script src="/assets/js/map.js"></script>	
@endsection

@section('side')
	<div class="wallpaper">
		<ul>
			<li><a href="tel:9143325953"><i class="glyphicon glyphicon-earphone"></i> (914) 332-5953</a></li>
			<li><a href="tel:9143324825"><i class="glyphicon glyphicon-print"></i> (914) 332-4825</a></li>
			<li><a href="mailto:info@writerscenter.org"><i class="glyphicon glyphicon-envelope"></i> info@writerscenter.org</a></li>
		</ul>
	</div>
@endsection