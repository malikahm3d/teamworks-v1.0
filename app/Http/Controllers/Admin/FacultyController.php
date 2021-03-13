<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\University;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(auth()->user()->faculty->university);
        $faculties = Faculty::all();
        return view('admin.organization.faculty.index', compact('faculties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $universities = University::all();
        return view('admin.organization.faculty.create', compact('universities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Faculty::select('name')->where('name',request()->name)->exists()
        and Faculty::select('university_id')->where('university_id',request()->university)->exists()){
            return redirect()->back()->with('error', 'Faculty with similar name in this university already exists!');
        }
        else
        {
            Faculty::create(['name' => request()->name, 'university_id' => request()->university]);
            return redirect()->back()->with('message', 'Faculty created successfully');
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
    public function edit(Faculty $faculty)
    {
        return view('admin.organization.faculty.edit', compact('faculty'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faculty $faculty)
    {
        if(Faculty::select('name')->where('name',request()->name)->exists()
        and Faculty::select('university_id')->where('university_id',request()->university_id)->exists()){
            return redirect()->back()->with('error', 'Faculty with similar name in this university already exists!');
        }
        else
        {
            $faculty->update(['name' => $request->get('name')]);
            return redirect(route('faculties.index'))->with('message', 'Faculty Updated Successfully!');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
        return redirect()->back()->with('message', 'Faculty Removed Successfully!');
    }

    public function getDepartments(Faculty $faculty)
    {
        return $faculty->departments()->select('id', 'name')->get();
    }
}
