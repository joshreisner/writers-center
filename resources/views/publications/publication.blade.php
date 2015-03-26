@extends('page')

@section('content')

	<a class="label" href="/publications">Publications</a>

	<div class="indent">
		
		<h1>
			{{ $publication->title }}
			{!! App\Http\Controllers\Controller::editLink($publication) !!}
			@if (!empty($publication->author))
				<small>by {{ $publication->author }}</small>
			@endif
		</h1>
		
		@if (!empty($publication->image->url))
		<div class="cover">
			<div class="publication" style="background-image:url({{ $publication->image->url }})">
			</div>
		</div>
		@endif

		<dl>
			<dt>Length</dt>
			<dd>{{ $publication->pages }} pages</dd>

			<dt>Year</dt>
			<dd>{{ $publication->publish_date->format('Y') }}</dd>

			@if ($publication->price !== null)
			<dt>Price</dt>
			<dd>{{ App\Http\Controllers\Controller::formatPrice($publication->price) }}</dd>
			@endif
		</dl>

		@if (App::environment('production'))
			@if (!empty($publication->paypal_id))
			<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> 
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="{{ $publication->paypal_id }}">
				<input type="submit" name="submit" class="btn btn-primary" value="Add to Cart">
			</form>	
			@endif
		@else
			<p>
				@if (Session::has('cart.publications') && array_key_exists($publication->id, Session::get('cart.publications')))
					<a class="btn btn-disabled">Added to Cart</a>
				@else
					<a href="{{ URL::action('PaymentController@add_publication', $publication->id) }}" class="btn btn-primary">Add to Cart</a>
				@endif
			</p>
		@endif

		{!! $publication->description !!}
	
		@if (!empty($publication->praise))
		<div class="praise">
			<h3>Praise for <em>{{ $publication->title }}</em></h3>
			{{ $publication->praise }}
		</div>
		@endif

		@if (!empty($publication->about_the_author))
		<div class="about_the_author">
			<h3>About the Author</em></h3>
			{{ $publication->about_the_author }}
		</div>
		@endif

	</div>
	
@endsection

@section('side')
	@include('publications.side')
@endsection