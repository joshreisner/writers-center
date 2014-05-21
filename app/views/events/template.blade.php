@extends('template')

@section('body_class') events @endsection

@section('content')

<div class="container">
	<div class="row content">
		<div class="col-md-8 page">
			<div class="inner">
				<div class="col-md-offset-1">
					@yield('page')
				</div>
			</div>
		</div>
		<div class="col-md-4 side">
			<div class="inner">
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
	</div>
</div>

@endsection