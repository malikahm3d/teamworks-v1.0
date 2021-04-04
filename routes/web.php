<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserCourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\prefilledRegisterController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UniversityController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\UserController;


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
    return redirect(\route('postsInEnrolledCourses'));
})->name('homepage');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::middleware(['guest'])->group(function (){

//auth routes:
    // Route::get('/login', [LoginController::class, 'index'])->name('login');

    // Route::post('/login', [LoginController::class, 'loguserin'])->name('login');


    Route::get('/universities', [prefilledRegisterController::class, 'showAllUniversities'])->name('showAllUniversities');

    Route::post('/universities/{university:name}/faculties', [prefilledRegisterController::class, 'showFacultiesInUni'])->name('showFaculties');

    Route::post('/universities/{university:name}/faculties/{faculty:name}',
    [prefilledRegisterController::class, 'showDepartmentsInFaculty'])->name('showDepartments');

    Route::match(['get', 'post'],'/universities/{university:name}/faculties/{faculty:name}/departments/{department:name}',
    [prefilledRegisterController::class, 'prefilledFrom'])->name('prefilledFrom');
    //maybe do post AND get for the above (for when user hits 'back')

    // Route::get('/register', [RegisteredUserController::class, 'index'])->name('normalForm');

    // Route::post('/register', [RegisteredUserController::class, 'store'])->name('storeUser');

    //Route::post('/register', [RegisterController::class, 'store'])->name('storeUser');

});

//Auth Routes (this file contains all authentication related routes (login, logout, register, etc.))
require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    //course and enrollment routes:
    Route::get('/courses', [CourseController::class, 'index'])->name('RENAME');
    Route::post('/courses/{course:id}', [CourseController::class, 'EnrollCourse'])->name('RENAME');
    Route::delete('/courses/{course:id}', [CourseController::class, 'DropCourse'])->name('RENAME');

    Route::get('/enrollment', [UserCourseController::class, 'index'])->name('showCourses');
    Route::post('/enrollment/{course:id}', [UserCourseController::class, 'EnrollCourse'])->name('enrollCourse');
    Route::delete('/enrollment/{course:id}', [UserCourseController::class, 'DropCourse'])->name('dropCourse');


//post routes:
    Route::get('/posts', [PostController::class, 'PostsInEnrolledCourses'])->name('postsInEnrolledCourses');

    Route::get('/posts/{course:name}/index', [PostController::class, 'PostsInACourse'])->name('postsInACourse');

    Route::get('/posts/{post:id}/show', [PostController::class, 'ShowPost'])->name('showPost');

    Route::get('/post/{course:name}/create', [PostController::class, 'showCreate'])->name('post.showCreate');
    Route::post('/posts/{course}/create', [PostController::class, 'CreatePost'])->name('post.create');

    Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.add');
    Route::post('/reply/store', [CommentController::class, 'replyStore'])->name('reply.add');




});
//Route::post('/courses/{course:id}/posts', [PostController::class, 'CreatePost'])->name('createPost');

Route::group(['middleware' => ['role_or_permission:admin|create role|create permission']],function() {

    //role routes
    Route::get('panel', [UserController::class, 'adminPanel'])->name('admin.panel');
    Route::get('panel/roles/manage', [RoleController::class, 'manage'])->name('roles.manage');
    Route::patch('panel/roles/', [RoleController::class, 'updateRoles'])->name('roles.updateRoles');
    Route::get('panel/user/{user}/roles', [UserController::class, 'getRoles'])->name('roles.users');
    Route::resource('panel/roles', RoleController::class);

    //permission routes
    Route::get('panel/permissions/manage', [PermissionController::class, 'manage'])->name('permissions.manage');
    Route::patch('panel/permissions/', [PermissionController::class, 'updatePermissions'])->name('permissions.updatePermissions');
    Route::get('panel/user/{user}/permissions', [UserController::class, 'getPermissions'])->name('permissions.users');
    Route::resource('panel/permissions', PermissionController::class);

    //organization route
    Route::get('panel/organization/', [UserController::class, 'univeristiesOrganizations'])->name('admin.panel.organization');

    //university routes
    Route::resource('panel/organization/universities', UniversityController::class);

    //faculty routes
    Route::resource('panel/organization/faculties', FacultyController::class);

    //department routes
    Route::resource('panel/organization/departments', DepartmentController::class);

    //course routes
    Route::resource('panel/organization/courses', CourseController::class);


});

// routes for fetching university faculties and faculty departments for the dynamic select menu in user registeration form
Route::get('university/{university}/faculties', [UniversityController::class, 'getFaculties'])->name('universities.faculties');
Route::get('faculty/{faculty}/departments', [FacultyController::class, 'getDepartments'])->name('faculties.departments');

Route::resource('users', UserController::class);
