<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        $courses = $request->user()->department->courses;
        //get courses inside users' department

        $regCourses = $request->user()->courses->pluck('id');
        //get courses (IDs) inside user's enrollments

        return view('showCoursesInDep', [
            'courses' => $courses,
            'regCourses' => $regCourses
        ]);
    }

    public function EnrollCourse(Course $course, Request $request)
    {
        $course->enrollments()->create([
            'user_id' => $request->user()->id
        ]);
        return back();
    }

    public function DropCourse(Course $course, Request $request)
    {
        $course->enrollments()->where(
            'user_id', $request->user()->id)->delete();
        return back();
    }

}
