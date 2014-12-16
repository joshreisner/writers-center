@foreach ($policies as $policy)
	<h3>{{ $policy->title }} {{ BaseController::editLink($policy) }}</h3>
	{{ $policy->content }}
@endforeach