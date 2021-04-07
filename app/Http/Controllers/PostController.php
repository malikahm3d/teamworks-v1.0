<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Course;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function PostsInACourse(Course $course)
    {
        $posts = $course->posts()->with('user')->orderByDesc('created_at')->get();
        return view('courses.posts.PostsInACourse', [
            'posts' => $posts,
            'course' => $course
        ]);
    }

    public function PostsInEnrolledCourses(Request $request)
    {
        //show posts in enrolled courses
        $regCoursesIds = Course::getCourses($request->user());
        $posts = Post::with('user')->whereIn('course_id', $regCoursesIds)->get();
        return view('courses.posts.PostsInEnrolledCourses',[
            'posts' => $posts
        ]);
    }

    public function showCreate(Course $course)
    {
        return view('courses.posts.create', [
            'course' => $course
        ]);
    }

    public function CreatePost(Request $request, Course $course)
    {
        $this->validate($request, [
            'title' => ['required'],
            'body' => ['required'],
            'file' => ['nullable', 'mimes:pdf,ppt,docx,jpg,jpeg,xlx', 'max:1999']
        ]);



        $newPost = $course->posts()->create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => $request->user()->id
        ]);


        $this->createFile($newPost, $request);

        return redirect(route('showPost', $newPost));

    }

    public function createFile(Post $post, Request $request)
    {

        $this->validate($request, [
            'file' => ['nullable', 'mimes:pdf,ppt,docx,jpg,jpeg,png,xlx', 'max:1999']
        ]);

        $fileModel = new \App\Models\File();

        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');

            $fileModel->name = time().'_'.$request->file->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath;
            $post->file()->save($fileModel);

        }


    }

    public static function ShowPost(Post $post)
    {

        $comments = $post->comments()->with('user')->orderByDesc('created_at')->get();
        return view('courses.posts.show', ['post' => $post, 'comments' => $comments]);

    }

    public function delete(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return route('homepage', $post->course);

    }

    public function showEdit(Post $post)
    {
        return view('courses.posts.edit', ['post' => $post]);
    }

    public function edit(Post $post, Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'body' => ['required']
        ]);

        $newPost = Post::find($post->id);
        $newPost->title = $request->title;
        $newPost->body = $request->body;
        $newPost->save();


        return redirect(route('showPost', $newPost));

    }

}
