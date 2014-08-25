@extends('page')

@section('content')

	<div class="indent">

		<h1>Support the Center</h1>

		{{ Form::open(['id'=>'support']) }}

			<div class="row">
				<div class="col-sm-12"><h3>I Wish to Donate:</h3></div>
			</div>
		
			<div class="row">
				<div class="col-sm-12">
					@foreach ($preset_amounts as $amount)
						<label class="choice form-control">
							<input type="radio" name="amount-preset" value="{{ $amount }}"> ${{ number_format($amount) }}
						</label>
					@endforeach

					{{ Form::text('amount', null, ['id'=>'amount', 'class'=>'form-control', 'placeholder'=>'Other $']) }}
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
		$(function(){

			var StripeBilling = {

				init: function() {
					this.form = $("form#support");
					this.submitButton = this.form.find("input[type=submit]");
					Stripe.setPublishableKey($("meta[name=stripe_key]").attr("content"));
					this.form.on("submit", $.proxy(this.sendToken, this));
				},
				
				sendToken: function(event) {
					event.preventDefault();
					Stripe.createToken(this.form, $.proxy(this.stripeResponseHandler, this));
				},

				stripeResponseHandler: function(status, response) {
					if (response.error) {
						if (!$(".content .inner .alert").size()) {
							$("<div>", { class: "alert alert-warning" }).prependTo(".content .inner");
						}
						$(".content .inner .alert").text(response.error.message);
						return this.submitButton.prop("disabled", false);
					}

					$("<input>", {
						type: "hidden",
						name: "stripeToken",
						value: response.id
					}).appendTo(this.form);

					this.form[0].submit();
				}

			};

			StripeBilling.init();
		});
	</script>
@endsection