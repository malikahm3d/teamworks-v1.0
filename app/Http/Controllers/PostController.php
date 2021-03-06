<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Course;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    //
    public function PostsInACourse(Course $course)
    {

        $posts = $course->posts()->orderBy('created_at', 'desc')->withLikes()->with(['user', 'course'])->get();
        return view('courses.posts.PostsInACourse', [
            'posts' => $posts,
            'course' => $course
        ]);
    }

    public function PostsInEnrolledCourses(Request $request)
    {
        //show posts in enrolled courses
        //TODO optimize this querying
        $regCoursesIds = Course::getCourses($request->user());
        $posts = Post::withLikes()->orderBy('created_at', 'desc')->with(['user', 'course'])->whereIn('course_id', $regCoursesIds)->get();
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

        $str = htmlspecialchars($request->body);
        //strip unescaped input from any tags
        $sanitizedBody = preg_replace('#&lt;(/?(?:pre|b||u|ul|li|ol|blockquote|i|br)(?:.*?)?)&gt;#', '<\1>', $str);
        //restore replaced ones that are whitelisted

        $newPost = $course->posts()->create([
            'title' => $request->title,
            'body' => $sanitizedBody,
            'user_id' => $request->user()->id
        ]);

        if($request->file('filenames')) $this->createFile($newPost, $request);

        return redirect(route('showPost', $newPost))->with('message', 'Post Created Successfully!');

    }

    public function createFile(Post $post, Request $request)
    {

        $this->validate($request, [
            'filenames.*' => ['nullable', 'mimes:pdf,ppt,docx,jpg,jpeg,png,svg,xlx,xlsx,zip,rar,txt', 'max:1999']
        ]);

        if($request->file('filenames')) {
            try {
                foreach($request->file('filenames') as $file) {
                    $fileModel = new \App\Models\File();
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('uploads', $fileName, 'public');

                    $fileModel->name = time() . '_' . Str::random(5) . '_' . $file->getClientOriginalName();
                    $fileModel->file_path = '/storage/' . $filePath;
                    $post->file()->save($fileModel);

                }
            } catch (\Throwable $e){
                return back()->with('message', 'File Upload Failed');
            }
        }

    }

    public static function ShowPost(Post $post)
    {
        $post = $post->likeableWithLikes($post->id)->firstOrFail();

        $comments = $post->comments()->with(['user', 'replies'])->orderByDesc('created_at')->get();
        return view('courses.posts.show', ['post' => $post, 'comments' => $comments]);

    }

    public function delete(Post $post)
    {
        $this->authorize('delete', $post);
        $course = $post->course;
        if(count($post->file))  $post->file->delete();
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

    public function answer(Request $request)
    {

        $post = Post::find($request->post_id);
        $post->comment_id = $request->comment_id;
        $post->save();

        //return response()->json(['success'=>'Closed Thread.']);
        return redirect(route('showPost', [
            'post' => $post,
        ]));

    }

}
