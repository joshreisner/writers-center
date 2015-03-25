@foreach ($message->replies as $reply)

<li>
	<img src="/assets/img/avatar-josh.jpg" width="200" height="200">
	<h2>
		{{ $reply->creator->name }}
		<small>9 hrs</small>
	</h2>
	<p>{{ $reply->content }}</p>
</li>

@endforeach
