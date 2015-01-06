@foreach ($posts as $post)
	<article>
		<div class="tools">
			<a href="{{ action('MyController@show', 123) }}"><i class="fa fa-link"></i></a>
		</div>
		<img src="/assets/img/avatar-kate.jpg" width="200" height="200">
		<h2>
			{{ $post->updated_by }} <span>to</span> Everyone
			<small>8 hrs</small>
		</h2>
		<p>{{ $post->content }}</p>
		<ul class="replies">
			<li>
				<img src="/assets/img/avatar-josh.jpg" width="200" height="200">
				<h2>
					Josh Reisner
					<small>9 hrs</small>
				</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			</li>
			<li>
				<img src="/assets/img/avatar-josh.jpg" width="200" height="200">
				{{ Form::open(['action'=>'MyController@comment', 'id'=>'comment']) }}
					<h2>Josh Reisner</h2>
					<div class="form-group">
						{{ Form::textarea('reply', false, ['class'=>'form-control', 'placeholder'=>'Reply']) }}
					</div>
					<div class="form-group buttons">
						{{ Form::submit('post', ['class'=>'btn btn-primary']) }}
						<a href="#cancel" class="btn btn-default">Cancel</a>
					</div>
				{{ Form::close() }}
			</li>
		</ul>
	</article>
@endforeach