@extends('page')

@section('content')
	<div class="indent">
		<h1>{{ $title }}</h1>
	</div>
	<div class="row target">
		@include('publications.publications')
	</div>
@endsection

@section('switchboard')
	<form class="switchboard form-horizontal" data-model="shp">
		<div class="form-group">
			<label for="genre" class="col-md-3">Search</label>
			<div class="col-md-9">{!! Form::text('search', false, ['class'=>'form-control']) !!}</div>
		</div>
		<div class="form-group">
			<label for="timeframe" class="col-md-3">Year</label>
			<div class="col-md-9">
				{!! Form::dropdown('year', $years) !!}
			</div>
		</div>
		<div class="form-group">
			<label for="timeframe" class="col-md-3">Type</label>
			<div class="col-md-9">
				{!! Form::dropdown('type_id', $types) !!}
			</div>
		</div>
	</form>
@endsection

@section('side')
	@include('publications.side') 
@endsection