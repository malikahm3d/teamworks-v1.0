@extends('layouts.app')

@section('title', 'Edit post')

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
    <script>
        // const tinymce = require("tinymce");
        tinymce.init({
            selector: '#PostBody',
            protect: [
                /\<\/?(if|endif)\>/g,  // Protect <if> & </endif>
                /\<xsl\:[^>]+\>/g,  // Protect <xsl:...>
                /<\?php.*?\?>/g, // Protect php code
            ],
            valid_elements : 'a[href|target=_blank],strong/b,div[align],br'
        });
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                //TODO: more advanced from checking with individual error messages
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
@endsection
