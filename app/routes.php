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
				$item->title = link_to(CourseController::url($item->courses), $item->title);
			} elseif (isset($item->events)) {
				$item->type = 'events';
				$item->title = link_to(EventController::url($item->events), $item->title);
			} elseif (isset($item->publications)) {
				$item->type = 'publications';
				$item->title = link_to(PublicationController::url($item->publications), $item->title);
			} elseif (isset($item->posts)) {
				$item->type = 'posts';
				$item->title = link_to(BlogController::url($item->posts), $item->title);
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
			Route::get('/add/event/{id}',			'PaymentController@add_event');
			Route::get('/add/publication/{id}',		'PaymentController@add_publication');
		});

		Route::get('/checkout',						'PaymentController@checkout_index');
		Route::post('/checkout',					'PaymentController@checkout_submit');
	}

});

# Store routes
Route::group(array('before' => 'auth', 'prefix'=>'store'), function()
{
	Route::get('transactions', 'PaymentController@transactions');
	Route::get('transactions/export', 'PaymentController@export');
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

# About Who We Are Page
View::composer('about.who', function($view){
	$view->with('groups', Group::with(array('roles'=>function($query){
			$query->orderBy('precedence');
		}))->orderBy('precedence')->get());
});

# Publication sidebar (masthead, blog & upcoming events)
View::composer('publications.side', function($view){
	$view->with('groups', Group::with(array('roles'=>function($query){
			$query->orderBy('precedence');
		}))->where('shp', 1)->orderBy('precedence')->get());

	$view->with('events', Event::whereHas('tags', function($query){
			$query->where('id', 1);
		})->where('end', '>', new DateTime())->orderBy('start', 'asc')->get());

	$view->with('post', Post::whereHas('tags', function($query){
			$query->where('id', 1);
		})->orderBy('publish_date', 'desc')->first());
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