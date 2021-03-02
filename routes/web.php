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

//auth routes:
Route::get('/login', [LoginController::class, 'index'])->name('showLoginForm');

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



//course routes:
Route::get('/courses', [CourseController::class, 'index'])->name('showCourses');

Route::post('/courses/{course:id}', [CourseController::class, 'EnrollCourse'])->name('enrollCourse');



//post routes:
Route::get('/courses', [PostController::class, 'PostsInEnrolledCourses'])->name('postsInEnrolledCourses');

Route::get('/courses/{course:name}/posts', [PostController::class, 'PostsInACourse'])->name('postsInACourse');

Route::post('/courses/{course:id}/posts', [PostController::class, 'CreatePost'])->name('createPost');
