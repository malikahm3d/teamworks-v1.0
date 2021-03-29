@extends('layouts.app')

@section('content')


    <h2 class="p-5">This is where the full post, media, and comments are shown</h2>
    <x-post :post="$post"/>


    <div class="card-body">
        <h5>Display Comments</h5>
        @include('courses.posts.partials.comments', ['comments' => $post->comments, 'post_id' => $post->id])
        <hr />
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card-body">
        <h5>Leave a comment</h5>
        <form method="post" action="{{ route('comment.add') }}">
            @csrf
            <div class="form-group">
                <input type="text" name="body" class="form-control" />
                <input type="hidden" name="post_id" value="{{ $post->id }}" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-sm btn-outline-danger py-0" style="font-size: 0.8em;" value="Add Comment" />
            </div>
        </form>
    </div>
@endsection
