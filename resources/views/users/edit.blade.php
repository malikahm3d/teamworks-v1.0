@extends('layouts.app')

@section('content')
<x-alert />
<x-guest-layout>
    <x-auth-card>
        <!-- Logo TODO: change to teamworks logo -->
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('patch')

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{$user->name}}" required
                    autofocus />
            </div>

            <!-- Userame -->
            <div>
                <x-label for="username" :value="__('Username')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="username" value="{{$user->username}}"
                    required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{$user->email}}"
                    required />
            </div>


            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('dashboard') }}">
                    {{ __('Back') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Update') }}
                </x-button>


                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('users.destroy', $user->id) }}"
                    onclick="event.preventDefault();
                    if(confirm('Are you sure you want to delete your account?'))
                    {
                        document.getElementById('{{$user->id}}-destroy-form')
                        .submit();
                    }">
                        {{ __('Destroy Account') }}
                </a>


            </div>
        </form>
    </x-auth-card>
    <form style="display:none" id="{{$user->id}}-destroy-form" action="{{route('users.destroy', $user->id)}}"
                 method="post">
                    @csrf
                    @method('delete')
    </form>
</x-guest-layout>
@endsection
