<article>

	<div class="tools">
		<a href="{{ action('MyController@show', $message->id) }}"><i class="fa fa-link"></i></a>
	</div>

	<img src="/assets/img/avatar-josh.jpg" width="200" height="200">

	<h2>
		{{ $message->creator->name }} <span>to</span> Everyone
		<small>8 hrs</small>
	</h2>

	<p>{{ $message->content }}</p>

	<ul class="replies">
		@include('my.replies')
	</ul>
	
	{{ Form::open(['action'=>'MyController@reply', 'class'=>'reply']) }}
		<img src="/assets/img/avatar-josh.jpg" width="200" height="200">
		{{ Form::hidden('message_id', $message->id) }}
		<h2>Josh Reisner</h2>
		<div class="form-group">
			{{ Form::textarea('content', false, ['class'=>'form-control', 'placeholder'=>'Reply']) }}
		</div>
		<div class="form-group buttons">
			{{ Form::submit('Publish', ['class'=>'btn btn-primary']) }}
			<a href="#cancel" class="btn btn-default">Cancel</a>
		</div>
	{{ Form::close() }}

</article>