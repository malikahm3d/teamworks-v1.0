<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class UserCourseController extends Controller
{
    public function index(Request $request)
    {
        //show courses inside users' department
        $courses = $request->user()->department->courses;
        return view('coursesInDepartment', [
            'courses' => $courses
        ]);
    }

    public function EnrollCourse(Course $course, Request $request)
    {
        $course->enrollments()->create([
            'user_id' => $request->user()->id
        ]);
        //return user to that course's posts page
        //i.e. return the posts page with the course in the parameter
        return route('posts', $course);
    }

}
