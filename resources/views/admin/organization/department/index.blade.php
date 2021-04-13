@extends('layouts.app')
@section('content')
<x-alert />
<div class="row py-lg-2">
    <div class="col-md-6">
        <h2>Manage All Departments</h2>
    </div>
</div>


<!-- DataTables Example -->
<div class="card">
    <div class="card-header">
        <h3 class="card-header d-flex justify-content-between align-items-center">
        Departments Table
        @can('create department')
        <div class="card-tools">
        <a href="{{route('departments.create')}}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Create New Department</a>
        </div>
        @endcan
        
        </h3>
            
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Faculty</th>
                        <th>Courses</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                    <th>Id</th>
                        <th>Name</th>
                        <th>Faculty</th>
                        <th>Courses</th>
                        <th>Tools</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse ($departments as $department)
                    <tr {{ Auth::user()->department == $department? 'bgcolor=#f0f0f0' : '' }}>
                        <td>{{$department->id}}</td>
                        <td>{{$department->name}}</td>
                        <td>{{$department->faculty->name}}</td>
                        <td>
                            @if ($department->courses->isNotEmpty())

                            @foreach ($department->courses as $course)
                            <span class="label label-pill label-primary">
                                {{'(' .$course->name . ')'}}
                            </span>
                            @endforeach

                            @endif
                        </td>
                        <td>
                            @can('edit department')
                            <a class="fas fa-pen text-yellow-500 p-1 cursor-pointer" 
                            href="{{route('departments.edit', $department->id)}}"></a>
                            @endcan

                            @can('delete department')
                            <span class="fas fa-times text-red-400 p-1 cursor-pointer" onclick="event.preventDefault();
                            if(confirm('Are you sure you want to delete this department?'))
                            {
                                document.getElementById('form-delete-{{$department->id}}')
                                .submit()
                            }" />
                            <form style="display:none" id="{{'form-delete-'.$department->id}}" method="post"
                                action="{{route('departments.destroy', $department->id)}}">
                                @csrf
                                @method('delete')
                            </form>
                            @endcan
                            
                        </td>
                    </tr>
                    @empty
                        <h3>There's no department to show</h3>
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
