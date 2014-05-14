@extends('template')

@section('body_class') about @endsection

@section('content')

<div class="container">
	<div class="row content">
		<div class="col-md-4 side">
			<div class="inner">
				@foreach ($pages as $p)
				<li class="{{ Request::is('about' . (empty($p->slug) ? '' : '/' . $p->slug)) ? 'active' : '' }}"><a href="/about/{{ $p->slug }}">{{ $p->title }}</a></li>
				@endforeach
			</div>
		</div>
		<div class="col-md-8 page">
			<div class="page-header">
				<h1>{{ $page->title }}</h1>
			</div>
			{{ $page->content }}
		</div>

	</div>
</div>

@endsection