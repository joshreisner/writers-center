@extends('template')

@section('page')

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
					<table>
						<thead>
							<tr>
								<th></th>
								<th>Su</th>
								<th>M</th>
								<th>Tu</th>
								<th>W</th>
								<th>Th</th>
								<th>F</th>
								<th>Sa</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>May</th>
								<td><a href="/events#2014-05-18">18</a></td>
								<td><a href="/events#2014-05-19">19</a></td>
								<td><a href="/events#2014-05-20">20</a></td>
								<td><a href="/events#2014-05-21">21</a></td>
								<td><a href="/events#2014-05-22">22</a></td>
								<td><a href="/events#2014-05-23">23</a></td>
								<td><a href="/events#2014-05-24">24</a></td>
							</tr>
							<tr>
								<th></th>
								<td><a href="/events#2014-05-18">25</a></td>
								<td><a href="/events#2014-05-19">26</a></td>
								<td><a href="/events#2014-05-20">27</a></td>
								<td><a href="/events#2014-05-21">28</a></td>
								<td><a href="/events#2014-05-22">29</a></td>
								<td><a href="/events#2014-05-23">30</a></td>
								<td><a href="/events#2014-05-24">31</a></td>
							</tr>
							<tr>
								<th>Jun</th>
								<td><a href="/events#2014-06-18">1</a></td>
								<td><a href="/events#2014-06-19">2</a></td>
								<td><a href="/events#2014-06-20">3</a></td>
								<td><a href="/events#2014-06-21">4</a></td>
								<td><a href="/events#2014-06-22">5</a></td>
								<td><a href="/events#2014-06-23">6</a></td>
								<td><a href="/events#2014-06-24">7</a></td>
							</tr>
							<tr>
								<th></th>
								<td><a href="/events#2014-06-08">8</a></td>
								<td><a href="/events#2014-06-09">9</a></td>
								<td><a href="/events#2014-06-10">10</a></td>
								<td><a href="/events#2014-06-11">11</a></td>
								<td><a href="/events#2014-06-12">12</a></td>
								<td><a href="/events#2014-06-13">13</a></td>
								<td><a href="/events#2014-06-14">14</a></td>
							</tr>
					</table>
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
						    	{{ Form::dropdown('genre', $genre_select) }}
						    </div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label" for="when">
								When
							</label>
						    <div class="col-sm-7">
						    	{{ Form::dropdown('days', $day_select) }}
						    </div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label" for="teacher">
								Teacher
							</label>
						    <div class="col-sm-7">
						    	{{ Form::dropdown('instructor', $instructor_select) }}
						    </div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label" for="duration">
								Duration
							</label>
						    <div class="col-sm-7">
						    	{{ Form::dropdown('duration', $duration_select) }}
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