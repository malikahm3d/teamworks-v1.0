@extends('layouts.app')

@section('content')

        <div class="row m-4 mb-5">
            <div class="col-6 offset-3">
                <h1 class="text-center">New Post!</h1>
                <form action="{{ route('createPost', $course) }}" method="POST" novalidate class="needs-validation">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="title">Title</label>
                        <input class="form-control" type="text" name="title" id="title" placeholder="Enter Title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="body">body</label>
                        <textarea class="form-control" type="text" name="body" id="body" placeholder="Enter Post Body" required></textarea>
                    </div>
                    <button class="btn btn-outline-primary mb-2">Submit</button>
                </form>
            </div>
        </div>

    @if($posts->count())
        @foreach($posts as $post)
            <x-post :post="$post"/>
        @endforeach
    @else
        <p class="text-center text-danger text-md-center">There are no posts in this course</p>
        <p class="text-center link-primary"><a href="{{ route('showCourses') }}">You Can Enroll In Courses Now!</a></p>
    @endif

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
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
