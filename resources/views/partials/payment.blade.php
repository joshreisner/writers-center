{{-- used by the support and checkout views --}}

<div class="payment">
	
	<div class="row form-group">
		<div class="col-sm-12"><h3>Payment Details:</h3></div>
	</div>
	
	<div class="row form-group">
		<div class="col-sm-6">
			{!! Form::text(null, (App::environment('production') ? null : '4242 4242 4242 4242'), ['class'=>'form-control required', 'data-stripe'=>'number', 'placeholder'=>'Card Number', 'pattern'=>'\d*']) !!}
		</div>
		<div class="col-sm-2">
			{!! Form::text(null, (App::environment('production') ? null : '123'), ['class'=>'form-control required', 'data-stripe'=>'cvc', 'placeholder'=>'CVC', 'pattern'=>'\d*', 'autocomplete'=>'off']) !!}
		</div>
		<div class="col-sm-2 select">
			{!! Form::select(null, [1=>'Jan', 2=>'Feb', 3=>'Mar', 4=>'Apr', 5=>'May', 6=>'Jun', 7=>'Jul', 8=>'Aug', 9=>'Sep', 10=>'Oct', 11=>'Nov', 12=>'Dec'], date('m'), ['class'=>'form-control required', 'data-stripe'=>'exp-month']) !!}
		</div>
		<div class="col-sm-2 select">
			{!! Form::selectYear(null, date('Y'), date('Y') + 10, null, ['class'=>'form-control required', 'data-stripe'=>'exp-year']) !!}
		</div>
	</div>
	
	<div class="row form-group">
		<div class="col-sm-12"><h3>Contact Information:</h3></div>
	</div>
	
	<div class="row form-group">
		<div class="col-sm-6 @if ($errors->has('name')) has-error @endif">
			{!! Form::text('name', @Auth::user()->name, ['class'=>'form-control required', 'placeholder'=>'Your Name', 'title'=>$errors->first('name')]) !!}
		</div>
		<div class="col-sm-6 @if ($errors->has('email')) has-error @endif">
			{!! Form::text('email', @Auth::user()->email, ['class'=>'form-control required', 'placeholder'=>'Email Address', 'title'=>$errors->first('email')]) !!}
		</div>
	</div>
	
	<div class="row form-group">
		<div class="col-sm-6 @if ($errors->has('address')) has-error @endif">
			{!! Form::text('address', @Auth::user()->address, ['class'=>'form-control required' . ($errors->has('address') ? ' error' : ''), 'placeholder'=>'Address', 'title'=>$errors->first('address')]) !!}
		</div>
		<div class="col-sm-6 @if ($errors->has('phone')) has-error @endif">
			{!! Form::text('phone', @Auth::user()->phone, ['class'=>'form-control' . ($errors->has('phone') ? ' error' : ''), 'data-phone', 'placeholder'=>'Phone', 'title'=>$errors->first('phone')]) !!}
		</div>
	</div>
	
	<div class="row form-group">
		<div class="col-sm-6 @if ($errors->has('city')) has-error @endif">
			{!! Form::text('city', @Auth::user()->city, ['class'=>'form-control required', 'placeholder'=>'City', 'title'=>$errors->first('city')]) !!}
		</div>
		<div class="col-sm-3 select @if ($errors->has('state')) has-error @endif">
			{!! Form::select('state', array(''=>'State') + $states, @Auth::user()->state, ['class'=>'form-control required']) !!}
		</div>
		<div class="col-sm-3 @if ($errors->has('zip')) has-error @endif">
			{!! Form::text('zip', @Auth::user()->zip, ['class'=>'form-control required', 'pattern'=>'\d*', 'data-numeric', 'maxlength'=>5, 'placeholder'=>'ZIP', 'zip'=>$errors->first('zip')]) !!}
		</div>
	</div>
</div>