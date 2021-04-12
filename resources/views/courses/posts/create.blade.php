@extends('layouts.app')
@section('title', 'Create Post')

@section('content')
    <div class="row m-4 mb-5">
        <div class="col-6 offset-3">
            <h1 class="text-center">New Post!</h1>
            <form action="{{ route('post.create', $course) }}" method="POST" enctype="multipart/form-data" novalidate class="needs-validation">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="title">Title</label>
                    <input class="form-control" type="text" name="title" id="title" placeholder="Enter Title" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="body">body</label>
                    <textarea class="form-control" type="text" name="body" id="PostBody" placeholder="Enter Post Body"
                              required></textarea>
                </div>
                {{--                TODO add role restriction for tutor only--}}
                <div class="form-group d-block fas fa-folder fa-1.5x">
                    <input name="file" id="file" type="file" style="display: none"/>
                    <button type="button" onclick="document.getElementById('file').click()">Upload Attachment</button>
                </div>
                <button class="btn btn-info mb-2 btn-block ">Submit</button>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/formscript.js') }}"></script>
@endsection
