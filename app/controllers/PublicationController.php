<?php

class PublicationController extends BaseController {
	
	/**
	 * show home page
	 */
	function index() {
		# Set publication URLs
		$publications = Publication::orderBy('publish_date', 'desc')->get();
		foreach ($publications as $publication) {
			$publication->url = self::url($publication);
		}

		# Getting latest SHP blog post
		$post = Post::whereHas('tags', function($query){
			$query->where('id', 1);
		})->orderBy('publish_date', 'desc')->first();

		return View::make('publications.index', array(
			'title'=>'Slapering Hol Press',
			'post'=>$post,
			'publications'=>$publications,
			'years'=>Publication::orderBy('publish_date', 'desc')->distinct()->lists(DB::raw('YEAR(publish_date)'), DB::raw('YEAR(publish_date)')),
			'types'=>PublicationType::orderBy('title')->lists('title', 'id'),
			'class'=>'publications',
		));		
	}

	/**
	 * show individual publication page
	 */
	function show($slug) {
		$publication = Publication::where('slug', $slug)->first();

		//404
		if (!$publication) return Redirect::action('PublicationController@index');

		return View::make('publications.publication', array(
			'title'=>strip_tags($publication->title),
			'types'=>PublicationType::orderBy('title')->get(),
			'publication'=>$publication,
			'class'=>'publications',
			'related'=>Publication::where('id', '<>', $publication->id)->orderBy('precedence')->take(5)->get(),
		));
	}

	/**
	 * Get a URL to the show() method
	 */
	public static function url(Publication $publication) {
		return URL::action('PublicationController@show', $publication->slug);
	}

	/**
	 * ajax
	 */
	function ajax() {

		# Construct chained Eloquent statement based on input
		$publications = Publication::orderBy('publish_date', 'desc');

		if (Input::has('search')) {
			$publications
				->where('title', 'like', '%' . Input::get('search') . '%')
				->orWhere('description', 'like', '%' . Input::get('search') . '%');
		}
		
		if (Input::has('year')) {
			$publications->where(DB::raw('YEAR(publish_date)'), Input::get('year'));
		}

		if (Input::has('type_id')) {
			$publications->where('type_id', Input::get('type_id'));
		}

		$publications = $publications->get();

		# Set publication URLs
		foreach ($publications as $publication) {
			$publication->url = self::url($publication);
		}

		# Return HTML view
		return View::make('publications.publications', array('publications'=>$publications));
	}

}