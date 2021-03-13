@extends('layouts.app')
@section('content')
<x-alert />
<div class="row py-lg-2">
    <div class="col-md-6">
        <h2>Manage All Courses</h2>
    </div>
</div>


<!-- DataTables Example -->
<div class="card">
    <div class="card-header">
        <h3 class="card-header d-flex justify-content-between align-items-center">
        Courses Table
        <div class="card-tools">
        <a href="{{route('courses.create')}}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Create New Course</a>
        </div>
        
        </h3>
            
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                    <th>Id</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Tools</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse ($courses as $course)
                    <tr {{ Auth::user()->course == $course? 'bgcolor=#f0f0f0' : '' }}>
                        <td>{{$course->id}}</td>
                        <td>{{$course->name}}</td>
                        <td>{{$course->department->name}}</td>
                        <td>
                            <a class="fas fa-pen text-yellow-500 p-1 cursor-pointer" 
                            href="{{route('courses.edit', $course->id)}}"></a>

                            <span class="fas fa-times text-red-400 p-1 cursor-pointer" onclick="event.preventDefault();
                            if(confirm('Are you sure you want to delete this course?'))
                            {
                                document.getElementById('form-delete-{{$course->id}}')
                                .submit()
                            }" />
                            <form style="display:none" id="{{'form-delete-'.$course->id}}" method="post"
                                action="{{route('courses.destroy', $course->id)}}">
                                @csrf
                                @method('delete')
                            </form>
                            
                        </td>
                    </tr>
                    @empty
                        <h3>There's no course to show</h3>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
    <a class="mx-5 py-2 text-gray-400 cursor-pointer text-black" href="{{route('admin.panel.organization')}}">
        <span class="fas fa-arrow-left" />
    </a>
    </div>
</div>
@endsection
