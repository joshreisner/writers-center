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
		return 'stripeToken was ' . Input::get('stripeToken');
		return Redirect::action('SupportController@index')->with(['message'=>'Thank you for your support!']);
	}
}