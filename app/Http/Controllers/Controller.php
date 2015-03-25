<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Request;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	/**
	 * highlight search results
	 */
	public static function highlightResults($results, $keys)
	{

		if (!Request::has('search')) return $results;

		foreach ($results as &$result) {
			foreach ($keys as $key) {
				$result->{$key} = preg_replace(
					'/(?<=^|[> ])(' . Request::input('search') . ')(?=$|[^a-z])/is', 
					'<mark>\\0</mark>', 
					$result->{$key});
			}
		}

		return $results;
	}

	/**
	 * generate avalon link
	 */
	public static function editLink($instance) {
		if (!Auth::user() || !Auth::user()->role) return false;
		return link_to(URL::action('InstanceController@edit', array($instance->table, $instance->id)), '', array('class'=>'edit fa fa-edit'));
		return link_to(URL::action('InstanceController@edit', array($instance->table, $instance->id)) . '?return_to=' . urlencode(Url::current()), '', array('class'=>'edit fa fa-edit'));
	}

	/**
	 * time range
	 */
	public static function formatTimeRange($start, $end, $separator='&ndash;') {

		$start = self::parseTime($start);
		$end = self::parseTime($end);

		if ($start['ampm'] == $end['ampm']) {
			if ($start['hour'] == $end['hour']) {
				return $start['hour'] . ':' . $start['minute'] . $separator . $end['minute'] . ' ' . $start['ampm'];
			} elseif ($start['minute'] == 00 && $end['minute'] == '00') {
				return $start['hour'] . $separator . $end['hour'] . ' ' . $start['ampm'];
			} else {
				return $start['hour'] . ':' . $start['minute'] . $separator . $end['hour'] . ':' . $end['minute'] . ' ' . $start['ampm'];
			}
		} else {
			return $start['hour'] . ':' . $start['minute'] . ' ' . $start['ampm'] . $separator . $end['hour'] . ':' . $end['minute'] . ' ' . $end['ampm'];
		}
	}

	/**
	 * date range
	 */
	public static function formatDateRange($start, $end, $separator='&ndash;') {

		if ($start->format('Y') == $end->format('Y')) {
			if ($start->format('m') == $end->format('m')) {
				if ($start->format('d') == $end->format('d')) {
					//same day
					return $start->format('m/d/Y');					
				} else {
					//same month and year, different day
					return $start->format('m/d') . $separator . $end->format('d/Y');
				}
			} else {
				//same year, different months
				return $start->format('m/d') . $separator . $end->format('m/d/Y');
			}
		}

		//totally different dates, specify year
		return $start->format('m/d/Y') . $separator . $end->format('m/d/Y');

	}

	public static function insertIntoHtml($html, $insert) {
		if ($pos = strrpos($html, '</p>')) {
			return substr($html, 0, $pos) . ' ' . $insert . substr($html, $pos);
		} else {
			return $html . $insert;
		}
	}

	/**
	 * time range helper, (only useful with time fields, todo deprecate)
	 */
	private static function parseTime($time) {
		if (stristr($time, ' ')) list($date, $time) = explode(' ', $time);
		list($hour, $minute, $second) = explode(':', $time);
		$ampm = 'a.m.';
		if ($hour > 11) $ampm = 'p.m.';
		if ($hour > 12) $hour -= 12;
		$hour -= 0;
		return compact('hour', 'minute', 'ampm');
	}

	/**
	 * price formatter
	 */
	public static function formatPrice($price, $non_member=false) {
		if ($price === null) return 'TBD';
		if ($non_member) $price += 25;
		if ($price === 0) return 'Free';
		return '$' . number_format($price);
	}

}
