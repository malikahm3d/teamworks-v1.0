<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\University;
use Illuminate\Http\Request;

class prefilledRegisterController extends Controller
{
    //

    public function showAllUniversities()
    {
        $universities = University::all();
        return view('showAllUniversities', [
            'universities' => $universities
        ]);
    }

    public function showFacultiesInUni(University $university)
    {
        $faculties = $university->faculties;
        return view('showFacultiesInUni', [
            'university' => $university,
            'faculties' => $faculties
        ]);
    }

    public function showDepartmentsInFaculty(University $university, Faculty $faculty)
    {
        $departments = $faculty->departmants;
        return view('showDepartmentsInFaculty', [
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
        return view('auth.register', [
            'chosenUniversity' => $university,
            'chosenFaculty' => $faculty,
            'chosenDepartment' => $department,
            'universities' => $allUniversities,
            'faculties'=> $allFaculties,
            'departments' => $allDepartments
        ]);
    }



}
