@extends('layouts.app')
@section('content')
<x-alert />
<div class="row py-lg-2">
    <div class="col-md-6">
        <h2>Manage All Roles</h2>
    </div>
</div>


<!-- DataTables Example -->
<div class="card">
    <div class="card-header">
        <h3 class="card-header d-flex justify-content-between align-items-center">
        Roles Table
        <div class="card-tools">
        <a href="{{route('roles.create')}}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Create New Role</a>
        <a href="{{route('roles.manage')}}" class="btn btn-primary"><i class="fas fa-plus-circle"></i>Manage Users' Roles</a>
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
                        <th>Permissions</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Permissions</th>
                        <th>Tools</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse ($roles as $role)
                    <tr {{ Auth::user()->hasRole($role)? 'bgcolor=#f0f0f0' : '' }}>
                        <td>{{$role->id}}</td>
                        <td>{{$role->name}}</td>
                        <td>
                            @if ($role->permissions->isNotEmpty())

                            @foreach ($role->permissions as $permission)
                            <span class="label label-pill label-primary">
                                {{'(' .$permission->name . ')'}}
                            </span>
                            @endforeach

                            @endif
                        </td>
                        <td>
                            <a class="fas fa-pen text-yellow-500 p-1 cursor-pointer" 
                            href="{{route('roles.edit', $role->id)}}"></a>

                            <span class="fas fa-times text-red-400 p-1 cursor-pointer" onclick="event.preventDefault();
                            if(confirm('Are you sure you want to delete this role?'))
                            {
                                document.getElementById('form-delete-{{$role->id}}')
                                .submit()
                            }" />
                            <form style="display:none" id="{{'form-delete-'.$role->id}}" method="post"
                                action="{{route('roles.destroy', $role->id)}}">
                                @csrf
                                @method('delete')
                            </form>
                            
                        </td>
                    </tr>
                    @empty
                        <h3>There's no roles to show</h3>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
    <a class="mx-5 py-2 text-gray-400 cursor-pointer text-black" href="{{route('admin.panel')}}">
        <span class="fas fa-arrow-left" />
    </a>
    </div>
</div>
@endsection
