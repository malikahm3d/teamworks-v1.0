@extends('layouts.app')
@section('content')
<x-alert />
<x-guest-layout>
    <x-auth-card>
        <!-- Logo TBD: change to teamworks logo -->
        <x-slot name="logo">
                <h6>Edit Role</h6>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('roles.update', $role->id) }}">
            @csrf
            @method('patch')

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value=" old('name') ?? $role->name ?? 'default' " required
                    autofocus />
            </div>

            <!-- Userame -->
            <div>
                <x-label for="permissions" :value="__('permissions')" />
                @foreach($permissions as $permission)
                <input type="checkbox" name="perm[]" value="{{ $permission->name }}"
                @if($role->permissions->contains($permission->id)) checked=checked @endif>
                {{$permission->name}}
                <br/>
                @endforeach
            </div>


            <div class="flex items-center justify-end mt-4">
                <a class="mx-5 py-2 text-gray-400 cursor-pointer text-white" href="{{route('roles.index')}}">
                    <span class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'" />
                    {{ __('back') }}
                </a>

                <x-button class="ml-4">
                    {{ __('update') }}
                </x-button>

            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
@endsection