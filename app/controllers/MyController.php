<?php

class MyController extends BaseController {

	# Home page
	public function index() {

		# Guest page
		if (Auth::guest()) return View::make('my.guest');

		# Logged in page
		return View::make('my.index', [
			'targets'=>[
				'Groups'=>[
					'everyone'=>'Everyone',
					'admin'=>'HVWC Admin',
				],
				'Your Classes'=>[
					1=>'Writing Flash Fiction',
					2=>'Get Unblocked',
				],
			],
			'posts'=>MyHvwcPost::all(),
		]);
	}

	# Log in via post
	public function login() {
		if (Auth::attempt(['email'=>Input::get('email'), 'password'=>Input::get('password')], true)) {
			$user = Auth::user();
			$user->last_login = new DateTime;
			$user->save();
			return Response::json(['status'=>'success', 'name'=>$user->name]);
		} else {
			return Response::json(['status'=>'error', 'message'=>'That username / password combination was not found.']);
		}		
	}

	# Reset your password
	public function reset() {
		return Response::json(['message'=>'This feature has not yet been implemented, sorry!']);
	}

	# Log out
	public function logout() {
		Auth::logout();
		return Redirect::back()->with('message', 'You are now logged out.');		
	}

	# Show settings page
	public function settings() {
		return View::make('my.settings');
	}

	# Add new post
	public function post() {
		$post = new MyHvwcPost;
		$post->content = Input::get('content');
		$post->created_by = Auth::id();
		$post->save();
	}

	# Add new comment
	public function comment($post_id) {
		return 'comment posted';
	}

	# Show single post
	public function show($post_id) {
		return 'show shown ' . $post_id;
	}

}