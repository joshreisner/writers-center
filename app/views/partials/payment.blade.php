{{-- used by the support and checkout views --}}

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