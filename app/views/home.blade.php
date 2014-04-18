@extends('template')

@section('content')

	<div class="carousel">
		<div class="inner">
			@foreach ($items as $item)
			<a class="item {{ $item->type }}" href="#">
				<h1>{{ nl2br($item->title) }}</h1>
				<div class="description">{{ nl2br($item->content) }}</div>
				<div class="type">{{ $item->type }}</div>
			</a>
			@endforeach
		</div>
	</div>

	<div class="container">
		<div class="row promos">
			@foreach ($promos as $promo)
			<div class="col-md-4"><a href="#">{{ $promo->title }}</a></div>
			@endforeach
		</div>
	</div>

@endsection