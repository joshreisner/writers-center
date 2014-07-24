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
	 * show support page
	 */
	public function support_index() {
		return View::make('support');
	}

	/**
	 * handle form submit
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

	public function add_course($course_id) {
		return Redirect::action('PaymentController@checkout_index');
	}

	public function remove_course($course_id) {
		return Redirect::action('PaymentController@checkout_index');
	}

	public function add_event($event_id) {
		return Redirect::action('PaymentController@checkout_index');
	}

	public function remove_event($event_id) {
		return Redirect::action('PaymentController@checkout_index');
	}

	public function add_publication($publication_id) {
		$publication = Publication::find($publication_id);
		//return $publication->title;
		return Redirect::action('PublicationController@show', $publication->slug)->with('message', 'Publication added to cart.');
	}

	public function remove_publication($publication_id) {
		return Redirect::action('PaymentController@checkout_index');
	}

}