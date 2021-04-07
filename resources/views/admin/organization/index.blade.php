@extends('layouts.app')

@section('content')
    @role('admin')
    <a href="{{route('universities.index')}}"><h2 class="p-5">Manage Universities</h2></a>
    <a href="{{route('faculties.index')}}"><h2 class="p-5">Manage Faculties</h2></a> 
    <a href="{{route('departments.index')}}"><h2 class="p-5">Manage Departments</h2></a>
    @endrole
    @hasanyrole('admin|moderator')
    <a href="{{route('courses.index')}}"><h2 class="p-5">Manage Courses</h2></a>
    @else
    @endhasanyrole
@endsection