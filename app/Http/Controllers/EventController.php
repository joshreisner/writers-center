<?php namespace App\Http\Controllers;

use DateTime;
use DB;
use LeftRight\Center\Models\Event;
use Request;

class EventController extends Controller {

	/**
	 * show upcoming events
	 */
	public function index() {

		# Build array of months
		if (Request::has('date')) {
			list($year, $month, $day) = explode('-', Request::input('date'));
			$events = Event::whereRaw('MONTH(start) = ?', array($month))
						->whereRaw('DAY(start) = ?', array($day))
						->whereRaw('YEAR(start) = ?', array($year))->get();
		} else {
			$events = Event::where('end', '>', new DateTime())->orderBy('start', 'asc')->get();
		}

		return view('events.index', array(
			'title'=>'Events',
			'years'=>Event::orderBy('start', 'desc')->select(DB::raw('YEAR(start) as start'))->distinct()->lists('start', 'start'),
			'months'=>self::groupByMonth($events),
		));
	}

	/**
	 * show individual event
	 */
	public function show($slug) {
		$event = Event::
			where('slug', $slug)
			->first();

		//404
		if (!$event) return redirect()->action('EventController@index');

		return view('events.event', array(
			'title'=>strip_tags($event->title),
			'event'=>$event,
			'next'=>Event::where('start', '>', new DateTime)->orderBy('start', 'asc')->first(),
		));
	}

	/**
	 * Get a URL to the show() method
	 */
	public static function url(Event $event) {
		return action('EventController@show', $event->slug);
	}

	/**
	 * ajax
	 */
	function ajax() {

		# Construct chained Eloquent statement based on input
		$events = Event::orderBy('start', 'asc');
		if (Request::has('search') or Request::has('year')) {

			if (Request::has('search')) {
				$events
					->where('title', 'like', '%' . Request::input('search') . '%')
					->orWhere('description', 'like', '%' . Request::input('search') . '%');
			}
			
			if (Request::has('year')) {
				$events->where(DB::raw('YEAR(start)'), Request::input('year'));
			}			
		} else {
			$events->where('end', '>', new DateTime());
		}

		$events = $events->get();

		# Highlight search terms
		$events = App\Http\Controllers\Controller::highlightResults($events, array('title', 'description'));

		# Return HTML view
		return view('events.events', array('months'=>self::groupByMonth($events)));
	}

	private function groupByMonth($events) {
		$months = array();
		foreach ($events as $event) {
			$month = $event->start->format('F Y');
			$event->url = self::url($event);
			if (!isset($months[$month])) $months[$month] = array();
			$months[$month][] = $event;
		}
		return $months;		
	}

}