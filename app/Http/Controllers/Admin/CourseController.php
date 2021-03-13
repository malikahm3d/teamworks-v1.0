<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Department;

class CourseController extends Controller
{

    public function index()
    {
        //dd(auth()->user()->department->department);
        $courses = Course::all();
        return view('admin.organization.course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        return view('admin.organization.course.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Course::select('name')->where('name',request()->name)->exists()
        and Course::select('department_id')->where('department_id',request()->department)->exists()){
            return redirect()->back()->with('error', 'Course with similar name in this department already exists!');
        }
        else
        {
            Course::create(['name' => request()->name, 'department_id' => request()->department]);
            return redirect()->back()->with('message', 'Course created successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('admin.organization.course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        if(Course::select('name')->where('name',request()->name)->exists()
        and Course::select('department_id')->where('department_id',request()->department_id)->exists()){
            return redirect()->back()->with('error', 'Course with similar name in this department already exists!');
        }
        else
        {
            $course->update(['name' => $request->get('name')]);
            return redirect(route('courses.index'))->with('message', 'Course Updated Successfully!');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->back()->with('message', 'Course Removed Successfully!');
    }
}
