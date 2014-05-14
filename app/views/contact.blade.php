@extends('template')

@section('body_class') contact @endsection
@section('content')

<div class="container">
	<div class="row content">
		<div class="col-md-4 side">
			<div class="inner">
				Maybe there's some content that should go here.
			</div>
		</div>
		<div class="col-md-8 page">
			<div class="inner">
				<div id="map-canvas"></div>
			</div>
		</div>
	</div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script src="/assets/js/map.js"></script>	


@endsection