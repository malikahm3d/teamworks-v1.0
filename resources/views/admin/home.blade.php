@extends('layouts.app')

@section('content')
    @role('admin')
    <a href="{{route('roles.index')}}"><h2 class="p-5">Manage Roles</h2></a>
    <a href="{{route('permissions.index')}}"><h2 class="p-5">Manage Permissions</h2></a>
    @endrole
    @hasanyrole('admin|moderator')
    <a href="{{route('admin.panel.organization')}}"><h2 class="p-5">Manage Universities' Organizations</h2></a>
    @else
    @endhasanyrole
@endsection