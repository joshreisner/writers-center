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
			'messages'=>Message::with(['creator', 'replies'=>function($query){
						$query->orderBy('created_at', 'asc');
					}])
					->orderBy('created_at', 'desc')
					->get(),
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
	public function message() {
		$message = new Message;
		$message->content = Input::get('content');
		$message->save();

		# Get all posts again, return html
		return View::make('my.messages', [
			'messages'=>Message::with(['creator', 'replies'=>function($query){
					$query->orderBy('created_at', 'asc');
				}])
				->orderBy('created_at', 'desc')
				->get(),
		]);
	}

	# Add new comment
	public function reply($message_id) {
		$reply = new Reply;
		$reply->message_id = Input::get('message_id');
		$reply->content = Input::get('content');
		$reply->save();

		# Get all replies again, return html
		return View::make('my.replies', [
			'message'=>Message::with(['creator', 'replies'=>function($query){
					$query->orderBy('created_at', 'asc');
				}])
				->find($reply->message_id),
		]);
	}

	# Show single post
	public function show($message_id) {
		return View::make('my.show', ['message'=>Message::find($message_id)]);
	}

	# Inbound message
	public function inbound_message() {

		//http://help.mandrill.com/entries/22092308-What-is-the-format-of-inbound-email-webhooks-

		Mail::send('emails.message', [
			'subject'=>'Inbound Message',
			'timestamp'=>Request::json('ts'),
			'text'=>Request::json('msg.text'),
			'from_email'=>Request::json('msg.from_email'),
		], function($message) {
		    $message->to('josh@joshreisner.com')->subject('Inbound Message');
		});


	}

	# Inbound reply
	public function inbound_reply() {
		return 'hi';
	}

}