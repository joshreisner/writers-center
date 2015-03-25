@foreach ($groups as $group)
	<h3>{{ $group->title }} {{ App\Http\Controllers\Controller::editLink($group) }}</h3>
	<ul class="who-we-are">
		@foreach ($group->roles as $role)
		<li>{{ $role->name }} <em>{{ $role->role }}</em> {!! App\Http\Controllers\Controller::editLink($role) !!}</li>
		@endforeach
	</ul>
@endforeach
