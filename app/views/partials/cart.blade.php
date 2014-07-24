@if (Session::has('cart'))

	<div id="cart">
		<span class="label">Your Cart</span>
		<h1>3 Items</h1>
		<table class="table">
			<thead>
				<tr>
					<th>Product</th>
					<th>Price</th>
				</tr>
			</thead>
			<tbody>
				<?php $total = 0; ?>
				@foreach (Session::get('cart') as $type=>$item)
				<tr>
					<td><a class="{{ $type }}" href="{{ $item['url'] }}">{{ $item['name'] }}</a></td>
					<td class="num">{{ number_format($item['amount']) }}</td>
				</tr>
				<?php $total += $item['amount']; ?>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th></th>
					<th class="num">${{ number_format($total) }}</th>
				</tr>
			</tfoot>
		</table>
		<a href="/checkout" class="btn btn-default">Checkout</a>
	</div>

@endif