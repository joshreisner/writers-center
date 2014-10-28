<?php

class PaymentController extends BaseController {

	private static $states = [
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

	private static $types = [
		'publication' => 'Book Purchase',
		'course' =>	'Course Tuition',
		'event' => 'Event Registration',
		'support' => 'Support the Center',
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
		return View::make('support')->with('preset_amounts', [50, 100, 200, 500, 1000]);
	}

	/**
	 * handle support form submit
	 */
	public function support_submit() {

		//validate form
		$validator = Validator::make(
			Input::all(),
			[
				'name' => 'required',
				'amount' => 'required|numeric',
				'email' => 'required|email'
			]
		);

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
			'type' => 'support',
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
				'price' =>		$section->non_member_tuition,
			];
			Session::put('cart.courses', $courses);
		}

		# Return from whence you came (the publication page)
		return Redirect::to($course->url)->with('message', 'Course added to cart.');
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

	/**
	 * page to display transactions for Scott
	 */
	public function transactions() {
		$transactions = Transaction::with('user')->orderBy('created_at', 'desc');

		if (Input::has('month')) {
			$transactions->whereRaw('MONTH(created_at) = ? AND YEAR(created_at) = ?', explode('-', Input::get('month')));
		}

		if (Input::has('type')) {
			$transactions->where('type', Input::get('type'));
		}

		$transactions = $transactions->get();

		return View::make('transactions')->with([
			'types'=>self::$types,
			'months'=>Transaction::orderBy('created_at', 'desc')->distinct()->lists(DB::raw('CONCAT_WS(" ", MONTHNAME(created_at), YEAR(created_at))'), DB::raw('CONCAT_WS("-", MONTH(created_at), YEAR(created_at))')),
			'transactions'=>$transactions,
		]);
	}

	/**
	 * export transactions
	 */
	public function export() {
		Excel::create('Transactions', function($excel) {

		    $excel->setTitle('Transactions Export')
				->setCreator('Website')
				->setCompany('Hudson Valley Writers Center')
				->setDescription('Generated from the website')
				->sheet('Transactions', function($sheet) {

					//format columns
					$sheet->setColumnFormat(array(
						'E' => '0.00',
					));

					//load data into the sheet
					$data = [];
					$transactions = Transaction::with('user')->orderBy('created_at', 'desc')->get();
					foreach ($transactions as $transaction) {
						$data[] = [
							'DateTime'=>$transaction->created_at->format('m-d-Y g:i a'),
							'User'=>$transaction->user->name,
							'Email'=>$transaction->user->email,
							'Type'=>'Donation',
							'Amount'=>$transaction->amount / 100,
							'Confirmation'=>$transaction->confirmation,
						];
					}
					$sheet->with($data);

					//format header
					$sheet->freezeFirstRow();
					$sheet->cells('A1:F1', function($cells) {
						$cells->setFontWeight('bold');
					});

				});

		})->download('xlsx');
	}
}