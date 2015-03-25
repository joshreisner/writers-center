<div class="wallpaper">
	<h3 style="margin:0;"><a href="/about/shp">About Slapering Hol Press</a></h3>
</div>	

@if (!empty($post))
<div class="wallpaper">
	<span class="label">Latest News</span>
	<h3><a href="/blog/{{ $post->slug }}">{{ $post->title }}</a></h3>
</div>	
@endif

@if (count($events))
<div class="wallpaper">
	<span class="label">Upcoming Events</span>
	<ul class="events">
		@foreach ($events as $event)
		<li><span>{{ $event->start->format('m/d') }}</span> {!! link_to(App\Http\Controllers\EventController::url($event), $event->title) !!}</li>
		@endforeach
	</ul>
</div>	
@endif

<div class="wallpaper">
	<span class="label">SHP Masthead</span>

	@foreach ($groups as $group)
	<h3>{{ $group->title }}</h3>
	<ul class="who-we-are">
		@foreach ($group->roles as $role)
		<li>{{ $role->name }} <em>{{ $role->role }}</em></li>
		@endforeach
	</ul>
	@endforeach
</div>