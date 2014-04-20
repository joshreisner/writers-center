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
		'promos'=>Promo::take(3)->orderBy('precedence')->get(),
	));
});

Route::group(array('prefix' => 'about'), function()
{
	//only only get subnav pages if url pattern matches
	if (Request::is('about*')) {
		$subnav = array();
		$pages = Page::orderBy('precedence')->get();
		foreach ($pages as $page) {
			$subnav['about' . (empty($page->slug) ? '' : '/' . $page->slug)] = $page->title;

			Route::get($page->slug, function() use ($page)
			{
				return View::make('about', array(
					'title'=>$page->title,
					'content'=>$page->content,
				));
			});
		}

		View::composer('subnav', function($view) use ($subnav)
		{
		    $view->with('pages', $subnav)
		    ->with('app_title', 'Hudson Valley Writers Center');
		});
	}
});


Route::get('/courses', function()
{
	return View::make('courses', array(
		'title'=>'Courses',
		'genres'=>Genre::with('courses')->get(),
		'days'=>Day::get(),
	));
});

Route::get('/events', function()
{
	return View::make('events', array(
		'title'=>'Events',
		'years'=>array(2014, 2013, 2012, 2011, 2010, 2009, 2008, 2007, 2006),
		'events'=>Event::get(),
	));
});

Route::get('/blog', function()
{
	return View::make('blog', array(
		'title'=>'Blog',
		'years'=>array(2014, 2013, 2012, 2011, 2010, 2009, 2008, 2007, 2006),
		'posts'=>Post::get(),
	));
});

Route::get('/publications', function()
{
	return View::make('publications', array(
		'title'=>'Publications',
		'products'=>Product::get(),
	));
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