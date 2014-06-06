@extends('page')

@section('content')

	@foreach ($months as $month=>$events)
		
		<h1 class="group">{{ $month }}</h1>
		
		@foreach ($events as $event)
		<div class="event row">
			<div class="col-md-1 date">
				{{ $event->start->format('m/y') }}<br>
				{{ $event->start->format('D') }}
			</div>
			<div class="col-md-11 description">
				<a class="title" href="/events/{{ $event->start->format('Y/m') }}/{{ $event->slug }}">{{ $event->title }}, {{ $event->start->format('g:i a') }}</a>
				{{ $event->description }}
			</div>
		</div>
		@endforeach

	@endforeach
	
@endsection

@section('side')

	<form class="switchboard form-horizontal" data-model="events">
		<div class="form-group">
			<label for="genre" class="col-md-3">Search</label>
			<div class="col-md-9">{{ Form::text('search', false, array('class'=>'form-control')) }}</div>
		</div>
		<div class="form-group">
			<label for="timeframe" class="col-md-3">Timeframe</label>
			<div class="col-md-9">
				{{ Form::dropdown('year', $years) }}
			</div>
		</div>
	</form>

@endsection