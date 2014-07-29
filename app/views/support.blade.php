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

			<div class="row">
				<div class="col-sm-12"><h3>Payment Details:</h3></div>
			</div>
		
			<div class="row">
				<div class="col-sm-6">
					{{ Form::text('name', 'Josh Reisner', ['class'=>'form-control', 'placeholder'=>'Your Name']) }}
				</div>
				<div class="col-sm-6">
					{{ Form::text('email', 'josh@left-right.co', ['class'=>'form-control', 'placeholder'=>'Email Address']) }}
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					{{ Form::text(null, '4242424242424242', ['class'=>'form-control', 'data-stripe'=>'number', 'placeholder'=>'Card Number']) }}
				</div>
				<div class="col-sm-2">
					{{ Form::text(null, '123', ['class'=>'form-control', 'data-stripe'=>'cvc', 'placeholder'=>'CVC']) }}
				</div>
				<div class="col-sm-2 select">
					{{ Form::selectMonth(null, date('m'), ['class'=>'form-control', 'data-stripe'=>'exp-month']) }}
				</div>
				<div class="col-sm-2 select">
					{{ Form::selectYear(null, date('Y'), date('Y') + 10, null, ['class'=>'form-control', 'data-stripe'=>'exp-year']) }}
				</div>
			</div>

			{{ Form::submit('Submit Payment', ['class'=>'btn btn-primary']) }}

		{{ Form::close() }}
	</div>
@endsection

@section('side')
	<div class="wallpaper">
		<p>Perhaps information goes here about the donation, such as the Center's 501(c)(3) status or what the donation supports.</p>
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