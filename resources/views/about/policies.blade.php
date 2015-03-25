@foreach ($policies as $policy)
	<h3>{{ $policy->title }} {!! App\Http\Controllers\Controller::editLink($policy) !!}</h3>
	{!! $policy->content !!}
@endforeach