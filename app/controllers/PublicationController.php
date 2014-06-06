<?php

class PublicationController extends BaseController {
	
	/**
	 * show home page
	 */
	function index() {
		return View::make('publications.index', array(
			'title'=>'Publications',
			'publications'=>Publication::orderBy('precedence')->get(),
			'years'=>Publication::orderBy('year', 'desc')->distinct()->lists('year', 'year'),
			'types'=>PublicationType::orderBy('title')->lists('title', 'id'),
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
	 * ajax
	 */
	function ajax() {

		# Construct chained Eloquent statement based on input
		$publications = Publication::orderBy('year', 'desc');

		if (Input::has('search')) {
			$publications
				->where('title', 'like', '%' . Input::get('search') . '%')
				->orWhere('description', 'like', '%' . Input::get('search') . '%');
		}
		
		if (Input::has('year')) {
			$publications->where('year', Input::get('year'));
		}

		if (Input::has('type_id')) {
			$publications->where('type_id', Input::get('type_id'));
		}

		$publications = $publications->get();

		# Return HTML view
		return View::make('publications.publications', array('publications'=>$publications));
	}

}