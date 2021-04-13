@extends('layouts.app')
@section('content')
<x-alert />
<div class="row py-lg-2">
    <div class="col-md-6">
        <h2>Manage All Permissions</h2>
    </div>
</div>


<!-- DataTables Example -->
<div class="card">
    <div class="card-header">
        <h3 class="card-header d-flex justify-content-between align-items-center">
        Permissions Table
        <div class="card-tools">
        @can('create permission')   
        <a href="{{route('permissions.create')}}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Create New Permission</a>
        @endcan
        @can('manage permission')
        <a href="{{route('permissions.manage')}}" class="btn btn-primary"><i class="fas fa-plus-circle"></i>Manage Users' Permissions</a>
        @endcan
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
                        <th>Roles</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Roles</th>
                        <th>Tools</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse ($permissions as $permission)
                    <tr {{ Auth::user()->hasPermissionTo($permission)? 'bgcolor=#f0f0f0' : '' }}>
                        <td>{{$permission->id}}</td>
                        <td>{{$permission->name}}</td>
                        <td>
                            @if ($permission->roles->isNotEmpty())

                            @foreach ($permission->roles as $role)
                            <span class="label label-pill label-primary">
                                {{'(' .$role->name . ')'}}
                            </span>
                            @endforeach

                            @endif
                        </td>
                        <td>
                            @can('edit permission')
                            <a class="fas fa-pen text-yellow-500 p-1 cursor-pointer" 
                            href="{{route('permissions.edit', $permission->id)}}"></a>
                            @endcan

                            @can('delete permission')
                            <span class="fas fa-times text-red-400 p-1 cursor-pointer" onclick="event.preventDefault();
                            if(confirm('Are you sure you want to delete this permission?'))
                            {
                                document.getElementById('form-delete-{{$permission->id}}')
                                .submit()
                            }" />
                            <form style="display:none" id="{{'form-delete-'.$permission->id}}" method="post"
                                action="{{route('permissions.destroy', $permission->id)}}">
                                @csrf
                                @method('delete')
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                        <h3>There's no permissions to show</h3>
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
