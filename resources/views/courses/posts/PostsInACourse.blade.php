@extends('layouts.app')
@section('title', e($course->name))
@section('content')


    <a href="{{route('post.showCreate', $course)}}">Create Post!</a>

    @if($posts->count())
        @foreach($posts as $post)
            <x-post :post="$post"/>
        @endforeach
    @else
        <p class="text-center text-danger text-md-center">There are no posts in this course</p>
        <p class="text-center link-primary"><a href="{{ route('showCourses') }}">You Can Enroll In Other Courses Now!</a></p>
        <p class="text-center link-primary"><a href="{{ route('post.showCreate', $course) }}">Create Post!</a></p>
    @endif

@endsection
