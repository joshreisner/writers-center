@extends('page')

@section('content')

	<h1>Checkout</h1>
	
	@if (!Session::get('quantity'))
	
	<p>Your cart is empty.
	
	@else
	
	<table class="table">
		<thead>
			<tr>
				<th>Product</th>
				<th class="align-right">Price</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php $total = 0; ?>
			@foreach (Session::get('cart') as $type=>$items)
				@foreach ($items as $id=>$item)
			<tr>
				<td><a class="{{ $type }}" href="$item['url']">{{ $item['name'] }}</a></td>
				<td class="numeric align-right">{{ number_format($item['quantity']) }}</td>
				<td><a href="{{ URL::action('PaymentController@remove_' . Str::singular($type), $id) }}" class="glyphicon glyphicon-remove-circle"></a></td>
			</tr>
			<?php $total += $item['quantity']; ?>
				@endforeach
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<td></td>
				<td class="align-right">{{ number_format($total) }}</td>
				<td></td>
			</tr>
		</tfoot>
	</table>

	{{ Form::open(['id'=>'checkout']) }}
	
		<legend>Payment Details</legend>
		
		<div class="row">
			<div class="col-sm-6">
				{{ Form::text('name', 'Josh Reisner', ['class'=>'form-control', 'placeholder'=>'Your Name']) }}
			</div>
			<div class="col-sm-6">
				{{ Form::text('email', 'josh@left-right.co', ['class'=>'form-control', 'placeholder'=>'Email']) }}
			</div>
		</div>

		<div class="row">
			<div class="col-sm-10">
				{{ Form::text(null, '4242424242424242', ['class'=>'form-control', 'data-stripe'=>'number', 'placeholder'=>'Card #']) }}
			</div>
			<div class="col-sm-2">
				{{ Form::text(null, '123', ['class'=>'form-control', 'data-stripe'=>'cvc', 'placeholder'=>'CVC']) }}
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				{{ Form::selectMonth(null, date('m'), ['class'=>'form-control', 'data-stripe'=>'exp-month']) }}
			</div>
			<div class="col-sm-6">
				{{ Form::selectYear(null, date('Y'), date('Y') + 10, null, ['class'=>'form-control', 'data-stripe'=>'exp-year']) }}
			</div>
		</div>

		{{ Form::submit('Submit Payment', ['class'=>'btn btn-primary']) }}

	{{ Form::close() }}

	@endif

@endsection

@section('script')
	<script src="https://js.stripe.com/v2/"></script>
	<script src="/assets/js/support.js"></script>
@endsection