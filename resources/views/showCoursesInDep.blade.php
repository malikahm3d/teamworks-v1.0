@extends('layouts.app')
@section('title', '| Enrollment')
@section('content')

@if($courses->count())

    @foreach($courses as $course)
        @if(!in_array($course->id, $regCourses->all()))
        <form action="{{ route('enrollCourse', $course) }}" method="POST" class="p-1 d-inline">
            @csrf
            <button type="submit" class="btn btn-primary btn-sm my-4"><p>Enroll in: {{ $course->name }}</p></button>
        </form>
        @else
        <form action="{{ route('dropCourse', $course) }}" method="POST" class="p-3 d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"><p>Drop: {{ $course->name }}</p></button>
        </form>
        @endif
    @endforeach

@else

    <p class="text-center font-monospace">No courses to show</p>

@endif

@endsection
