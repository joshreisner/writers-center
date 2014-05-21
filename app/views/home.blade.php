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
						<div class="form-group">
							<label class="col-sm-4 control-label" for="genre">
								Genre
							</label>
						    <div class="col-sm-7">
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
						<div class="form-group">
							<label class="col-sm-4 control-label" for="when">
								When
							</label>
						    <div class="col-sm-7">
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
						<div class="form-group">
							<label class="col-sm-4 control-label" for="teacher">
								Teacher
							</label>
						    <div class="col-sm-7">
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
						<div class="form-group">
							<label class="col-sm-4 control-label" for="duration">
								Duration
							</label>
						    <div class="col-sm-8">
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
					</form>
				</div>
			</div>
			<div class="col-md-4">
				<div class="promo support">
					<a href="/support">Support the Center</a>
				</div>
			</div>
		</div>
		<div class="row supporters">
			<div class="col-md-10 col-md-offset-1">
				<div class="row">
					<div class="col-md-6">
						<p>Programs and events at The Hudson Valley Writers' Center are made possible in part by grants from the 
							Bydale Foundation, 
							David G. Taft Foundation, 
							Orchard Foundation, 
							William E. Robinson Foundation, and 
							Thendara Foundation; with public funds from the 
							<a href="http://www.nysca.org/">New York State Council on the Arts</a>, a State Agency, and the 
							<a href="http://www.nea.gov/">National Endowment for the Arts</a>; and by the Basic Program Support Grant of 
							<a href="http://www.westarts.com/">Arts Westchester</a> with funds from Westchester County Government.</p>
					</div>
					<div class="col-md-2">
						<a href=""><img src="/assets/img/supporter-artswestchester.png" width="330" height="299" class="img-responsive"></a>
					</div>
					<div class="col-md-2">
						<a href=""><img src="/assets/img/supporter-nea.png" width="200" height="249" class="img-responsive"></a>
					</div>
					<div class="col-md-2">
						<a href=""><img src="/assets/img/supporter-nysca.png" width="397" height="511" class="img-responsive"></a>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection