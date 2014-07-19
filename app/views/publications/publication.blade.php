@extends('page')

@section('content')

	<a class="label" href="/publications">Publications</a>

	<div class="indent">
		
		<h1>
			{{ $publication->title }}
			{{ BaseController::editLink($publication) }}
			@if (!empty($publication->author))
				<small>by {{ $publication->author }}</small>
			@endif
		</h1>
		
		@if (!empty($publication->image->url))
		<figure class="{{ ($publication->image->width > $publication->image->height) ? 'landscape' : 'portrait' }}">
			<img src="{{ $publication->image->url }}" width="{{ $publication->image->width }}" height="{{ $publication->image->height }}">
			@if (!empty($publication->caption))
				<figcaption>{{ $publication->caption }}</figcaption>
			@endif
		</figure>
		@endif

		<dl>
			<dt>Length</dt>
			<dd>{{ $publication->pages }} pages</dd>

			<dt>Year</dt>
			<dd>{{ $publication->year }}</dd>

			@if ($publication->price !== null)
			<dt>Price</dt>
			<dd>{{ BaseController::formatPrice($publication->price) }}</dd>
			@endif
		</dl>

		@if (!empty($publication->paypal_id))
		<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> 
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="{{ $publication->paypal_id }}">
			<input type="submit" name="submit" class="btn btn-primary" value="Add to Cart">
		</form>	
		@endif

		{{ $publication->description }}
	
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
	<div class="wallpaper">
		<span class="label">Latest Publications</span>
		@foreach ($related as $publication)
			<h3><a href="/publications/{{ $publication->slug }}">{{ $publication->title }}</a></h3>
		@endforeach
	</div>
@endsection