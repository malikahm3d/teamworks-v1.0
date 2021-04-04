<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //

    public function store(Request $request, Post $post)
    {
        $this->validate($request, [
            'body' => ['required'],
        ]);
        $comment = new Comment;

        $comment->body = $request->body;

        $comment->user()->associate($request->user());

        $post = Post::find($request->post_id);

        $post->comments()->save($comment);

        return back();
    }

    public function replyStore(Request $request)
    {
        $this->validate($request, [
            'body' => ['required'],
        ]);

        $reply = new Comment();

        $reply->body = $request->get('body');

        $reply->user()->associate($request->user());

        $reply->parent_id = $request->get('comment_id');

        $post = Post::find($request->get('post_id'));

        $post->comments()->save($reply);

        return back();

    }
}