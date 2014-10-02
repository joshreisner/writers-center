<?php

Route::group(array('before' => 'public'), function()
{

	# Home
	Route::get('/', function()
	{
		//set type slugs
		$carouselItems = CarouselItem::take(7)->with('courses', 'events', 'publications', 'posts')->orderBy('precedence')->get();
		foreach ($carouselItems as &$item) {
			//dd($item);
			if (isset($item->courses)) {
				$item->type = 'courses';
				$item->title = link_to('/courses/' . $item->courses->slug, $item->title);
			} elseif (isset($item->events)) {
				$item->type = 'events';
				$item->title = link_to('/events/' . $item->events->start->format('Y/m/') . $item->events->slug, $item->title);
			} elseif (isset($item->publications)) {
				$item->type = 'publications';
				$item->title = link_to('/publications/' . $item->publications->slug, $item->title);
			} elseif (isset($item->posts)) {
				$item->type = 'posts';
				$item->title = link_to('/posts/' . $item->posts->slug, $item->title);
			}
		}

		return View::make('home', array(
			'items'				=>$carouselItems,
			'class'				=>'home',
			'event_dates'		=>DB::table('events')->distinct()->lists(DB::raw('DATE_FORMAT(start, "%Y-%m-%d")')),
			'start'				=>strtotime('this week', time()),
			'instructor_select'	=>CourseController::getInstructorList(),
			'genre_select'		=>CourseController::getGenreList(),
			'day_select'		=>CourseController::getDayList(),
			'duration_select'	=>CourseController::getDurationList(),
		));
	});


	# Main sections

	Route::get('/about', 						'AboutController@index');
	Route::get('/about/{slug}',					'AboutController@show');
	Route::get('/courses', 						'CourseController@index');
	Route::get('/courses/ajax', 				'CourseController@ajax');
	Route::get('/courses/{slug}',				'CourseController@show');
	Route::get('/events',						'EventController@index');
	Route::get('/events/ajax',					'EventController@ajax');
	Route::get('/events/{year}/{month}/{slug}',	'EventController@show');
	Route::get('/blog',							'BlogController@index');
	Route::get('/blog/ajax', 					'BlogController@ajax');
	Route::get('/blog/{slug}', 					'BlogController@show');
	Route::get('/shp',							'PublicationController@index');
	Route::get('/shp/ajax', 					'PublicationController@ajax');
	Route::get('/shp/{slug}', 					'PublicationController@show');

	# Contact
	Route::get('/contact', function()
	{
		return View::make('contact', array(
			'title'=>'Contact',
			'class'=>'contact',
		));
	});


	if (!App::environment('production')) {
		Route::get('/support',						'PaymentController@support_index');
		Route::post('/support', 					'PaymentController@support_submit');

		Route::group(array('prefix'=>'cart'), function(){
			Route::get('/add/course/{id}',			'PaymentController@add_course');
			Route::get('/remove/course/{id}',		'PaymentController@remove_course');
			Route::get('/add/event/{id}',			'PaymentController@add_event');
			Route::get('/remove/event/{id}',		'PaymentController@remove_event');
			Route::get('/add/publication/{id}',		'PaymentController@add_publication');
			Route::get('/remove/publication/{id}',	'PaymentController@remove_publication');
		});

		Route::get('/checkout',						'PaymentController@checkout_index');
		Route::post('/checkout',					'PaymentController@checkout_submit');
	}

});

# Testing routes

Route::group(array('before' => 'auth', 'prefix'=>'test'), function()
{

	Route::get('cart', function(){
		//clear cart
		Session::forget('cart');
		return 'cleared';
	});

	Route::get('environment', function(){
		return  App::environment();
	});

	Route::get('error', function(){
		trigger_error('Test error');
	});

	Route::get('notifications', function(){
		Session::flash('error', 'Test error!!!');
		//Session::flash('message', 'Test message.');
		return View::make('page');
	});

	# Email formatting routes
	Route::group(array('prefix'=>'email'), function(){

		# Support Us email
		Route::get('support', function(){
			$transaction = new Transaction;
			$transaction->amount = 100000;
			$transaction->confirmation = 'XYZ123';
			return View::make('emails.support', [
				'transaction'=>$transaction,
				'subject'=>'Thank you for your support!',
			]);
		});

		# Support Us email
		Route::get('receipt', function(){
			$transaction = new Transaction;
			$transaction->amount = 100000;
			$transaction->confirmation = 'XYZ123';
			return View::make('emails.receipt', [
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

    $view->with('sections', array(
    	'about'=>'About',
    	'courses'=>'Courses',
    	'events'=>'Events',
    	'blog'=>'Blog',
    	'shp'=>'Slapering Hol Press',
    	'contact'=>'Contact',
    ))
    ->with('default_title', 'Hudson Valley Writers Center');
});

# Wallpapers
View::composer(['about.page', 'blog.post', 'checkout', 'contact', 'courses.index', 'courses.course', 'events.event', 'publications.masthead', 'publications.publication', 'support'], function($view)
{    
	$wallpapers = [
    	'grayscale-hvwc-area-by-ronnie-levine-july2014-1.jpg',
    	'grayscale-hvwc-area-by-ronnie-levine-july2014-2.jpg',
    	'grayscale-hvwc-area-by-ronnie-levine-july2014-3.jpg',
    	'grayscale-hvwc-area-by-ronnie-levine-july2014-4-cropped.jpg',
    	'grayscale-hvwc-area-by-ronnie-levine-july2014-5.jpg',
    	'grayscale-hvwc-area-by-ronnie-levine-july2014-6.jpg',
    	'grayscale-hvwc-june13-1.jpg',
    	'grayscale-hvwc-june13-2a-full-image.jpg',
    	'grayscale-hvwc-june13-3.jpg',
    	'grayscale-hvwc-june13-4.jpg',
    	'sleepy-hollow-river-scene-by-ronnie-levine-1.jpg',
    	'sleepy-hollow-river-scene-by-ronnie-levine-2.jpg',
    	'sleepy-hollow-river-scene-by-ronnie-levine-3.jpg',
    	'sleepy-hollow-river-scene-by-ronnie-levine-4.jpg',
    	'sleepy-hollow-river-scene-by-ronnie-levine-5.jpg',
    	'sleepy-hollow-river-scene-by-ronnie-levine-6.jpg',
    	'sleepy-hollow-river-scene-by-ronnie-levine-7.jpg',
    ];

    $view->with('wallpaper', '/assets/img/wallpapers/' . $wallpapers[array_rand($wallpapers)]);
});

# About Who We Are Page
View::composer('about.who', function($view){
	$view->with('groups', Group::with(array('roles'=>function($query){
			$query->orderBy('precedence');
		}))->orderBy('precedence')->get());
});

# About Who We Are Page
View::composer('publications.masthead', function($view){
	$view->with('groups', Group::with(array('roles'=>function($query){
			$query->orderBy('precedence');
		}))->where('shp', 1)->orderBy('precedence')->get());
});

View::composer(['emails.support', 'emails.receipt'], function($view){
	$view->with('green', '#298c76');
	$view->with('light_green', '#b3d2b6');
	$view->with('lighter_green', '#c6eee5');
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
			'<i class="dashicons dashicons-no"></i>
		</div>';
});