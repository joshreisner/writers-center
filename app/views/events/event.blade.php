@extends('template')

@section('content')

<div class="container">
	<div class="row content">
		<div class="col-md-3">
			<div class="well">
				<form role="form">
					<div class="form-group">
						<label for="timeframe">Timeframe</label>
						<select name="timeframe" id="timeframe" class="form-control">
							<option selected="selected">Upcoming Events</option>
							@foreach ($years as $year)
							<option value="{{ $year }}">{{ $year }}</option>
							@endforeach
						</select>
					</div>
				</form>

			</div>
		</div>

		<div class="col-md-9">
			<div class="page-header">
				<h1>{{ $event->title }}</h1>
			</div>
			{{ $event->description }}
		</div>

	</div>
</div>

@endsection