<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	//set type slugs
	$carouselItems = CarouselItem::with('carousel_types')->take(7)->orderBy('precedence')->get();
	foreach ($carouselItems as &$item) $item->type = Str::slug($item->carousel_types->title);

	return View::make('home', array(
		'items'=>$carouselItems,
	));
});

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

Route::get('/courses/{slug?}', function($slug='')
{
	if (empty($slug)) {
		return View::make('courses.index', array(
			'title'=>'Courses',
			'genres'=>Genre::with('courses')->get(),
			'days'=>Day::get(),
		));
	} else {
		$course = Course::where('slug', $slug)->first();
		return View::make('courses.course', array(
			'title'=>$course->title,
			'genres'=>Genre::with('courses')->get(),
			'days'=>Day::get(),
			'course'=>$course,
		));
	}
});

Route::get('/events/{year?}/{month?}/{slug?}', function($year='', $month='', $slug='')
{
	if (empty($month)) {
		return View::make('events.index', array(
			'title'=>'Events',
			'years'=>array(2014, 2013, 2012, 2011, 2010, 2009, 2008, 2007, 2006),
			'events'=>Event::get(),
		));
	} else {
		$event = Event::whereRaw('MONTH(start) = ?', array($month))
			->whereRaw('YEAR(start) = ?', array($year))
			->where('slug', $slug)
			->first();
		return View::make('events.event', array(
			'title'=>$event->title,
			'years'=>array(2014, 2013, 2012, 2011, 2010, 2009, 2008, 2007, 2006),
			'event'=>$event,
		));
	}
});

Route::get('/blog/{slug?}', function($slug='')
{
	if (empty($slug)) {
		return View::make('blog.index', array(
			'title'=>'Blog',
			'years'=>array(2014, 2013, 2012, 2011, 2010, 2009, 2008, 2007, 2006),
			'posts'=>Post::orderBy('publish_date', 'desc')->get(),
			'tags'=>Tag::orderBy('title')->get(),
		));
	} else {
		$post = Post::where('slug', $slug)->first();
		return View::make('blog.post', array(
			'title'=>$post->title,
			'years'=>array(2014, 2013, 2012, 2011, 2010, 2009, 2008, 2007, 2006),
			'post'=>$post,
			'tags'=>Tag::orderBy('title')->get(),
		));
	}
});

Route::get('/publications/{slug?}', function($slug='')
{
	if (empty($slug)) {
		return View::make('publications.index', array(
			'title'=>'Publications',
			'publications'=>Publication::orderBy('precedence')->get(),
			'types'=>PublicationType::orderBy('title')->get(),
		));
	} else {
		$publication = Publication::where('slug', $slug)->first();
		return View::make('publications.publication', array(
			'title'=>$publication->title,
			'publications'=>Publication::orderBy('precedence')->get(),
			'types'=>PublicationType::orderBy('title')->get(),
			'publication'=>$publication,
		));		
	}
});

Route::get('/contact', function()
{
	return View::make('contact')->with('title', 'Contact');
});

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