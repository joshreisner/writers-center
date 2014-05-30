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
	</div>
	
@endsection

@section('side')
	<div class="wallpaper"></div>
@endsection