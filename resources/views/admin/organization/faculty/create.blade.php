@extends('layouts.app')
@section('content')
<x-alert />
<x-guest-layout>
    <x-auth-card>
        <!-- Logo TBD: change to teamworks logo -->
        <x-slot name="logo">
                <h6>Create a new faculty</h6>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('faculties.store') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus />
            </div>

            <!-- University -->

            <div class="">
                <label><strong>University:</strong></label><br />
                <select class="selectpicker" data-live-search="true" id="university" name="university" required>
                    <option value="" selected disabled hidden>Select one University</option>
                    @foreach ($universities as $university)
                        <option value="{{$university->id}}" >{{$university->id.'. '. $university->name}}</option>
                    @endforeach
                </select>
            </div>


            <div class="flex items-center justify-end mt-4">
                <a class="mx-5 py-2 text-gray-400 cursor-pointer text-white" href="{{route('faculties.index')}}">
                    <span class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'" />
                    {{ __('back') }}
                </a>

                <x-button class="ml-4">
                    {{ __('create') }}
                </x-button>

            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
@endsection