{{-- used by template --}}

@if (Session::has('cart') && (!isset($class) || ($class != 'checkout')))

	<div id="cart">
		<span class="label">Your Cart</span>
		<h1>{{ count(Session::get('cart')) }} @choice('messages.items', count(Session::get('cart')))</h1>
		<ul>
		@foreach (Session::get('cart') as $type=>$items)
			@foreach ($items as $item)
			<li><a class="{{ $type }}" href="{{ $item['url'] }}">{{ $item['name'] }}</a></li>
			@endforeach
		@endforeach
		</ul>
		<a href="/checkout" class="btn btn-default">Checkout</a>
	</div>

@endif