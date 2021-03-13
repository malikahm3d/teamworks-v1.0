<?php

namespace App\Http\Controllers\Auth;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\University;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        //normal non-prefilled form
        $allUniversities = University::all();
        $allFaculties = Faculty::all();
        $allDepartments = Department::all();
        $roles = Role::all();
        return view('auth.register', [
            'allUniversities' => $allUniversities,
            'allFaculties'=> $allFaculties,
            'allDepartments' => $allDepartments,
            'roles'=> $roles,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
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

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'university_id' => $request->university,
            'faculty_id' => $request->faculty,
            'department_id' => $request->department,
        ]);

        $user->syncRoles($request->role);

        Auth::login($user);

        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME);
    }
}
