<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('auth.login');
    }

    public function loguserin(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(!auth()->attempt($request->only('email', 'password')))
        {
            return back()->with('status', 'log in failed');
        }
        else
        {
            return route('showCourses');
        }

    }
}
