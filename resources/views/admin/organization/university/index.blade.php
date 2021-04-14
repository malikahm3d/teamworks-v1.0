@extends('layouts.app')
@section('content')
<x-alert />
<div class="row py-lg-2">
    <div class="col-md-6">
        <h2>Manage All Universities</h2>
    </div>
    
</div>


<!-- DataTables Example -->
<div class="card">
    <div class="card-header">
        <h3 class="card-header d-flex justify-content-between align-items-center">
        Universities Table
        @can('create university')
        <div class="card-tools">
        <a href="{{route('universities.create')}}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Create New University</a>
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
                        <th>Faculties</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Faculties</th>
                        <th>Tools</th>
                    </tr>
                </tfoot>
                <tbody>
                    @forelse ($universities as $university)
                    <tr {{ Auth::user()->university == $university? 'bgcolor=#f0f0f0' : '' }}>
                        <td>{{$university->id}}</td>
                        <td>{{$university->name}}</td>
                        <td>
                            @if ($university->faculties->isNotEmpty())

                            @foreach ($university->faculties as $faculty)
                            <span class="label label-pill label-primary">
                                {{'(' .$faculty->name . ')'}}
                            </span>
                            @endforeach

                            @endif
                        </td>
                        <td>
                            @can('edit university')
                            <a class="fas fa-pen text-yellow-500 p-1 cursor-pointer" 
                            href="{{route('universities.edit', $university->id)}}"></a>
                            @endcan

                            @can('delete university')
                            <span class="fas fa-times text-red-400 p-1 cursor-pointer" onclick="event.preventDefault();
                            if(confirm('Are you sure you want to delete this university?'))
                            {
                                document.getElementById('form-delete-{{$university->id}}')
                                .submit()
                            }" />
                            <form style="display:none" id="{{'form-delete-'.$university->id}}" method="post"
                                action="{{route('universities.destroy', $university->id)}}">
                                @csrf
                                @method('delete')
                            </form>
                            @endcan                            
                        </td>
                    </tr>
                    @empty
                        <h3>There's no faculty to show</h3>
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
