<?php

//home
Route::get('/', function()
{
	//set type slugs
	$carouselItems = CarouselItem::with('carousel_types')->take(7)->orderBy('precedence')->get();
	foreach ($carouselItems as &$item) $item->type = Str::slug($item->carousel_types->title);

	return View::make('home', array(
		'items'=>$carouselItems,
	));
});

//about section
Route::get('/about/{slug?}', function($slug='')
{
	if (empty($slug)) {
		$page = Page::whereNull('slug')->first();
	} else {
		$page = Page::where('slug', $slug)->first();
	}
	return View::make('about', array(
		'title'=>$page->title,
		'page'=>$page,
		'pages'=>Page::orderBy('precedence')->get(),
	));
});

//complex sections
Route::get('/courses', 						'CourseController@index');
Route::get('/courses/{slug}',				'CourseController@show');
Route::get('/events',						'EventController@index');
Route::get('/events/{year}/{month}/{slug}',	'EventController@show');
Route::get('/blog',							'BlogController@index');
Route::get('/blog/{slug}', 					'BlogController@show');
Route::get('/publications',					'PublicationController@index');
Route::get('/publications/{slug}', 			'PublicationController@show');

//contact
Route::get('/contact', function()
{
	return View::make('contact')->with('title', 'Contact');
});

//support
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

//global vars
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
    ->with('app_title', 'Hudson Valley Writers Center');
});