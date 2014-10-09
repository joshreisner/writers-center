@extends('page')

@section('content')

	<div class="indent">

		<h1>Support the Center</h1>

		{{ Form::open(['id'=>'support', 'novalidate'=>'']) }}

			<div class="row">
				<div class="col-sm-12"><h3>I Wish to Donate:</h3></div>
			</div>
		
			<div class="row">
				<div class="col-sm-12 @if ($errors->has('amount')) error @endif ">
					@foreach ($preset_amounts as $amount)
						<label class="choice form-control @if (Input::old('amount') == $amount) active @endif ">
							{{ Form::radio('amount-preset', $amount) }}
							${{ number_format($amount) }}
						</label>
					@endforeach

					{{ Form::text('amount-manual', null, ['class'=>'form-control', 'placeholder'=>'Other $']) }}

					{{ Form::hidden('amount') }}
				</div>
			</div>

			@include('partials.payment')

			{{ Form::submit('Submit Payment', ['class'=>'btn btn-primary']) }}

		{{ Form::close() }}
	</div>
@endsection

@section('side')
	<div class="wallpaper">
		<h3>Donate today!</h3>
		<p>Your gift to the Writers Center supports literary outreach programs to underserved young people, strengthens our offerings to adult authors at every stage of artistic development and professional growth, builds audiences for the publications and events of Slapering Hol Press, and keeps vibrant our community of playwrights, poets and writers.</p>
		<div class="image" style="background-image:url({{ $wallpaper}})">
	</div>
@endsection

@section('script')
	<script src="https://js.stripe.com/v2/"></script>
	<script>
		Stripe.setPublishableKey('{{ Config::get('services.stripe.publishable_key') }}');
	</script>
@endsection