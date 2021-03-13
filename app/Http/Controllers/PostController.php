<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function PostsInACourse(Course $course)
    {
        $posts = $course->posts;
        return view('courses.posts.PostsInACourse', [
            'posts' => $posts,
            'course' => $course
        ]);
    }

    public function PostsInEnrolledCourses(Request $request)
    {
        //show posts in enrolled courses
        $regCoursesIds = Course::getCourses($request->user());
        $posts = Post::all()->whereIn('course_id', $regCoursesIds);
        return view('courses.posts.PostsInEnrolledCourses',[
            'posts' => $posts
        ]);
    }

    public function CreatePost(Request $request, Course $course)
    {
        $this->validate($request, [
            'title' => ['required'],
            'body' => ['required']
        ]);

        $course->posts()->create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => $request->user()->id
        ]);

        return redirect(route('postsInACourse', $course));
    }

    public static function ShowPost(Post $post)
    {
        return view('courses.posts.show', ['post' => $post]);
    }

}
