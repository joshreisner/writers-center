<?php

class EventController extends BaseController {

	/**
	 * show upcoming events
	 */
	public function index() {

		# Build array of months
		if (Input::has('date')) {
			list($year, $month, $day) = explode('-', Input::get('date'));
			$events = Event::whereRaw('MONTH(start) = ?', array($month))
						->whereRaw('DAY(start) = ?', array($day))
						->whereRaw('YEAR(start) = ?', array($year))->get();
		} else {
			$events = Event::where('end', '>', new DateTime())->orderBy('start', 'asc')->get();
		}

		return View::make('events.index', array(
			'title'=>'Events',
			'years'=>Event::orderBy('start', 'desc')->distinct()->lists(DB::raw('YEAR(start)'), DB::raw('YEAR(start)')),
			'months'=>self::groupByMonth($events),
			'class'=>'events',
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

		//404
		if (!$event) return Redirect::action('EventController@index');

		return View::make('events.event', array(
			'title'=>$event->title,
			'event'=>$event,
			'next'=>Event::orderBy('start', 'desc')->first(),
			'class'=>'events',
		));
	}

	/**
	 * ajax
	 */
	function ajax() {

		# Construct chained Eloquent statement based on input
		$events = Event::orderBy('start', 'asc');
		if (Input::has('search') or Input::has('year')) {

			if (Input::has('search')) {
				$events
					->where('title', 'like', '%' . Input::get('search') . '%')
					->orWhere('description', 'like', '%' . Input::get('search') . '%');
			}
			
			if (Input::has('year')) {
				$events->where(DB::raw('YEAR(start)'), Input::get('year'));
			}			
		} else {
			$events->where('end', '>', new DateTime());
		}

		$events = $events->get();

		# Highlight search terms
		$events = BaseController::highlightResults($events, array('title', 'description'));

		# Return HTML view
		return View::make('events.events', array('months'=>self::groupByMonth($events)));
	}

	private function groupByMonth($events) {
		$months = array();
		foreach ($events as $event) {
			$month = $event->start->format('F Y');
			if (!isset($months[$month])) $months[$month] = array();
			$months[$month][] = $event;
		}
		return $months;		
	}

}