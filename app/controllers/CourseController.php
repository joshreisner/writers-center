<?php

class CourseController extends BaseController {

	/**
	 * show the course home page
	 */
	public function index() {

		$genres = Genre::with('courses', 'courses.instructors')->get();

		return View::make('courses.index', array(
			'title'				=>'Courses',
			'genres'			=>$genres,
			'genre_select'		=>self::getGenreList($genres),
			'instructor_select'	=>self::getInstructorList(),
			'duration_select'	=>self::getDurationList(),
			'day_select'		=>self::getDayList(),
			'class'				=>'courses',
		));		
	}

	/**
	 * populate day select
	 */
	public static function getDayList($days=false) {
		if ($days === false) $days = Day::orderBy('precedence');
		return $days->lists('title', 'id');
	}

	/**
	 * populate genre select
	 */
	public static function getGenreList($genres=false) {
		if ($genres === false) $genres = Genre::orderBy('title');
		return $genres->lists('title', 'id');
	}

	/**
	 * populate instructor select
	 */
	public static function getInstructorList($instructors=false) {
		if ($instructors === false) $instructors = Instructor::orderBy('name');
		return $instructors->lists('name', 'id');
	}

	public static function getDurationList() {
		return array(
			'workshop'=>'Workshop',
			'intensive'=>'1-day Intensive',
			'course'=>'Multi-week Course',
		);
	}

	/**
	 * show a single course
	 */
	public function show($slug) {
		$course = Course::with('instructors')->where('slug', $slug)->first();
		return View::make('courses.course', array(
			'title'=>$course->title,
			'course'=>$course,
			'class'=>'courses',
		));
	}

	/**
	 * format a ordinal(?) list of instructors
	 */
	public static function formatInstructors(Course $course) {
		$instructors = array();
		foreach ($course->instructors as $instructor) {
			$instructors[] = $instructor->name;
		}
		if (count($instructors) > 2) {
			$last = array_pop($instructors);
			$instructors = implode(', ', $instructors) . ' and ' . $last;
		} else {
			$instructors = implode(' and ', $instructors);					
		}
		return $instructors;
	}

	/**
	 * generate avalon link
	 */
	public static function editLink(Course $course) {
		if (!Auth::user()) return false;
		return link_to(URL::action('InstanceController@edit', array(6, $course->id)), 'Edit', array('class'=>'avalon_edit'));
	}

}