@extends('page')

@section('content')

	<h1>{{ $title }}</h1>

	@include('notifications')
	
	{{ Form::open(['id'=>'support']) }}
	
		<div class="row">
			<div class="col-md-10">
				{{ Form::text(null, null, ['class'=>'form-control', 'data-stripe'=>'number', 'placeholder'=>'Card #']) }}
			</div>
			<div class="col-md-2">
				{{ Form::text(null, null, ['class'=>'form-control', 'data-stripe'=>'cvc', 'placeholder'=>'CVC']) }}
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				{{ Form::selectMonth(null, date('m'), ['class'=>'form-control', 'data-stripe'=>'exp-month']) }}
			</div>
			<div class="col-md-6">
				{{ Form::selectYear(null, date('Y'), date('Y') + 10, null, ['class'=>'form-control', 'data-stripe'=>'exp-year']) }}
			</div>
		</div>

		{{ Form::submit('Register', ['class'=>'btn btn-primary']) }}

	{{ Form::close() }}

@endsection

@section('side')
	<div class="wallpaper">
		<p>Perhaps information goes here about the donation, such as the Center's 501(c)(3) status or what the donation supports.</p>
	</div>
@endsection

@section('script')
	<script src="https://js.stripe.com/v2/"></script>
	<script src="/assets/js/support.js"></script>
@endsection