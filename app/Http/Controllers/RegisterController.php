<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{

    //NOTE TO SAEED: needs more logic for roles and permissions

    public function index()
    {
        //normal non-prefilled form
        $allUniversities = University::all();
        $allFaculties = Faculty::all();
        $allDepartments = Department::all();
        return view('auth.register', [
            'allUniversities' => $allUniversities,
            'allFaculties'=> $allFaculties,
            'allDepartments' => $allDepartments
        ]);
    }

    public function store(Request $request)
    {

        $facultiesInThisUni = University::all()->where('id', $request->university)->first()->faculties->pluck('id');
        $departmentsInThisFaculty = Faculty::all()->where('id', $request->faculty)->first()->departments->pluck('id');
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
            'username' => ['required', 'unique:users'],
            'email' => ['email', 'unique:users'],
            'password' => ['required'],
            'university' => ['required'],
            'faculty' => ['required',
                Rule::in($facultiesInThisUni)],
            'department' => ['required',
                Rule::in($departmentsInThisFaculty),
            ]
        ]);
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'university_id' => $request->university,
            'faculty_id' => $request->faculty,
            'department_id' => $request->department,
        ]);

        //TODO: log user in after regsitering
        //take user to see courses in his department
    }

}
