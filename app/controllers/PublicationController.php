<?php

class PublicationController extends BaseController {
	
	/**
	 * show home page
	 */
	function index() {
		return View::make('publications.index', array(
			'title'=>'Publications',
			'publications'=>Publication::orderBy('precedence')->get(),
			'types'=>PublicationType::orderBy('title')->get(),
			'class'=>'publications',
		));		
	}

	/**
	 * show individual publication page
	 */
	function show($slug) {
		$publication = Publication::where('slug', $slug)->first();
		return View::make('publications.publication', array(
			'title'=>$publication->title,
			'publications'=>Publication::orderBy('precedence')->get(),
			'types'=>PublicationType::orderBy('title')->get(),
			'publication'=>$publication,
			'class'=>'publications',
			'related'=>Publication::where('id', '<>', $publication->id)->orderBy('precedence')->take(5)->get(),
		));
	}

	/**
	 * generate avalon link
	 */
	public static function editLink(Publication $publication) {
		if (!Auth::user()) return false;
		return link_to(URL::action('InstanceController@edit', array(5, $publication->id)) . '?return_to=' . urlencode(Url::current()), '', array('class'=>'edit dashicons dashicons-welcome-write-blog'));
	}

}