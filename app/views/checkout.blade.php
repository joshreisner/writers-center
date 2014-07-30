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
				<th class="align-right">Qty</th>
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
		<!--
		<tfoot>
			<tr>
				<td></td>
				<td class="align-right">{{ number_format($total) }}</td>
				<td></td>
			</tr>
		</tfoot>
		-->
	</table>

	{{ Form::open(['id'=>'checkout']) }}
	
		@include('partials.payment')
		
		{{ Form::submit('Submit Payment', ['class'=>'btn btn-primary']) }}

	{{ Form::close() }}

	@endif

	<script src="https://js.stripe.com/v2/"></script>
@endsection

@section('side')
	<div class="wallpaper">
		<span class="label">Our Policies</span>
		<p>We usually process orders in 36 hours, etc.</p>
	</div>
@endsection