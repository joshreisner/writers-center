{{-- used by the support and checkout views --}}

<div class="row">
	<div class="col-sm-12"><h3>Payment Details:</h3></div>
</div>

<div class="row">
	<div class="col-sm-6">
		{{ Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Your Name']) }}
	</div>
	<div class="col-sm-6">
		{{ Form::text('email', null, ['class'=>'form-control', 'placeholder'=>'Email Address']) }}
	</div>
</div>

<div class="row">
	<div class="col-sm-6">
		{{ Form::text(null, null, ['class'=>'form-control', 'data-stripe'=>'number', 'placeholder'=>'Card Number']) }}
	</div>
	<div class="col-sm-2">
		{{ Form::text(null, null, ['class'=>'form-control', 'data-stripe'=>'cvc', 'placeholder'=>'CVC']) }}
	</div>
	<div class="col-sm-2 select">
		{{ Form::select(null, [1=>'Jan', 2=>'Feb', 3=>'Mar', 4=>'Apr', 5=>'May', 6=>'Jun', 7=>'Jul', 8=>'Aug', 9=>'Sep', 10=>'Oct', 11=>'Nov', 12=>'Dec'], date('m'), ['class'=>'form-control', 'data-stripe'=>'exp-month']) }}
	</div>
	<div class="col-sm-2 select">
		{{ Form::selectYear(null, date('Y'), date('Y') + 10, null, ['class'=>'form-control', 'data-stripe'=>'exp-year']) }}
	</div>
</div>