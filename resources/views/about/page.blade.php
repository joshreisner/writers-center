@extends('page')

@section('content')
	<div class="indent">
		<h1>
			{{ $page->title }}
			{!! App\Http\Controllers\AboutController::editLink($page) !!}
		</h1>
		{!! $page->content !!}
		@if (View::exists('about.' . $page->slug))
			@include('about.' . $page->slug)
		@endif
	</div>
@endsection

@section('side')
	<div class="inner wallpaper">
		<ul class="navigation">
			@foreach ($pages as $p)
			<li class="{{ Request::is('about' . (empty($p->slug) ? '' : '/' . $p->slug)) ? 'active' : '' }}"><a href="/about/{{ $p->slug }}">{{ $p->title }}</a></li>
			@endforeach
		</ul>
	</div>
@endsection