@extends('page')

@section('content')

	<h1>Checkout</h1>
	
	@if (!count(Session::get('cart')))
	
	<p>Your cart is empty.
	
	@else

	{{ Form::open(['id'=>'checkout', 'novalidate'=>'']) }}
	
		<table class="table">
			<thead>
				<tr>
					<th>Product</th>
					<th class="numeric">Qty</th>
					<th class="numeric align-right">Price $</th>
				</tr>
			</thead>
			<tbody>
				<?php $total = $publications = 0; ?>
				@foreach (Session::get('cart') as $type=>$items)
					@foreach ($items as $id=>$item)
				<tr data-price="{{ $item['price'] }}" data-type="{{ $type }}">
					<td><a class="{{ $type }}" href="$item['url']">{{ $item['name'] }}</a></td>
					<td class="numeric">{{ Form::integer('item_' . $id, $item['quantity'], ['class'=>'form-control', 'data-numeric'=>'data-numeric', 'max'=>100]) }}</td>
					<td class="numeric align-right total">{{ number_format($item['price'] * $item['quantity']) }}</td>
				</tr>
				<?php 
				$total += $item['price'] * $item['quantity']; 
				if ($type == 'publications') $publications += $item['quantity'];
				?>
					@endforeach
				@endforeach
			</tbody>
			<tfoot @if ($publications > 0) class="shipping"@endif>
				<tr class="subtotal">
					<td></td>
					<td class="key">Subtotal</td>
					<td class="value align-right">{{ number_format($total) }}</td>
				</tr>
				<tr class="shipping">
					<td></td>
					<td class="key">Shipping</td>
					<td class="value align-right">{{ number_format(2 * $publications) }}</td>
				</tr>
				<tr class="total">
					<td></td>
					<td class="key">Total</td>
					<td class="value align-right">{{ number_format($total) }}</td>
				</tr>
			</tfoot>
		</table>

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