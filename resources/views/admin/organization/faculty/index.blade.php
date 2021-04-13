@extends('layouts.app')
@section('content')
<x-alert />
<div class="row py-lg-2">
    <div class="col-md-6">
        <h2>Manage All Faculties</h2>
    </div>
</div>


<!-- DataTables Example -->
<div class="card">
    <div class="card-header">
        <h3 class="card-header d-flex justify-content-between align-items-center">
        Faculties Table
        @can('create faculty')
        <div class="card-tools">
        <a href="{{route('faculties.create')}}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Create New Faculty</a>
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
                        <th>University</th>
                        <th>Departments</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                    <th>Id</th>
                        <th>Name</th>
                        <th>University</th>
                        <th>Departments</th>
                        <th>Tools</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse ($faculties as $faculty)
                    <tr {{ Auth::user()->faculty == $faculty? 'bgcolor=#f0f0f0' : '' }}>
                        <td>{{$faculty->id}}</td>
                        <td>{{$faculty->name}}</td>
                        <td>{{$faculty->university->name}}</td>
                        <td>
                            @if ($faculty->departments->isNotEmpty())

                            @foreach ($faculty->departments as $department)
                            <span class="label label-pill label-primary">
                                {{'(' .$department->name . ')'}}
                            </span>
                            @endforeach

                            @endif
                        </td>
                        <td>
                            @can('edit faculty')
                            <a class="fas fa-pen text-yellow-500 p-1 cursor-pointer" 
                            href="{{route('faculties.edit', $faculty->id)}}"></a>
                            @endcan

                            @can('delete faculty')
                            <span class="fas fa-times text-red-400 p-1 cursor-pointer" onclick="event.preventDefault();
                            if(confirm('Are you sure you want to delete this faculty?'))
                            {
                                document.getElementById('form-delete-{{$faculty->id}}')
                                .submit()
                            }" />
                            <form style="display:none" id="{{'form-delete-'.$faculty->id}}" method="post"
                                action="{{route('faculties.destroy', $faculty->id)}}">
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
