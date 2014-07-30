<?php

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
Route::get('/publications',					'PublicationController@index');
Route::get('/publications/ajax', 			'PublicationController@ajax');
Route::get('/publications/{slug}', 			'PublicationController@show');

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


# Contact

Route::get('/contact', function()
{
	return View::make('contact', array(
		'title'=>'Contact',
		'class'=>'contact',
	));
});


# Testing routes

Route::group(array('before' => 'auth', 'prefix'=>'test'), function()
{

	Route::get('cart', function(){
		//clear cart
		Session::forget('cart');
		return 'cleared';
	});

	Route::get('error', function(){
		trigger_error('Test error');
	});

	Route::get('mail', function(){

		Mail::send('emails.welcome', [], function($message)
		{
		    $message->to('josh@joshreisner.com', 'Josh Reisner')->subject('Email Test');
		});

		return 'Test email sent!';
	});

	Route::get('mutators', function(){
		$days = Day::first();
		echo $days->updated_at->format('n/j/Y');
	});

	Route::get('notifications', function(){
		Session::flash('error', 'Test error!!!');
		//Session::flash('message', 'Test message.');
		return View::make('page');
	});


});


# Global variables

View::composer('template', function($view)
{

	//if (Session::has('cart')) Session::put('cart', []);

    $view->with('sections', array(
    	'about'=>'About',
    	'courses'=>'Courses',
    	'events'=>'Events',
    	'blog'=>'Blog',
    	'publications'=>'Publications',
    	'contact'=>'Contact',
    ))
    ->with('default_title', 'Hudson Valley Writers Center');
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