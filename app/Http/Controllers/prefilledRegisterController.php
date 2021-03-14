<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\University;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class prefilledRegisterController extends Controller
{
    //

    public function showAllUniversities()
    {
        $universities = University::all();
        return view('auth.showAllUniversities', [
            'universities' => $universities
        ]);
    }

    public function showFacultiesInUni(University $university)
    {
        $faculties = $university->faculties;
        return view('auth.showFacultiesInUni', [
            'university' => $university,
            'faculties' => $faculties
        ]);
    }

    public function showDepartmentsInFaculty(University $university, Faculty $faculty)
    {
        $departments = $faculty->departments    ;
        return view('auth.showDepartmentsInFaculty', [
            'university' => $university,
            'faculty' => $faculty,
            'departments' => $departments
        ]);
    }

    public function prefilledFrom(University $university, Faculty $faculty, Department $department)
    {
        $allUniversities = University::all();
        $allFaculties = Faculty::all();
        $allDepartments = Department::all();
        $roles = Role::all();
        return view('auth.register', [
            'chosenUniversity' => $university,
            'chosenFaculty' => $faculty,
            'chosenDepartment' => $department,
            'allUniversities' => $allUniversities,
            'allFaculties'=> $allFaculties,
            'allDepartments' => $allDepartments,
            'roles' => $roles,
        ]);
    }



}
