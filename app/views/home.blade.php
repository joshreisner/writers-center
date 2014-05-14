@extends('template')

@section('body_class') home @endsection

@section('content')

	<div class="carousel">
		<div class="inner">
			@foreach ($items as $item)
			<a class="item {{ $item->type }}" href="#">
				<img src="{{ $item->backing->url }}" width="{{ $item->backing->width }}" height="{{ $item->backing->height }}">
				<h1>{{ nl2br($item->title) }}</h1>
				<div class="description">{{ nl2br($item->content) }}</div>
				<div class="type">{{ $item->type }}</div>
			</a>
			@endforeach
		</div>
	</div>

	<div class="container">
		<div class="row promos">
			<div class="col-md-4">
				<div class="promo events">
					Events go here
				</div>
			</div>
			<div class="col-md-4">
				<div class="promo courses">
					<form>
						<legend>Find a class</legend>
						@foreach (array('Genre', 'When', 'Teacher', 'Duration') as $field)
						<div>
							<label for="{{ Str::slug($field) }}">{{ $field }}</label>
							<select id="{{ Str::slug($field) }}">
							</select>
						</div>
						@endforeach
					</form>
				</div>
			</div>
			<div class="col-md-4">
				<div class="promo support">
					<a href="/support">Support the Center</a>
				</div>
			</div>
		</div>
	</div>

@endsection