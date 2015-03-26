<?php namespace App\Http\Controllers;

use Auth;
use DateTime;
use LeftRight\Center\Models\Message;
use Redirect;
use Request;
use Response;
use View;

class MyController extends Controller {

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
		if (Auth::attempt(['email'=>Request::input('email'), 'password'=>Request::input('password')], true)) {
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
		$message->content = Request::input('content');
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
		$reply->message_id = Request::input('message_id');
		$reply->content = Request::input('content');
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
	public function inbound_everyone() {

		//http://help.mandrill.com/entries/22092308-What-is-the-format-of-inbound-email-webhooks-
		$inbound = json_decode(Request::input('mandrill_events'))[0];

		# Log in user (is this really safe?) todo check if user is active
		if ($user = User::where('email', $inbound->msg->from_email)->first()) {
			Auth::loginUsingId($user->id);
			$message = new Message;
			$message->slug = Slug::make($inbound->msg->text, 'messages');
			$message->content = $inbound->msg->text;
			//todo use $inbound->ts?
			$message->save();
		} else {
			//bounce
			Mail::send('emails.simple', [
				'subject'=>'Message Posting Failed',
				'paragraphs'=>[
					'Sorry, your message could not be posted because ' . $inbound->msg->from_email . ' does not belong to a current user of the system.'
				],
			], function($message) use ($inbound) {
			    $message->to($inbound->msg->from_email)->subject('Re: ' . $inbound->msg->subject);
			});
		}

	}

	# Inbound admin
	public function inbound_admin() {
		return 'hi';
	}

	# Inbound reply
	public function inbound_reply() {
		return 'hi';
	}

}