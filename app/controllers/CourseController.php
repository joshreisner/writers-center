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

		$with = array();

		# Get initial resultset
		$return = Genre::with('courses');
		if (Input::has('search')) {
			$with['courses'] = function($query){
				$query->where('title', 'like', '%' . Input::get('search') . '%');
			};
		} else {
			$with[] = 'courses';
		}
		if (Input::has('genre')) {
			$return->where('genres.id', Input::get('genre'));
		}
		if (Input::has('instructor')) {
			$with['courses.instructors'] = function($query){
			    $query->where('id', Input::get('instructor'));
			};
		} else {
			$with[] = 'courses.instructors';
		}
		$genres = $return->with($with)->get();

		# Add formatted instructor string
		foreach ($genres as $genre) {
			foreach ($genre->courses as $course) {
				$course->instructor_string = self::formatInstructors($course);
			}
		}

		//echo '<pre>';
		//dd(DB::getQueryLog());

		# Return
		return View::make('courses.genres', array('genres'=>$genres));
	}

	/**
	 * populate day select
	 */
	public static function getDayList($days=false) {
		return array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
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

	/**
	 * populate duration select
	 */
	public static function getDurationList() {
		return array(
			'workshop'=>'Workshop',
			'intensive'=>'1-day Intensive',
			'course'=>'Multi-week Course',
		);
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