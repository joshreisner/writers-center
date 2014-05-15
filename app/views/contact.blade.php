@extends('template')

@section('body_class') contact @endsection
@section('content')

<div class="container">
	<div class="row content">
		<div class="col-md-8 page">
			<div class="inner">
				<div id="map-canvas"></div>
			</div>
		</div>
		<div class="col-md-4 side">
			<div class="inner">
				<ul>
					<li><a href="tel:9143325953"><i class="glyphicon glyphicon-earphone"></i> (914) 332-5953</a></li>
					<li><a href="tel:9143324825"><i class="glyphicon glyphicon-print"></i> (914) 332-4825</a></li>
					<li><a href="mailto:info@writerscenter.org"><i class="glyphicon glyphicon-envelope"></i> info@writerscenter.org</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script src="/assets/js/map.js"></script>	


@endsection