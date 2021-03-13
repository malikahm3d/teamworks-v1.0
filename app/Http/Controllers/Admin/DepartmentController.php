<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Faculty;

class DepartmentController extends Controller
{
    public function index()
    {
        //dd(auth()->user()->faculty->faculty);
        $departments = Department::all();
        return view('admin.organization.department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $faculties = Faculty::all();
        return view('admin.organization.department.create', compact('faculties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Department::select('name')->where('name',request()->name)->exists()
        and Department::select('faculty_id')->where('faculty_id',request()->faculty)->exists()){
            return redirect()->back()->with('error', 'Department with similar name in this faculty already exists!');
        }
        else
        {
            Department::create(['name' => request()->name, 'faculty_id' => request()->faculty]);
            return redirect()->back()->with('message', 'Department created successfully');
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
    public function edit(Department $department)
    {
        return view('admin.organization.department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        if(Department::select('name')->where('name',request()->name)->exists()
        and Department::select('faculty_id')->where('faculty_id',request()->faculty_id)->exists()){
            return redirect()->back()->with('error', 'Department with similar name in this faculty already exists!');
        }
        else
        {
            $department->update(['name' => $request->get('name')]);
            return redirect(route('departments.index'))->with('message', 'Department Updated Successfully!');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->back()->with('message', 'Department Removed Successfully!');
    }
}
