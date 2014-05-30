@extends('page')

@section('content')

	<div class="col-md-offset-1">
		
		<h1>
			{{ $publication->title }}
			{{ PublicationController::editLink($publication) }}
		</h1>
		
		@if (!empty($publication->image->url))
		<figure class="{{ ($publication->image->width > $publication->image->height) ? 'landscape' : 'portrait' }}">
			<img src="{{ $publication->image->url }}" width="{{ $publication->image->width }}" height="{{ $publication->image->height }}">
			@if (!empty($publication->caption))
				<figcaption>{{ $publication->caption }}</figcaption>
			@endif
		</figure>
		@endif

		{{ $publication->description }}
	
		@if (!empty($publication->paypal_id))
		<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> 
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="{{ $publication->paypal_id }}">
			<input type="submit" name="submit" class="btn btn-primary" value="Add to Cart">
		</form>	
		@endif
	</div>
	
@endsection

@section('side')
	<div class="wallpaper"></div>
@endsection