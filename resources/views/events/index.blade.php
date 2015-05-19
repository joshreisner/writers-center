@extends('page')

@section('content')

	<div class="indent">
		<h1>Events</h1>
		<div class="target">
			@include('events.events')
		</div>
	</div>
	
@endsection

@section('switchboard')

	<form class="switchboard form-horizontal" data-model="events">
		<div class="form-group">
			<label for="genre" class="col-md-3">Search</label>
			<div class="col-md-9">{!! Form::text('search', false, ['class'=>'form-control']) !!}</div>
		</div>
		<div class="form-group">
			<label for="timeframe" class="col-md-3">When</label>
			<div class="col-md-9">
				{!! Form::dropdown('year', $years, null, 'Upcoming') !!}
			</div>
		</div>
	</form>

@endsection