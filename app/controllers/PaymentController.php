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
		return View::make('checkout');
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
		return View::make('support');
	}

	/**
	 * handle support form submit
	 */
	public function support_submit() {

		//init
		Stripe::setApiKey(Config::get('services.stripe.secret'));

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
			'user'=>$user, 
			'transaction'=>$transaction,
		], function($message) use ($user) {
		    $message->to($user->email, $user->name)->subject('Thank you for your support!');
		});

		//redirect user
		return Redirect::action('PaymentController@support_index')->with('message', 'Thank you for your support!');
	}

	/**
	 * Add a course SESSION to the cart
	 */
	public function add_course($session_id) {
		
		# Get event info
		$session = AvSession::find($session_id);
		$course = Course::find($session->course_id);
		$course->url = CourseController::url($course);

		# Add to cart
		$courses = Session::get('cart.courses', []);
		if (!isset($courses[$session_id])) {
			$courses[$session_id] = [
				'name' =>		$course->title,
				'quantity' =>	1,
				'id' =>			$course->id,
				'url' =>		$course->url,
			];
		} else {
			$courses[$session_id]['quantity']++;
		}
		Session::put('cart.courses', $courses);

		# Update session quantity
		self::update_quantity();

		# Save a copy to the database if logged in

		# Return from whence you came (the publication page)
		return Redirect::to($course->url)->with('message', 'Course added to cart.');
	}

	public function remove_course($course_id) {
		
		# Remove from cart
		$courses = Session::get('cart.courses', []);
		if ($courses[$course_id]['quantity'] == 1) {
			unset($courses[$course_id]);
		} else {
			$courses[$course_id]['quantity']--;
		}
		Session::put('cart.courses', $courses);

		# Update session quantity
		self::update_quantity();

		# Update database if logged in

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
		} else {
			$events[$event_id]['quantity']++;
		}
		Session::put('cart.events', $events);

		# Update session quantity
		self::update_quantity();

		# Save a copy to the database if logged in

		# Return from whence you came (the publication page)
		return Redirect::to($event->url)->with('message', 'Event ticket added to cart.');
	}

	public function remove_event($event_id) {

		# Remove from cart
		$events = Session::get('cart.events', []);
		if ($events[$event_id]['quantity'] == 1) {
			unset($events[$event_id]);
		} else {
			$events[$event_id]['quantity']--;
		}
		Session::put('cart.events', $events);

		# Update session quantity
		self::update_quantity();

		# Update database if logged in

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
		} else {
			$publications[$publication_id]['quantity']++;
		}
		Session::put('cart.publications', $publications);

		# Update session quantity
		self::update_quantity();

		# Save a copy to the database if logged in

		# Return from whence you came (the publication page)
		return Redirect::to($publication->url)->with('message', 'Publication added to cart.');
	}

	public function remove_publication($publication_id) {
		
		# Remove from cart
		$publications = Session::get('cart.publications', []);
		if ($publications[$publication_id]['quantity'] == 1) {
			unset($publications[$publication_id]);
		} else {
			$publications[$publication_id]['quantity']--;
		}
		Session::put('cart.publications', $publications);

		# Update session quantity
		self::update_quantity();

		# Update database if logged in

		# Return from whence you came (the checkout page)
		return Redirect::action('PaymentController@checkout_index')->with('message', 'Cart updated.');
	}

	private function update_quantity() {
		$quantity = 0;
		foreach (Session::get('cart') as $type=>$items) {
			foreach ($items as $item) {
				$quantity += $item['quantity'];
			}
		}
		Session::put('quantity', $quantity);
	}

}