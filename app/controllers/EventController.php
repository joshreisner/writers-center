<?php

class EventController extends BaseController {

	/**
	 * show upcoming events
	 */
	public function index() {
		return View::make('events.index', array(
			'title'=>'Events',
			'years'=>array(2014, 2013, 2012, 2011, 2010, 2009, 2008, 2007, 2006),
			'events'=>Event::get(),
		));
	}

	/**
	 * show individual event
	 */
	public function show($year, $month, $slug) {
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

}