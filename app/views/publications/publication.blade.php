@extends('template')

@section('content')

<div class="container">
	<div class="row content">
		<div class="col-md-3">
			<div class="well">
				<form role="form">
					<div class="form-group">
						<label for="types">Types</label>
						@foreach ($types as $type)
						<div class="checkbox">
							<label>
								<input type="checkbox" value="{{ $type->id }}">
								{{ $type->title }}
							</label>
						</div>
						@endforeach
					</div>
				</form>
			</div>
		</div>

		<div class="col-md-9">
			<div class="page-header">
				<h1>{{ $publication->title }}</h1>
			</div>
			{{ $publication->description }}
		</div>

	</div>
</div>

@endsection