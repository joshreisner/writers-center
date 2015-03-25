@extends('template')

@section('page')

	<div class="container">
		<div class="row page">
			<div class="col-md-8 content">
				<div class="inner">
					@include('partials.notifications')
					@yield('content')
				</div>
			</div>
			<div class="col-md-4 side">
				<div class="inner">
					@if (!App::environment('production'))
						@include('partials.cart')
					@endif
					@yield('side')
				</div>
			</div>
		</div>
	</div>

@endsection