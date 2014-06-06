<?php

class CourseController extends BaseController {

	/**
	 * show the course home page
	 */
	public function index() {

		$genres = array();
		$courses = Course::with('genres', 'instructors')->get();
		foreach ($courses as $course) {
			if (!isset($genres[$course->genres->title])) $genres[$course->genres->title] = array();
			$genres[$course->genres->title][] = $course;
		}
		return View::make('courses.index', array(
			'title'				=>'Courses',
			'genres'			=>$genres,
			'genre_select'		=>self::getGenreList(),
			'instructor_select'	=>self::getInstructorList(),
			'duration_select'	=>self::getDurationList(),
			'day_select'		=>self::getDayList(),
			'class'				=>'courses',
		));		
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
			'related'=>Course::where('genre_id', $course->genre_id)
				->where('id', '<>', $course->id)
				->orderBy(DB::raw('RAND()'))
				->first(),
		));
	}

	/**
	 * provide json for the AJAX switchboard
	 */
	public function ajax() {

		$genres = array();

		$courses = Course::with('genres', 'instructors');

		if (Input::has('instructor')) {
			$courses->whereHas('instructors', function($q) {
			    $q->where('id', Input::get('instructor'));
			});
		}
		if (Input::has('genre')) {
			$courses->where('genre_id', Input::get('genre'));
		}

		if (Input::has('search')) {
			$courses->where('title', 'like', '%' . Input::get('search') . '%');
		}

		$courses = $courses->get();

		foreach ($courses as $course) {
			if (!isset($genres[$course->genres->title])) $genres[$course->genres->title] = array();
			$genres[$course->genres->title][] = $course;
		}

		/* Add formatted instructor string
		foreach ($genres as $genre) {
			foreach ($genre->courses as $course) {
				$course->instructor_string = self::formatInstructors($course);
			}
		}
		*/

		//echo '<pre>';
		//dd(DB::getQueryLog());

		# Return
		return View::make('courses.genres', array('genres'=>$genres));
	}

	/**
	 * populate instructor select on course.index or home
	 */
	public static function getInstructorList() {
		return Instructor::orderBy('name')->lists('name', 'id');
	}

	/**
	 * populate genre select on course.index or home
	 */
	public static function getGenreList() {
		return Genre::orderBy('title')->lists('title', 'id');
	}

	/**
	 * populate day select on course.index or home
	 */
	public static function getDayList() {
		return array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
	}

	/**
	 * populate duration select on course.index or home
	 */
	public static function getDurationList() {
		return array('workshop'=>'Workshop', 'intensive'=>'1-day Intensive', 'course'=>'Multi-week Course');
	}

	/**
	 * generate avalon link
	 */
	public static function editLink(Course $course) {
		if (!Auth::user()) return false;
		return link_to(URL::action('InstanceController@edit', array(6, $course->id)) . '?return_to=' . urlencode(Url::current()), '', array('class'=>'edit dashicons dashicons-welcome-write-blog'));
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

}