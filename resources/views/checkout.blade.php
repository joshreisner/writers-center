@extends('page')

@section('content')

	@if (!App\Http\Controllers\PaymentController::has_membership())
		@if (Auth::guest())
			<div class="alert alert-info">
				Are you an HVWC Member? <a href="#login" class="alert-link">Log in now</a> to get 
				your membership discount, or <a href="/about/become-a-member" class="alert-link">read 
				about the benefits of membership</a>.
			</div>
		@elseif (empty(Auth::user()->membership_expires))
			<div class="alert alert-info">
				<p>HVWC Members get discounts on publications, classes, and events!</p>
				{!! link_to_action('PaymentController@add_membership', 'Become a Member', [], ['class'=>'btn btn-primary']) !!}
			</div>
		@elseif (Auth::user()->membership_expires < now())
			<div class="alert alert-info">Your membership has expired!</div>
		@endif
	@endif
	
	<h1>Checkout</h1>
	
	@if (!count(Session::get('cart')))
	
	<p>Your cart is empty.
	
	@else
	
	{!! Form::open(['id'=>'checkout', 'novalidate'=>'']) !!}
	
		<table class="table">
			<thead>
				<tr>
					<th>Product</th>
					<th class="numeric">Qty</th>
					<th class="numeric align-right">Price</th>
					<th class="remove"></th>
				</tr>
			</thead>
			<tbody>
				<?php $total = $publications = 0; ?>
				@foreach (Session::get('cart') as $type=>$items)
					@foreach ($items as $id=>$item)
				<tr data-price="{{ $item['price'] }}" data-type="{{ $type }}">
					<td class="title"><a class="{{ $type }}" href="$item['url']">{{ $item['name'] }}</a></td>
					<td class="quantity">
						@if ($type == 'courses')
							{!! Form::integer('item_' . $id, $item['quantity'], ['class'=>'form-control', 'disabled'=>'disabled']) !!}</td>
						@else
							{!! Form::integer('item_' . $id, $item['quantity'], ['class'=>'form-control', 'data-numeric'=>'data-numeric', 'max'=>100]) !!}</td>
						@endif

					<td class="price align-right">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
					<td class="remove align-right"><a href="{{ action('PaymentController@remove_item', [$type, $id]) }}"><i class="fa fa-times"></i></a></td>
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
					<td class="value align-right">${{ number_format($total, 2) }}</td>
				</tr>
				<tr class="shipping">
					<td></td>
					<td class="key">Shipping</td>
					<td class="value align-right">${{ number_format(2 * $publications, 2) }}</td>
				</tr>
				<tr class="total">
					<td></td>
					<td class="key">Total</td>
					<td class="value align-right">${{ number_format($total, 2) }}</td>
				</tr>
			</tfoot>
		</table>

		@include('partials.payment')
		
		<div class="row form-group">
			<div class="col-sm-12">
				{!! Form::submit('Submit Payment', ['class'=>'btn btn-primary']) !!}
			</div>
		</div>

	{!! Form::close() !!}

	@endif

	<script src="https://js.stripe.com/v2/"></script>
@endsection

@section('side')
	<div class="wallpaper">
		<span class="label">Policies</span>
		@foreach ($policies as $policy)
		<div class="policy">
			<h3>{{ $policy->title }}</h3>
			{!! $policy->content !!}
		</div>
		@endforeach
	</div>
@endsection