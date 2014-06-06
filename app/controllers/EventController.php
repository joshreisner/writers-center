<?php

class EventController extends BaseController {

	/**
	 * show upcoming events
	 */
	public function index() {

		# Build array of months
		$events = Event::where('end', '>', new DateTime())->orderBy('start', 'asc')->get();

		return View::make('events.index', array(
			'title'=>'Events',
			'years'=>array(2014, 2013, 2012, 2011, 2010, 2009, 2008, 2007, 2006),
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

		if (Input::has('search')) {
			$events
				->where('title', 'like', '%' . Input::get('search') . '%')
				->orWhere('description', 'like', '%' . Input::get('search') . '%');
		}
		
		if (Input::has('year')) {
			$events->where(DB::raw('YEAR(start)'), Input::get('year'));
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

	/**
	 * format price
	 */
	public static function formatPrice(Event $event) {
		if ($event->price === null) return 'Ticket price TBD';
		if ($event->price === 0) return 'Free!';
		return '$' . number_format($event->price);
	}

}