<?php namespace App\Http\Controllers;

use App;
use Auth;
use Input;
use Exception;
use LeftRight\Center\Models\Course;
use LeftRight\Center\Models\Donation;
use LeftRight\Center\Models\Event;
use LeftRight\Center\Models\Policy;
use LeftRight\Center\Models\Publication;
use LeftRight\Center\Models\Section;
use LeftRight\Center\Models\User;
use Mail;
use Session;
use Stripe\Stripe;
use Stripe\Charge as Stripe_Charge;
use Stripe\Customer as Stripe_Customer;
use Validator;

class PaymentController extends Controller {

	/**
	 * show checkout page
	 */
	public function checkout_index() {
		return view('checkout', [
			'policies' => Policy::get()
		]);
	}

	/**
	 * handle checkout form submit
	 */
	public function checkout_submit() {
		return view('checkout');
	}

	/**
	 * show support page
	 */
	public function support_index() {
		return view('support', [
			'preset_amounts' => [50, 100, 200, 500, 1000],
			'title' => 'Support the Center',
		]);
	}

	/**
	 * handle support form submit
	 */
	public function support_submit() {

		//validate form
		$validator = Validator::make(Input::all(), [
			'name' => 'required',
			'amount' => 'required|numeric',
			'email' => 'required|email',
			'address' => 'required',
			'city' => 'required',
			'phone' => 'numeric',
			'state' => 'required',
			'zip' => 'required|numeric',
			//'stripeToken' => 'required',
		]);

		if ($validator->fails()) {
			$messages = $validator->messages();
			dd($messages->all());
			return redirect()->action('PaymentController@support_index')
				->withInput()
				->withErrors($validator)
				->with('error', 'The form did not go through. Please correct the highlighted errors before continuing.');
		}

		//init
		Stripe::setApiKey(config('services.stripe.secret'));

		//stripe records amounts as integer
		$amount = Input::get('amount') * 100; 

		//create user (but don't log in)
		$user = User::firstOrNew(['email' => Input::get('email')]);
		if ($user->password === null) $user->password = Hash::make(str_random(12)); //better than null?
		$user->name = Input::get('name');
		$user->address = Input::get('address');
		$user->city = Input::get('city');
		$user->state = Input::get('state');
		if (Input::has('phone')) $user->phone = Input::get('phone');
		$user->zip = Input::get('zip');
		
		//stripe customer key different depending on which environment you're in
		$customer_id = (App::environment('production')) ? 'customer_id' : 'customer_test_id';

		//create or get customer
		try {
			if ($user->{$customer_id}) {
				$customer = Stripe_Customer::retrieve($user->{$customer_id});
				$customer->card = Input::get('stripeToken');
				$customer->email = $user->email;
				$customer->description = $user->name;
				$customer->save();
			} else {
				$customer = Stripe_Customer::create([
					'card' => Input::get('stripeToken'),
					'email' => $user->email,
					'description' => $user->name,
				]);
				$user->{$customer_id} = $customer->id;
			}
			$charge = Stripe_Charge::create([
				'amount' => $amount,
				'currency' => 'usd',
				'customer' => $customer->id,
				'description' => 'Support the Center',
			]);
		} catch(Exception $e) {

			//customer had a problem
			return redirect()->action('PaymentController@support_index')->with('error', $e->getMessage());
		}

		//allows contact info change without password, ok
		$user->save();

		//make a record
		$donation = $user->donations()->save(new Donation([
			'amount' => $charge->amount / 100,
			'charge_id' => $charge->id,
			'notes' => Input::has('notes') ? Input::get('notes') : null,
		]));

		//send out confirmation to user
		Mail::send('emails.support', [
			'subject'=>'Thank you for your support!',
			'donation'=>$donation,
		], function($message) use ($user) {
		    $message->to($user->email, $user->name)->subject('Thank you for your support!');
		});

		//redirect user
		return redirect()->action('PaymentController@support_index')->with('message', 'Thank you for your support!');
	}

	/**
	 * Add a course session to the cart
	 */
	public function add_course($section_id) {
		
		# Get event info
		$section = Section::find($section_id);
		$course = Course::find($section->course_id);
		$course->url = CourseController::url($course);

		# Add to cart
		$courses = Session::get('cart.courses', []);
		if (!isset($courses[$section_id])) {
			$courses[$section_id] = [
				'name' =>		$course->title,
				'quantity' =>	1,
				'id' =>			$course->id,
				'url' =>		$course->url,
				'price' =>		$section->price,
			];
			Session::put('cart.courses', $courses);
		}

		# Return from whence you came (the publication page)
		return redirect()->to($course->url)->with('message', 'Course added to cart.');
	}

	public static function has_course($section_id) {
		$courses = Session::get('cart.courses', []);
		return isset($courses[$section_id]);
	}

	public static function has_membership() {
		return Session::has('cart.membership');
	}

	public function add_event($event_id) {

		# Get event info
		$event = Event::find($event_id);
		$event->url = EventController::url($event);

		# Add to cart
		$events = Session::get('cart.events', []);
		if (!isset($events[$event_id])) {
			$events[$event_id] = [
				'name' =>		$event->title,
				'quantity' =>	1,
				'id' =>			$event_id,
				'url' =>		$event->url,
				'price'=>		$event->price,
			];
			Session::put('cart.events', $events);
		}

		# Return from whence you came (the publication page)
		return redirect()->to($event->url)->with('message', 'Event ticket added to cart.');
	}

	public function add_publication($publication_id) {

		# Get publication info
		$publication = Publication::find($publication_id);
		$publication->url = PublicationController::url($publication);

		# Add to cart
		$publications = Session::get('cart.publications', []);
		if (!isset($publications[$publication_id])) {
			$publications[$publication_id] = [
				'name' =>		$publication->title,
				'quantity' =>	1,
				'id' =>			$publication_id,
				'url' =>		$publication->url,
				'price'=>		$publication->price,
			];
			Session::put('cart.publications', $publications);
		}

		# Return from whence you came (the publication page)
		return redirect()->to($publication->url)->with('message', 'Publication added to cart.');
	}
	
	public function add_membership() {
		Session::put('cart.membership', ['membership'=>[
			'name' => 'Annual Membership',
			'quantity' => 1,
			'id' => null,
			'url' => null,
			'price' => 45,
		]]);
		return redirect()->back()->with('message', 'Membership added to cart.');
	}
	
	public function remove_item($type, $id=null) {
		if ($type == 'course') {
			
		} elseif ($type == 'event') {
			
		} elseif ($type == 'publication') {
			
		} elseif ($type == 'membership') {
			
		}
		return redirect()->back()->with('message', 'Item removed from cart.');
	}

}