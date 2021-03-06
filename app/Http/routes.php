<?php
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ImageController;
use \DateTime;
use LeftRight\Center\Models\CarouselItem;
use LeftRight\Center\Models\Course;
use LeftRight\Center\Models\Event;
use LeftRight\Center\Models\Group;
use LeftRight\Center\Models\Policy;
use LeftRight\Center\Models\Post;
	
Route::group(['before' => 'public'], function()
{

	# Home
	Route::get('/', function()
	{
		//set type slugs
		$carouselItems = CarouselItem::take(7)->with('courses', 'events', 'publications', 'posts')->orderBy('precedence')->get();
		foreach ($carouselItems as &$item) {
			//dd($item);
			if (isset($item->courses)) {
				$item->type = ['Course', 'courses'];
				$item->title = link_to(CourseController::url($item->courses), $item->title);
				$item->wallpaper = ImageController::wallpaper('courses');
			} elseif (isset($item->events)) {
				$item->type = ['Event', 'events'];
				$item->title = link_to(EventController::url($item->events), $item->title);
				$item->wallpaper = ImageController::wallpaper('events');
			} elseif (isset($item->publications)) {
				$item->type = ['Publication', 'shp'];
				$item->title = link_to(PublicationController::url($item->publications), $item->title);
				$item->wallpaper = ImageController::wallpaper('shp');
			} elseif (isset($item->posts)) {
				$item->type = ['Blog', 'blog'];
				$item->title = link_to(BlogController::url($item->posts), $item->title);
				$item->wallpaper = ImageController::wallpaper('blog');
			}
		}

		return view('home', array(
			'items'				=>$carouselItems,
			'event_dates'		=>DB::table('events')->distinct()->lists(DB::raw('DATE_FORMAT(start, "%Y-%m-%d")')),
			'start'				=>strtotime('this week', time()),
			'instructor_select'	=>CourseController::getInstructorList(),
			'genre_select'		=>CourseController::getGenreList(),
			'day_select'		=>CourseController::getDayList(),
			'duration_select'	=>CourseController::getDurationList(),
		));
	});


	# Main sections
	Route::get('/about/{slug?}',				'AboutController@show');
	Route::get('/courses', 						'CourseController@index');
	Route::get('/courses/ajax', 				'CourseController@ajax');
	Route::get('/courses/{slug}',				'CourseController@show');
	Route::get('/events',						'EventController@index');
	Route::get('/events/ajax',					'EventController@ajax');
	Route::get('/events/{slug}',				'EventController@show');
	Route::get('/blog',							'BlogController@index');
	Route::get('/blog/ajax', 					'BlogController@ajax');
	Route::get('/blog/{slug}', 					'BlogController@show');
	Route::get('/shp',							'PublicationController@index');
	Route::get('/shp/ajax', 					'PublicationController@ajax');
	Route::get('/shp/{slug}', 					'PublicationController@show');

	# Contact
	Route::get('/contact', function(){
		return view('contact', ['title'=>'Contact', 'type'=>'place']);
	});

	# Support the Center
	Route::get('/support',						'PaymentController@support_index');
	Route::post('/support', 					'PaymentController@support_submit');

	# Newsletter
	Route::get('/newsletter', function(){
		return view('newsletter', ['title'=>'Newsletter']);
	});

	# Robots
	Route::get('/robots.txt', function(){
		return response()->view('robots')->header('Content-Type', 'text/plain');
	});

	if (!App::environment('production')) {
		Route::group(['prefix'=>'cart'], function(){
			Route::get('/add/course/{id}',			'PaymentController@add_course');
			Route::get('/add/event/{id}',			'PaymentController@add_event');
			Route::get('/add/publication/{id}',		'PaymentController@add_publication');
			Route::get('/add/membership',			'PaymentController@add_membership');
			Route::get('/remove/{type}/{id?}',		'PaymentController@remove_item');
		});

		Route::get('/checkout',						'PaymentController@checkout_index');
		Route::post('/checkout',					'PaymentController@checkout_submit');

		# My HVWC and all associated login stuff
		Route::group(['prefix'=>'my-hvwc'], function(){

			//Route::get('/', 'MyController@index');
			Route::get('settings',		'MyController@settings');
				Route::post('settings', 	'MyController@saveSettings');

				Route::post('login',		'MyController@login');
				Route::post('reset',		'MyController@reset');
				Route::get('logout',		'MyController@logout');
				//Route::post('message',		'MyController@message');
				//Route::post('{message_id}',	'MyController@reply');
				//Route::get('{message_id}',	'MyController@show');

		});
	}

});

# Inbound email routes
Route::group(array('prefix'=>'inbound'), function(){
	//Route::any('everyone', 'MyController@inbound_everyone');
	//Route::any('admin', 'MyController@inbound_admin');
	//Route::any('reply', 'MyController@inbound_reply');
});

# Testing routes

Route::group(['before' => 'auth', 'prefix'=>'test'], function()
{

	Route::get('import', function(){
		$emails = DB::table('users')->lists('email');
		$contacts = DB::table('output')->whereNotNull('email')->get();
		$inserts = [];
		foreach ($contacts as $contact) {

			$contact->name = trim(ucwords($contact->name));
			$contact->address = trim(ucwords($contact->address));
			$contact->city = trim(ucwords($contact->city));
			$contact->state = trim(strtoupper($contact->state));
			$contact->email = trim(strtolower($contact->email));
			$contact->phone = trim($contact->phone);
			if (strlen($contact->phone) == 7) $contact->phone = '914' . $contact->phone;

			if (in_array($contact->email, $emails)) {
				DB::table('users')->where('email', $contact->email)->update([
					'name' => $contact->name,
					'address' => $contact->address,
					'city' => $contact->city,
					'state' => $contact->state,
					'zip' => $contact->zip,
					'phone' => $contact->phone,
					'membership_expires' => $contact->membership_expires,
					'updated_at' => new DateTime,
					'updated_by' => Auth::id(),
				]);
			} else {
				$inserts[] = [
					'name' => $contact->name,
					'email' => $contact->email,
					'address' => $contact->address,
					'city' => $contact->city,
					'state' => $contact->state,
					'zip' => $contact->zip,
					'phone' => $contact->phone,
					'membership_expires' => $contact->membership_expires,				
					'updated_at' => new DateTime,
					'updated_by' => Auth::id(),
				];
				$emails[] = $contact->email;
			}
		}
		DB::table('users')->insert($inserts);
	});

	Route::get('cart', function(){
		//clear cart
		Session::forget('cart');
		return 'cleared';
	});

	Route::get('environment', function(){
		return App::environment();
	});

	Route::get('error', function(){
		trigger_error('Test error');
	});

	Route::get('notifications', function(){
		Session::flash('error', 'Test error!!!');
		//Session::flash('message', 'Test message.');
		return view('page');
	});
	
	Route::get('permissions', function(){
		$tables = config('center.tables');
		$users = DB::table('users')->whereNull('deleted_at')->whereNotNull('role')->lists('id');
		DB::table('permissions')->truncate();
		foreach ($tables as $table) {
			$level = $table->editable ? 'edit' : 'view';
			$table = $table->name;
			$inserts = [];
			foreach ($users as $user_id) $inserts[] = compact('user_id', 'table', 'level');
			DB::table('permissions')->insert($inserts);
		}
	});

	# Email formatting routes
	Route::group(array('prefix'=>'email'), function(){

		# Support Us email
		Route::get('support', function(){
			$transaction = new Transaction;
			$transaction->amount = 100000;
			$transaction->confirmation = 'XYZ123';
			return view('emails.support', [
				'transaction'=>$transaction,
				'subject'=>'Thank you for your support!',
			]);
		});

		# Notify email
		Route::get('notify', function(){
			$transaction = new Transaction;
			$transaction->amount = 100000;
			$transaction->confirmation = 'XYZ123';
			return view('emails.notify', [
				'transaction'=>$transaction,
				'subject'=>'Website Transaction',
				'type'=>'Support the Center',
				'user_name'=>Auth::user()->name,
			]);
		});

		# Support Us email
		Route::get('receipt', function(){
			$transaction = new Transaction;
			$transaction->amount = 100000;
			$transaction->confirmation = 'XYZ123';
			return view('emails.receipt', [
				'transaction'=>$transaction,
				'subject'=>'Thank you for your support!',
			]);
		});
	});


});


# Template variables
View::composer('template', function($view)
{

	//if (Session::has('cart')) Session::put('cart', []);

	//define sections (the keys must match the SASS keys)
	$sections = [
		'about'=>'About',
		'courses'=>'Courses',
		'events'=>'Events',
		'blog'=>'Blog',
		'shp'=>'Slapering Hol Press',
		'contact'=>'Contact',
	];

	//body class
	$body_class = null;
	if (Request::is('/')) {
		$body_class = 'home';	
	} elseif (Request::is('checkout')) {
		$body_class = 'checkout';	
	} else {
		foreach ($sections as $section=>$name) {
			if (Request::is($section . '*')) {
				$body_class = $section;
			}
		}
	}

	$view->with('sections', $sections)->with('body_class', $body_class);
});


# About > Who We Are Page
View::composer('about.who-we-are', function($view){
	$view->with('groups', Group::with(array('roles'=>function($query){
			$query->orderBy('precedence');
		}))->orderBy('precedence')->get());
});

# About > Policies Page
View::composer('about.policies', function($view){
	$view->with('policies', Policy::orderBy('precedence')->get());
});

# Publication sidebar (masthead, blog & upcoming events)
View::composer('publications.side', function($view){
	$view->with('groups', Group::with(['roles'=>function($query){
			$query->orderBy('precedence');
		}])->where('shp', 1)->orderBy('precedence')->get());

	$view->with('events', Event::whereHas('tags', function($query){
			$query->where('id', 1);
		})->where('end', '>', new DateTime())->orderBy('start', 'asc')->get());

	$view->with('post', Post::whereHas('tags', function($query){
			$query->where('id', 1);
		})->orderBy('publish_date', 'desc')->first());
});

View::composer(['emails.support', 'emails.error', 'emails.receipt', 'emails.notify', 'emails.simple'], function($view){
	$view->with('green', '#298c76');
	$view->with('light_green', '#b3d2b6');
	$view->with('lighter_green', '#c6eee5');
});

View::composer(['partials.payment', 'my.settings'], function($view){
	$view->with('states', [
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
	]);
});


# Form macros for styled controls in switchboards

Form::macro('dropdown', function($name, $list=array(), $selected=null, $default='Any')
{
	$selected_value = $default;
	$options = array();
	foreach ($list as $id=>$value) {
		if (empty($value)) $value = '&nbsp;';
		if ($selected == $id) {
			$selected_value = $value;
			$options[] = '<li class="active"><a data-id="' . $id . '">' . $value . '</a></li>';
		} else {
			$options[] = '<li><a data-id="' . $id . '">' . $value . '</a></li>';
		}
	}
	$options = (count($options)) ? '<ul class="dropdown-menu">
		<li' . ($selected == null ? ' class="active"' : '') . '><a data-id="">' . $default . '</a></li>
		<li class="divider"></li>
		' . implode($options) . 
		'</ul>' : '';
    return '
		<div class="btn-group dropdown" data-name="' . $name . '">
			<input type="hidden" name="' . $name . '" value="' . $selected . '">
			<button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
				<span class="selected">' . $selected_value . '</span>
				<span class="caret"></span>
			</button>
			' . $options . '
		</div>
	';
});

Form::macro('chkbox', function($name, $value)
{
	return '<div class="chkbox">' .
			Form::checkbox($name, $value) . 
			'<i class="fa fa-times"></i>
		</div>';
});