<?php

class PaymentController extends BaseController {

	private $states = [
				'AL'=>'Alabama',  'AK'=>'Alaska',  'AZ'=>'Arizona',  'AR'=>'Arkansas',  
				'CA'=>'California',  'CO'=>'Colorado',  'CT'=>'Connecticut',  'DE'=>'Delaware',  
				'DC'=>'District Of Columbia',  'FL'=>'Florida',  'GA'=>'Georgia',  'HI'=>'Hawaii',  
				'ID'=>'Idaho',  'IL'=>'Illinois',  'IN'=>'Indiana',  'IA'=>'Iowa',  'KS'=>'Kansas',  
				'KY'=>'Kentucky',  'LA'=>'Louisiana',  'ME'=>'Maine',  'MD'=>'Maryland',  
				'MA'=>'Massachusetts',  'MI'=>'Michigan',  'MN'=>'Minnesota',  'MS'=>'Mississippi',  
				'MO'=>'Missouri',  'MT'=>'Montana',	'NE'=>'Nebraska','NV'=>'Nevada',
				'NH'=>'New Hampshire',	'NJ'=>'New Jersey',	'NM'=>'New Mexico',	'NY'=>'New York',
				'NC'=>'North Carolina',	'ND'=>'North Dakota',	'OH'=>'Ohio',  'OK'=>'Oklahoma',  
				'OR'=>'Oregon',  'PA'=>'Pennsylvania',  'RI'=>'Rhode Island',  'SC'=>'South Carolina',  
				'SD'=>'South Dakota',	'TN'=>'Tennessee',  'TX'=>'Texas',  'UT'=>'Utah',  
				'VT'=>'Vermont',  'VA'=>'Virginia',  'WA'=>'Washington',  'WV'=>'West Virginia',  
				'WI'=>'Wisconsin',  'WY'=>'Wyoming'
			];
	/**
	 * show checkout page
	 */
	public function checkout_index() {
		return View::make('checkout')->with('class', 'checkout');
	}

	/**
	 * handle checkout form submit
	 */
	public function checkout_submit() {
		return View::make('checkout');
	}

	/**
	 * show support page
	 */
	public function support_index() {
		return View::make('support')->with('preset_amounts', [25, 50, 100, 200, 500]);
	}

	/**
	 * handle support form submit
	 */
	public function support_submit() {

		//validate form
		$validator = Validator::make(
			Input::all(),
			array(
				'name' => 'required',
				'amount' => 'required|numeric',
				'email' => 'required|email'
			)
		);

		if ($validator->fails()) {
			return Redirect::action('PaymentController@support_index')
				->withInput()
				->withErrors($validator)
				->with('error', 'The form did not go through!');
		}

		//init
		Stripe::setApiKey(Config::get('services.stripe.secret'));

		//stripe records amounts as integer
		$amount = Input::get('amount') * 100; 

		//create or get user
		if (Auth::user()) {
			$user = Auth::user();
		} else {
			//create user (but don't log in)
			$user = User::firstOrNew(['email' => Input::get('email')]);
			$user->name = Input::get('name');
			$user->password = Hash::make(str_random(12)); //better than null?
			$user->save();
		}

		//create or get customer
		try {

			if ($user->customer_id) {
				$customer = Stripe_Customer::retrieve($user->customer_id);
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
				$user->customer_id = $customer->id;
				$user->save();
			}

		} catch(Stripe_InvalidRequestError $e) {
			$body = $e->getJsonBody();
			//card was declined
			return Redirect::action('PaymentController@support_index')->with('error', $body['error']['message']);
		}

		//charge card
		try {

			$charge = Stripe_Charge::create([
				'amount' => $amount,
				'currency' => 'usd',
				'customer' => $customer->id,
				'description' => 'Support the Center',
			]);

		} catch(Stripe_CardError $e) {

			//card was declined
			return Redirect::action('PaymentController@support_index')->with('error', 'Credit card was declined.');
		}

		//make a record
		$transaction = $user->transactions()->save(new Transaction([
			'amount' => $amount,
			'charge_id' => $charge->id,
			'paid' => $charge->paid,
			'confirmation'=>strtoupper(str_random(6)),
		]));

		//send out confirmation
		Mail::send('emails.support', [
			'subject'=>'Thank you for your support!',
			'transaction'=>$transaction,
		], function($message) use ($user) {
		    $message->to($user->email, $user->name)->subject('Thank you for your support!');
		});

		//redirect user
		return Redirect::action('PaymentController@support_index')->with('message', 'Thank you for your support!');
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
			];
			Session::put('cart.courses', $courses);
		}

		# Return from whence you came (the publication page)
		return Redirect::to($course->url)->with('message', 'Course added to cart.');
	}

	public function remove_course($course_id) {
		
		# Remove from cart
		$courses = Session::get('cart.courses', []);
		unset($courses[$course_id]);
		Session::put('cart.courses', $courses);

		# Return from whence you came (the checkout page)
		return Redirect::action('PaymentController@checkout_index')->with('message', 'Cart updated.');
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
			];
			Session::put('cart.events', $events);
		}

		# Return from whence you came (the publication page)
		return Redirect::to($event->url)->with('message', 'Event ticket added to cart.');
	}

	public function remove_event($event_id) {

		# Remove from cart
		$events = Session::get('cart.events', []);
		unset($events[$event_id]);
		Session::put('cart.events', $events);

		# Return from whence you came (the checkout page)
		return Redirect::action('PaymentController@checkout_index')->with('message', 'Cart updated.');
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
			];
			Session::put('cart.publications', $publications);
		}

		# Return from whence you came (the publication page)
		return Redirect::to($publication->url)->with('message', 'Publication added to cart.');
	}

	public function remove_publication($publication_id) {
		
		# Remove from cart
		$publications = Session::get('cart.publications', []);
		unset($publications[$publication_id]);
		Session::put('cart.publications', $publications);

		# Return from whence you came (the checkout page)
		return Redirect::action('PaymentController@checkout_index')->with('message', 'Cart updated.');
	}

}