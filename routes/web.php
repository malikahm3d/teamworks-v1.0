<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\prefilledRegisterController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('test');
});

Route::get('/home', function () {
    return redirect(\route('showCourses'));
});

Route::middleware(['guest'])->group(function (){

//auth routes:
    Route::get('/login', [LoginController::class, 'index'])->name('login');

    Route::post('/login', [LoginController::class, 'loguserin'])->name('login');

    Route::get('/register', [RegisterController::class, 'index'])->name('normalForm');


    Route::get('/universities', [prefilledRegisterController::class, 'showAllUniversities'])->name('showAllUniversities');

    Route::post('/universities/{university:name}/faculties', [prefilledRegisterController::class, 'showFacultiesInUni'])->name('showFaculties');

    Route::post('/universities/{university:name}/faculties/{faculty:name}',
        [prefilledRegisterController::class, 'showDepartmentsInFaculty'])->name('showDepartments');

    Route::match(['get', 'post'],'/universities/{university:name}/faculties/{faculty:name}/departments/{department:name}',
        [prefilledRegisterController::class, 'prefilledFrom'])->name('prefilledFrom');
    //maybe do post AND get for the above (for when user hits 'back')

    Route::post('/register', [RegisterController::class, 'store'])->name('storeUser');

});


Route::middleware(['auth'])->group(function () {

//course and enrollment routes:
    Route::get('/courses', [CourseController::class, 'index'])->name('showCourses');

    Route::post('/courses/{course:id}', [CourseController::class, 'EnrollCourse'])->name('enrollCourse');
    Route::delete('/courses/{course:id}', [CourseController::class, 'DropCourse'])->name('dropCourse');


//post routes:
    Route::get('/index', [PostController::class, 'PostsInEnrolledCourses'])->name('postsInEnrolledCourses');

    Route::get('/courses/{course:name}/posts', [PostController::class, 'ShowPostsInACourse'])->name('postsInACourse');
    Route::post('/courses/{course:id}/posts', [PostController::class, 'CreatePostInACourse'])->name('createPost');

});
