<?php

class PaymentController extends BaseController {

	/**
	 * show checkout page
	 */
	public function checkout_index() {
		return View::make('checkout')->with('class', 'checkout')->with('policies', Policy::get());
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
		return View::make('support')->with('preset_amounts', [50, 100, 200, 500, 1000]);
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
			'stripeToken' => 'required',
		]);

		if ($validator->fails()) {
			return Redirect::action('PaymentController@support_index')
				->withInput()
				->withErrors($validator)
				->with('error', 'The form did not go through. Please correct the highlighted errors before continuing.');
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
			if ($user->password === null) $user->password = Hash::make(str_random(12)); //better than null?
		}
		$user->name = Input::get('name');
		$user->address = Input::get('address');
		$user->city = Input::get('city');
		$user->state = Input::get('state');
		if (Input::has('phone')) $user->phone = Input::get('phone');
		$user->zip = Input::get('zip');
		$user->save();
		
		//stripe customer ids differ depending on which environment you're in
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
				$user->save();
			}

			$charge = Stripe_Charge::create([
				'amount' => $amount,
				'currency' => 'usd',
				'customer' => $customer->id,
				'description' => 'Support the Center',
			]);

		} catch(Exception $e) {
			$body = $e->getJsonBody();
			
			//customer had a problem
			return Redirect::action('PaymentController@support_index')->with('error', $body['error']['message']);
		}

		//make a record
		$transaction = $user->transactions()->save(new Transaction([
			'amount' => $amount,
			'charge_id' => $charge->id,
			'paid' => $charge->paid,
			'type' => 1,
			'confirmation'=>strtoupper(str_random(6)),
		]));

		//send out confirmation to user
		Mail::send('emails.support', [
			'subject'=>'Thank you for your support!',
			'transaction'=>$transaction,
		], function($message) use ($user) {
		    $message->to($user->email, $user->name)->subject('Thank you for your support!');
		});

		//send out notification to Scott
		Mail::send('emails.notify', [
			'subject'=>'Website Transaction',
			'type'=>'Support the Center',
			'transaction'=>$transaction,
			'user_name'=>$user->name,
		], function($message) use ($user) {
			if (App::environment('production')) {
				$message->to('scott@writerscenter.org', 'Scott Dievendorf')->subject('Website Transaction');
			} else {
				$message->to($user->email, $user->name)->subject('Website Transaction');				
			}
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
				'price' =>		$section->price,
			];
			Session::put('cart.courses', $courses);
		}

		# Return from whence you came (the publication page)
		return Redirect::to($course->url)->with('message', 'Course added to cart.');
	}

	public static function has_course($section_id) {
		$courses = Session::get('cart.courses', []);
		return isset($courses[$section_id]);
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
		return Redirect::to($event->url)->with('message', 'Event ticket added to cart.');
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
		return Redirect::to($publication->url)->with('message', 'Publication added to cart.');
	}

}