@extends('template')

@section('body_class') publications @endsection

@section('content')

<div class="container">
	<div class="row content">
		<div class="col-md-4 side">
			<div class="inner">
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

		<div class="col-md-8 page">

			@yield('page')

		</div>

	</div>
</div>

@endsection