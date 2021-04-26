@extends('layouts.app')

@section('title', '| Edit post')
@can('edit post')
@section('content')

    <form action="{{ route('post.edit', $post) }}" method="POST" novalidate class="needs-validation">
        @csrf
        @method('PATCH')
        <div class="row m-4 mb-5">
            <div class="col-6 offset-3">
                <h1 class="text-center">Edit post</h1>
                <form action="{{ route('post.edit', $post) }}" method="POST" enctype="multipart/form-data" novalidate class="needs-validation">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="title">Title</label>
                        <input class="form-control" dir="auto" type="text" name="title" id="title" placeholder="Enter Title" value="{{ $post->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="body">body</label>
                        <textarea dir="auto" class="form-control" type="text" name="body" id="PostBody" placeholder="Enter Post Body"  required>
                            {{ $post->body }}
                        </textarea>
                    </div>
                    <button class="btn btn-outline-primary mb-2">Edit</button>
                </form>
            </div>
        </div>
    </form>
    <script src="{{ asset('js/formscript.js') }}"></script>
@endsection
@endcan
