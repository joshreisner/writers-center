@extends('page')

@section('content')

	<div class="indent">

		<h1>Support the Center</h1>

		{!! Form::open(['id'=>'support', 'novalidate'=>'']) !!}

			<div class="row form-group">
				<div class="col-sm-12"><h3>I Wish to Donate:</h3></div>
			</div>
		
			<div class="row form-group">
				<div class="col-sm-12 @if ($errors->has('amount')) error @endif ">
					@foreach ($preset_amounts as $amount)
						<label class="choice form-control @if (Input::old('amount') == $amount) active @endif ">
							{!! Form::radio('amount-preset', $amount) !!}
							${{ number_format($amount) }}
						</label>
					@endforeach

					{!! Form::text('amount-manual', null, ['class'=>'form-control', 'placeholder'=>'Other $']) !!}

					{!! Form::hidden('amount', null, ['class'=>'required']) !!}
				</div>
			</div>

			@include('partials.payment')

			<div class="row form-group">
				<div class="col-sm-12">
					{!! Form::submit('Submit Payment', ['class'=>'btn btn-primary']) !!}
				</div>
			</div>

		{!! Form::close() !!}
	</div>
@endsection

@section('side')
	<div class="wallpaper">
		<h3>Donate today!</h3>
		<p>Your gift to the Writers Center supports literary outreach programs to underserved young people, strengthens our offerings to adult authors at every stage of artistic development and professional growth, builds audiences for the publications and events of Slapering Hol Press, and keeps vibrant our community of playwrights, poets and writers.</p>
	</div>
@endsection

@section('script')
	<script src="https://js.stripe.com/v2/"></script>
	<script>
		Stripe.setPublishableKey('{{ env('STRIPE_API_PUBLISHABLE') }}');
	</script>
@endsection