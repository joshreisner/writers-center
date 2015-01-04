<?php

class MyController extends BaseController {

	# Home page
	public function index() {

		# Guest page
		if (Auth::guest()) return View::make('my.guest');

		# Logged in page
		return View::make('my.index');
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

	public function settings() {
		return View::make('my.settings');
	}

}