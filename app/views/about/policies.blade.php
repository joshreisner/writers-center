@foreach ($policies as $policy)
	<h4>{{ $policy->title }}</h4>
	{{ $policy->content }}
@endforeach