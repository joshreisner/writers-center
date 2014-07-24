@if (Session::get('quantity', 0))

	<div id="cart">
		<span class="label">Your Cart</span>
		<h1>{{ Session::get('quantity') }} {{ trans_choice('messages.items', Session::get('quantity')) }}</h1>
		<table class="table">
			<thead>
				<tr>
					<th>Product</th>
					<th>Price</th>
				</tr>
			</thead>
			<tbody>
				@foreach (Session::get('cart') as $type=>$items)
					@foreach ($items as $item)
				<tr>
					<td><a class="{{ $type }}" href="{{ $item['url'] }}">{{ $item['name'] }}</a></td>
					<td class="numeric align-right">{{ number_format($item['quantity']) }}</td>
				</tr>
					@endforeach
				@endforeach
			</tbody>
		</table>
		<a href="/checkout" class="btn btn-default">Checkout</a>
	</div>

@endif