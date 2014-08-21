@extends('page')

@section('content')
	<div class="indent">
		<h1>
			{{ $page->title }}
			{{ AboutController::editLink($page) }}
		</h1>
		{{ $page->content }}
	</div>
@endsection

@section('side')
	<div class="inner wallpaper">
		<ul>
			@foreach ($pages as $p)
			<li class="{{ Request::is('about' . (empty($p->slug) ? '' : '/' . $p->slug)) ? 'active' : '' }}"><a href="/about/{{ $p->slug }}">{{ $p->title }}</a></li>
			@endforeach
		</ul>
	</div>
@endsection