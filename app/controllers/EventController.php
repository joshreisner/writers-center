<?php

class EventController extends BaseController {

	/**
	 * show upcoming events
	 */
	public function index() {
		$events = Event::where('end', '>', new DateTime())->orderBy('start', 'asc')->get();
		foreach ($events as $event) {
			$event->month = $event->start->format('F Y');
		}
		return View::make('events.index', array(
			'title'=>'Events',
			'years'=>array(2014, 2013, 2012, 2011, 2010, 2009, 2008, 2007, 2006),
			'events'=>$events,
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
			'years'=>array(2014, 2013, 2012, 2011, 2010, 2009, 2008, 2007, 2006),
			'event'=>$event,
			'class'=>'events',
		));
	}

	/**
	 * format price
	 */
	public static function formatPrice(Event $event) {
		if ($event->price === null) return 'Ticket price TBD';
		if ($event->price === 0) return 'Free!';
		return '$' . number_format($event->price);
	}

	/**
	 * generate avalon link
	 */
	public static function editLink(Event $event) {
		if (!Auth::user()) return false;
		return link_to(URL::action('InstanceController@edit', array(12, $event->id)) . '?return_to=' . urlencode(Url::current()), '', array('class'=>'edit dashicons dashicons-welcome-write-blog'));
	}

}