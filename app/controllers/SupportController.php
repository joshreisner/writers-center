<?php

class SupportController extends BaseController {

	/**
	 * show support page
	 */
	public function index() {
		return View::make('support.index', [
			'title'=>'Support the Center',
			'states'=>[
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
				'WI'=>'Wisconsin',  'WY'=>'Wyoming']
			]
		);
	}

	/**
	 * handle form submit
	 */
	public function submit() {

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
			return Redirect::action('SupportController@index')->with(['error'=>$body['error']['message']]);
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
			return Redirect::action('SupportController@index')->with(['error'=>'Credit card was declined.']);
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
		return Redirect::action('SupportController@index')->with(['message'=>'Thank you for your support!']);
	}
}