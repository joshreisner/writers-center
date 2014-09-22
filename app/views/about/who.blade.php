@foreach ($groups as $group)
	<h3>{{ $group->title }}</h3>
	<ul class="who-we-are">
		@foreach ($group->roles as $role)
		<li>{{ $role->name }} <em>{{ $role->role }}</em></li>
		@endforeach
	</ul>
@endforeach
