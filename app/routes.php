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


# Contact

Route::get('/contact', function()
{
	return View::make('contact', array(
		'title'=>'Contact',
		'class'=>'contact',
	));
});


# Support

Route::get('/support', function()
{
	return View::make('support', array(
		'title'=>'Support the Center',
		'states'=>array(
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
			'WI'=>'Wisconsin',  'WY'=>'Wyoming')
		)
	);
});


# Testing routes
Route::group(array('before' => 'auth', 'prefix'=>'test'), function()
{

	Route::get('error', function() 
	{
		trigger_error('Test error');
	});

	Route::get('mail', function() 
	{

		Mail::send('emails.welcome', [], function($message)
		{
		    $message->to('josh@joshreisner.com', 'Josh Reisner')->subject('Email Test');
		});

		return 'Test email sent!';
	});

	Route::get('mutators', function() 
	{
		$days = Day::first();
		echo $days->updated_at->format('n/j/Y');
	});


});



# Global variables

View::composer('template', function($view)
{
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