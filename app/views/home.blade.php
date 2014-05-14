@extends('template')

@section('body_class') home @endsection

@section('content')

	<div class="carousel">
		<div class="inner">
			@foreach ($items as $item)
			<a class="item {{ $item->type }}" href="#">
				<img src="{{ $item->backing->url }}" width="{{ $item->backing->width }}" height="{{ $item->backing->height }}">
				<h1>{{ nl2br($item->title) }}</h1>
				<div class="description">{{ nl2br($item->content) }}</div>
				<div class="type">{{ $item->type }}</div>
			</a>
			@endforeach
		</div>
	</div>

	<div class="container">
		<div class="row promos">
			<div class="col-md-4">
				<div class="promo events">
					Events go here
				</div>
			</div>
			<div class="col-md-4">
				<div class="promo courses">
					<form class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-3 control-label"></label>
						    <div class="col-sm-9">
								<legend>Find a class</legend>
							</div>
						</div>
						@foreach (array('Genre', 'When', 'Teacher', 'Duration') as $field)
						<div class="form-group">
							<label class="col-sm-3 control-label" for="{{ Str::slug($field) }}">{{ $field }}</label>
						    <div class="col-sm-9">
								<div class="btn-group">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="#">Action</a></li>
										<li><a href="#">Another action</a></li>
										<li><a href="#">Something else here</a></li>
										<li class="divider"></li>
										<li><a href="#">Separated link</a></li>
									</ul>
								</div>
						    </div>
						</div>
						@endforeach
						<input type="submit" value="Go">
					</form>
				</div>
			</div>
			<div class="col-md-4">
				<div class="promo support">
					<a href="/support">Support the Center</a>
				</div>
			</div>
		</div>
	</div>

@endsection