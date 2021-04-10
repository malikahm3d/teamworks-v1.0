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
        $posts = $course->posts()->withLikes()->with('user')->orderByDesc('created_at')->get();
        return view('courses.posts.PostsInACourse', [
            'posts' => $posts,
            'course' => $course
        ]);
    }

    public function PostsInEnrolledCourses(Request $request)
    {
        //show posts in enrolled courses
        $regCoursesIds = Course::getCourses($request->user());
        $posts = Post::withLikes()->with('user')->whereIn('course_id', $regCoursesIds)->get();
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

        return redirect(route('showPost', $newPost))->with('message', 'Post Created Successfully!');

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
        $post = $post->likeableWithLikes($post->id)->firstOrFail();

        $comments = $post->comments()->with('user')->orderByDesc('created_at')->get();
        return view('courses.posts.show', ['post' => $post, 'comments' => $comments]);

    }

    public function delete(Post $post)
    {
        $this->authorize('delete', $post);
        $course = $post->course;
        if(!is_null($post->file)) $post->file->delete();
        $post->comments()->each(function($comment) {
            $comment->delete(); // <-- direct deletion
         });
        $post->delete();
        return redirect(route('postsInACourse', $course))->with('message', 'Post Deleted Successfully!');

    }

    public function showEdit(Post $post)
    {
        $this->authorize('update', $post);
        return view('courses.posts.edit', ['post' => $post]);
    }

    public function edit(Post $post, Request $request)
    {
        $this->authorize('update', $post);

        $this->validate($request, [
            'title' => ['required'],
            'body' => ['required']
        ]);

        $newPost = Post::find($post->id);
        $newPost->title = $request->title;
        $newPost->body = $request->body;
        $newPost->save();


        return redirect(route('showPost', $newPost))->with('message', 'Post Updated Successfully!');

    }

    public function like(Post $post)
    {

        $post = $post->likeableWithLikes($post->id)->firstOrFail();
        $post->like(auth()->user());

        return back();
    }

    public function dislike(Post $post)
    {
        $post = $post->likeableWithLikes($post->id)->firstOrFail();
        $post->dislike(auth()->user());

        return back();
    }
    public function destroyLike(Post $post)
    {
        $post->unlike(auth()->user());
        return back();
    }

}
