@extends('template')

@section('script')
	<script src="/bower_components/slick-carousel/slick/slick.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.carousel').slick({
        		arrows: true,
        		centerMode: true,
				centerPadding: '260px',
    			slidesToShow: 1,
    			infinite: true
			});
        });
    </script>	
@endsection

@section('style')
	<link rel="stylesheet" type="text/css" href="/bower_components/slick-carousel/slick/slick.css">
@endsection

@section('page')

	<div class="carousel">
		@foreach ($items as $item)
		<div class="item {{ Str::slug($item->type) }}">
			<div class="inner">
				<img src="{{ $item->backing->url }}" width="{{ $item->backing->width }}" height="{{ $item->backing->height }}">
				<h1>{{ nl2br($item->title) }}</h1>
				<div class="description">{{ nl2br($item->content) }}</div>
				<div class="type">{{ $item->type }}</div>
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
									echo '<a href="/events#' . $format . '">';
									echo date('d', $start);
									echo '</a>';
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
							<label class="col-sm-4 control-label" for="day">
								Day
							</label>
						    <div class="col-sm-7">
						    	{{ Form::dropdown('day', $day_select) }}
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
				<div class="promo publications">
					<a href="/support">Support the Center</a>
				</div>
			</div>
		</div>
		<div class="row supporters">
				<div class="col-md-1"></div>
				<div class="col-md-7">
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
				<div class="col-md-1">
					<a href=""><img src="/assets/img/supporter-artswestchester.png" width="330" height="299" class="img-responsive"></a>
				</div>
				<div class="col-md-1">
					<a href=""><img src="/assets/img/supporter-nea.png" width="200" height="249" class="img-responsive"></a>
				</div>
				<div class="col-md-1">
					<a href=""><img src="/assets/img/supporter-nysca.png" width="397" height="511" class="img-responsive"></a>
				</div>
				<div class="col-md-1"></div>
		</div>
	</div>

@endsection