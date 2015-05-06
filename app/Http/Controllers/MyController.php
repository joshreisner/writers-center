<?php namespace App\Http\Controllers;

use Auth;
use DateTime;
use Hash;
use Input;
use LeftRight\Center\Models\Message;
use LeftRight\Center\Models\User;
use Mail;
use Validator;

class MyController extends Controller {

	# Home page
	public function index() {

		# Guest page
		if (Auth::guest()) return view('my.guest');

		# Logged in page
		return view('my.index', [
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
			return response()->json(['status'=>'success', 'name'=>$user->name]);
		} else {
			return response()->json(['status'=>'error', 'message'=>'That username / password combination was not found.']);
		}		
	}

	# Reset your password
	public function reset() {
		if ($user = User::where('email', Input::get('email'))->first()) {
			//send eamil		
			return response()->json([
				'status' => 'success', 
				'message' => 'An email was just sent with reset instructions.',
			]);
		} else {
			return response()->json([
				'status' => 'error', 
				'message' => 'That email address was not found.'
			]);
		}
	}

	# Log out
	public function logout() {
		Auth::logout();
		return redirect()->back()->with('message', 'You are now logged out.');		
	}

	# Show settings page
	public function settings() {

		# Guest page
		if (Auth::guest()) return view('my.guest');

		return view('my.settings', ['user' => User::find(Auth::id())]);
	}

	# Save changes from settings page
	public function saveSettings() {

		//validate form
		$validator = Validator::make(Input::all(), [
			'name' => 'required',
			'email' => 'required|email',
			'address' => 'required',
			'city' => 'required',
			'state' => 'required',
			'zip' => 'required|numeric',
			'password' => 'min:8|confirmed',
		]);

		if ($validator->fails()) {
			return redirect()->action('PaymentController@support_index')
				->withInput()
				->withErrors($validator)
				->with('error', 'The form did not go through. Please correct the highlighted errors before continuing.');
		}
		
		$user = User::find(Auth::id());
		$user->name = Input::get('name');
		$user->email = Input::get('email');
		$user->address = Input::get('address');
		$user->city = Input::get('city');
		$user->state = Input::get('state');
		$user->zip = Input::get('zip');
		if (Input::has('phone')) {
			$user->phone = preg_replace('/\D/', '', Input::get('phone'));
			if (strlen($user->phone) != 10) $user->phone = null;
		}
		if (Input::has('password')) {
			$user->password = Hash::make(Input::get('password'));
		}
		$user->save();

		return redirect()->action('MyController@settings')->with('message', 'Your settings were successfully updated.');
	}

	# Add new post
	public function message() {
		$message = new Message;
		$message->content = Input::get('content');
		$message->save();

		# Get all posts again, return html
		return view('my.messages', [
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
		return view('my.replies', [
			'message'=>Message::with(['creator', 'replies'=>function($query){
					$query->orderBy('created_at', 'asc');
				}])
				->find($reply->message_id),
		]);
	}

	# Show single post
	public function show($message_id) {
		return view('my.show', ['message'=>Message::find($message_id)]);
	}

	# Inbound message
	public function inbound_everyone() {

		//http://help.mandrill.com/entries/22092308-What-is-the-format-of-inbound-email-webhooks-
		$inbound = json_decode(Input::get('mandrill_events'))[0];

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