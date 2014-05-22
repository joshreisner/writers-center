@extends('template')

@section('page')

<div class="container">
	<div class="row page">
		<div class="col-md-8 content">
			<div class="inner">
				<div class="col-md-offset-1">
					<h1>{{ $page->title }}</h1>
					{{ $page->content }}
				</div>
			</div>
		</div>
		<div class="col-md-4 side">
			<div class="inner wallpaper">
				<ul>
					@foreach ($pages as $p)
					<li class="{{ Request::is('about' . (empty($p->slug) ? '' : '/' . $p->slug)) ? 'active' : '' }}"><a href="/about/{{ $p->slug }}">{{ $p->title }}</a></li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>

@endsection