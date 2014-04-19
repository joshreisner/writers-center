@extends('template')

@section('content')
<div class="container">
	<div class="row content">
		@include('subnav')

		<div class="col-md-9">
			<div class="page-header">
				<h1>{{ $title }}</h1>
			</div>
			{{ $content }}
		</div>

	</div>
</div>
@endsection