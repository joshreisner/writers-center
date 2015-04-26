<?php namespace App\Http\Controllers;

use DateTime;
use DB;
use Input;
use LeftRight\Center\Models\Event;

class EventController extends Controller {

	/**
	 * show upcoming events
	 */
	public function index() {

		# Build array of months
		if (Input::has('date')) {
			list($year, $month, $day) = explode('-', Input::get('date'));
			$events = Event::whereRaw('MONTH(start) = ?', [$month])
						->whereRaw('DAY(start) = ?', [$day])
						->whereRaw('YEAR(start) = ?', [$year])->get();
		} else {
			$events = Event::where('end', '>', new DateTime())->orderBy('start', 'asc')->get();
		}

		return view('events.index', [
			'title' => 'Events',
			'years' => Event::orderBy('start', 'desc')->select(DB::raw('YEAR(start) as start'))->distinct()->lists('start', 'start'),
			'months' => self::groupByMonth($events),
		]);
	}

	/**
	 * show individual event
	 */
	public function show($slug) {

		//404
		if (!$event = Event::where('slug', $slug)->first()) {
			return redirect()->action('EventController@index');
		}

		return view('events.event', [
			'title' => strip_tags($event->title),
			'event' => $event,
			'next' => Event::where('start', '>', time())->orderBy('start', 'asc')->first(),
		]);
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
		if (Input::has('search') || Input::has('year')) {

			if (Input::has('search')) {
				$events
					->where('title', 'like', '%' . Input::get('search') . '%')
					->orWhere('description', 'like', '%' . Input::get('search') . '%');
			}
			
			if (Input::has('year')) {
				$events->where(DB::raw('YEAR(start)'), Input::get('year'));
			}			
		} else {
			$events->where('end', '>', time());
		}

		$events = $events->get();

		# Highlight search terms
		$events = self::highlightResults($events, array('title', 'description'));

		# Return HTML view
		return view('events.events', ['months'=>self::groupByMonth($events)]);
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