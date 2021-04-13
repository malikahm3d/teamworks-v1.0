@extends('layouts.app')
@section('title', 'posts in enrolled courses')
@section('content')
    @if($posts->count())
        @foreach($posts as  $post)
            <x-PostPreview :post="$post"/>
        @endforeach
    @else
    <p class="text-center text-danger text-md-center">There are no posts on you enrolled courses</p>
    @can('enroll')
    <a href="{{ route('showCourses') }}" class="text-center link-primary">You Can Enroll In Courses Now!</a>
    @endcan
    @endif
@endsection
