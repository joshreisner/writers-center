@foreach ($policies as $policy)
	<h3>{{ $policy->title }}</h3>
	{{ $policy->content }}
@endforeach