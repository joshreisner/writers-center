@extends('template')

@section('page')

	<div class="container">
		<div class="row page">
			<div class="col-md-4 col-md-push-8">
				@yield('switchboard')
			</div>
			<div class="col-md-8 col-md-pull-4 content">
				<div class="inner">
					@include('partials.notifications')
					@yield('content')
				</div>
			</div>
			<div class="col-md-4 col-md-push-8 side">
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