@extends('layouts.app')
@section('title', e($course->name))
@section('content')

    <div class="flex flex-col">
        <h2 class="text-center font-weight-bold text-capitalize text-info text-opacity-75">
            {{ $course->name }}
        </h2>
        @can('create post')
            <span class="text-center font-weight-bold text-capitalize text-info text-opacity-75 m-2 ">
            <a href="{{ route('post.showCreate', $course) }}" type="button" class="btn btn-info">
                <i class="far fa-plus-square text-white mr-1"></i>
                Create Post!
            </a>
        </span>
        @endcan
    </div>
    @if($posts->count())
        @include('includes.table', ['posts' => $posts])
    @else
        <p class="text-center text-danger text-md-center">There are no posts in this course</p>
        <p class="text-center link-primary"><a href="{{ route('showCourses') }}">You Can Enroll In Other Courses Now!</a></p>
        @can('create post')
            <p class="text-center link-primary"><a href="{{ route('post.showCreate', $course) }}">Create Post!</a></p>
        @endcan
    @endif

@endsection
