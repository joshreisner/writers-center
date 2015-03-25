<?php namespace App\Http\Controllers;

class AboutController extends Controller {
	
	/**
	 * about inside page
	 */
	public function show($slug='') {
		$page = Page::where('slug', $slug)->first();
		
		//404
		if (!$page) return Redirect::action('AboutController@index');
		
		return View::make('about.page', array(
			'title'=>strip_tags($page->title),
			'page'=>$page,
			'pages'=>Page::orderBy('precedence')->get(),
		));
	}

}