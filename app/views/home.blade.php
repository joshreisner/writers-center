@extends('template')

@section('page')
	@include('partials.notifications')

	<div class="carousel">
		@foreach ($items as $item)
		<div class="item {{ Str::slug($item->type) }}">
			<div class="inner">
				<h1>{{ nl2br($item->title) }}</h1>
				<div class="description">{{ nl2br($item->content) }}</div>
				<div class="type">{{ $item->type }}</div>
				<div class="image" style="background-image:url({{ $item->backing->url }})"></div>
			</div>
		</div>
		@endforeach
	</div>

	<div class="container">
		<div class="row promos">
			<div class="col-md-4">
				<div class="promo events">
					<table>
						<thead>
							<tr>
								<th></th>
								<th>M</th>
								<th>Tu</th>
								<th>W</th>
								<th>Th</th>
								<th>F</th>
								<th>Sa</th>
								<th>Su</th>
							</tr>
						</thead>
						<tbody>

						<?php
						$month = '';
						for ($week = 0; $week < 4; $week++) {
							echo '<tr><th>';
							if ($month != date('M', $start)) {
								$month = date('M', $start);
								echo $month;
							}
							echo '</th>';
							for ($day = 0; $day < 7; $day++) {
								echo '<td>';
								$format = date('Y-m-d', $start);
								if (in_array($format, $event_dates)) {
									echo link_to('/events?date=' . $format, date('d', $start));
								} else {
									echo date('d', $start);
								}
								echo '</td>';
								$start += 86400;
							}
							echo '</tr>';
						}
						?>
					</table>
				</div>
			</div>
			<div class="col-md-4">
				<div class="promo courses">
					{{ Form::open(array('url'=>URL::action('CourseController@index'), 'method'=>'get', 'id'=>'find-a-class', 'class'=>'form-horizontal')) }}
						<div class="form-group">
							<label class="col-sm-3 control-label" for="genre">
								Genre
							</label>
						    <div class="col-sm-7">
						    	{{ Form::dropdown('genre', $genre_select) }}
						    </div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="day">
								Day
							</label>
						    <div class="col-sm-7">
						    	{{ Form::dropdown('day', $day_select) }}
						    </div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="instructor">
								Teacher
							</label>
						    <div class="col-sm-7">
						    	{{ Form::dropdown('instructor', $instructor_select) }}
						    </div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="duration">
								Duration
							</label>
						    <div class="col-sm-7">
						    	{{ Form::dropdown('duration', $duration_select) }}
						    </div>
						</div>
						<div class="form-group">
						    <div class="col-sm-7 col-sm-offset-3">
						    	{{ Form::submit('Find a class') }}
						    </div>
						</div>
					{{ Form::close() }}
				</div>
			</div>
			<div class="col-md-4">
				<div class="promo support">
					<a href="/support">Support<br>the Center</a>
				</div>
			</div>
		</div>
		<div class="row supporters">
			<div class="col-md-7 col-md-offset-1">
				<p>Programs and events at The Hudson Valley Writers' Center are made possible in part by grants from the 
					Bydale Foundation, 
					David G. Taft Foundation, 
					Orchard Foundation, 
					William E. Robinson Foundation, and 
					Thendara Foundation; with public funds from the 
					<a href="https://www.nysca.org/">New York State Council on the Arts</a>, a State Agency, and the 
					<a href="http://arts.gov/">National Endowment for the Arts</a>; and by the Basic Program Support Grant of 
					<a href="https://artswestchester.org/">Arts Westchester</a> with funds from Westchester County Government.</p>
			</div>
			<div class="col-md-1 col-xs-4">
				<a href="https://artswestchester.org/"><img src="/assets/img/supporter-artswestchester.png" width="330" height="299" class="img-responsive"></a>
			</div>
			<div class="col-md-1 col-xs-4">
				<a href="http://arts.gov/"><img src="/assets/img/supporter-nea.png" width="200" height="249" class="img-responsive"></a>
			</div>
			<div class="col-md-1 col-xs-4">
				<a href="https://www.nysca.org/"><img src="/assets/img/supporter-nysca.png" width="397" height="511" class="img-responsive"></a>
			</div>
		</div>
	</div>

@endsection