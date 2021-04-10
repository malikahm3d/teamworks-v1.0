@extends('layouts.app')
@section('title', e($post->title))
@section('content')

    <x-post :post="$post"/>

    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(isset($post->comment_id))
            <div class="card-body">
                <h5 class="text-info text-center"> Post has been answered</h5>
            </div>
        @else
                {{--            if post is not answered, allow posting of comments--}}
                <form method="post" id="commentForm" action="{{ route('comment.add') }}">
                    @csrf
                    <div class="form-group">
                        <label for="body"><h5>Leave a comment</h5></label>
                        <input type="text" id="body" name="body" class="form-control" placeholder="Leave a comment" />
                        <input type="hidden" id="post_id" name="post_id" value="{{ $post->id }}" />
                        <input type="hidden" id="user" name="user" value="{{auth()->user()}}">
                    </div>
                    <button type="submit" class="form-group btn btn-sm btn-outline-danger py-0" style="font-size: 0.8em;"> Add Comment</button>
                </form>
        @endif
        <hr />
        @include('courses.posts.partials.comments', ['comments' => $comments, 'post' => $post])
    </div>
@endsection
