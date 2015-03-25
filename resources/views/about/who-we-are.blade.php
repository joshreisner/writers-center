@foreach ($groups as $group)
	<h3>{{ $group->title }} {{ BaseController::editLink($group) }}</h3>
	<ul class="who-we-are">
		@foreach ($group->roles as $role)
		<li>{{ $role->name }} <em>{{ $role->role }}</em> {{ BaseController::editLink($role) }}</li>
		@endforeach
	</ul>
@endforeach
