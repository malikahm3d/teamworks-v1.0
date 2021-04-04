@extends('layouts.app')
@section('title', e($post->title))
@section('content')

    <x-post :post="$post"/>

    <div class="card-body">
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
            <form method="post" action="{{ route('comment.add') }}">
                @csrf
                <div class="form-group">
                    <label for="body"><h5>Leave a comment</h5></label>
                    <input type="text" id="body" name="body" class="form-control" placeholder="Leave a comment" />
                    <input type="hidden" name="post_id" value="{{ $post->id }}" />
                </div>
                <button type="submit" class="form-group btn btn-sm btn-outline-danger py-0" style="font-size: 0.8em;"> Add Comment</button>
            </form>
        </div>

        <h5>Display Comments</h5>
        <hr />
        @include('courses.posts.partials.comments', ['comments' => $comments, 'post_id' => $post->id])
    </div>
@endsection
