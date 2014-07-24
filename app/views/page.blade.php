@extends('template')

@section('page')

<div class="container">
	<div class="row page">
		<div class="col-md-8 content">
			<div class="inner">
				@yield('content')
			</div>
		</div>
		<div class="col-md-4 side">
			<div class="inner">
				@include('partials.cart')
				@yield('side')
			</div>
		</div>
	</div>
</div>

@endsection