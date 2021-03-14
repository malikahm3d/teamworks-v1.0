@extends('layouts.app')

@section('content')
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

        <form method="POST" action="{{ route('storeUser') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus />
            </div>

            <!-- Userame -->
            <div>
                <x-label for="username" :value="__('Username')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="username" :value="old('username')"
                    required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />
            </div>

            <div>
                <!-- University -->
                <br><select name="university" id="university" required>
                    <option value="" selected disabled hidden >Select University</option>
                    @forelse($allUniversities as $uni)
                    <option value="{{ $uni->id }}" {{ (isset($chosenUniversity) && $chosenUniversity == $uni ? 'selected':'') }}>{{ $uni->name }}</option>
                    @empty
                    <option disabled selected value>No University to Select</option>
                    @endforelse
                </select>

                <!-- Faculty -->
                <select name="faculty" id="faculty" required>
                    <option value="" selected disabled hidden>Select faculty</option>
                    @forelse($allFaculties as $fac)
                    <option value="{{ $fac->id }}" {{ (isset($chosenFaculty) && $chosenFaculty == $fac ? 'selected':'') }}>{{ $fac->name }}</option>
                    @empty
                    <option disabled selected value>No Faculties to Select</option>
                    @endforelse
                </select>

                <!-- Department -->
                <select name="department" id="department" required>
                    <option value="" selected disabled hidden>Select department</option>
                    @forelse($allDepartments as $dep)
                    <option value="{{ $dep->id }}" {{ (isset($chosenDepartment) && $chosenDepartment == $dep ? 'selected':'') }}>{{ $dep->name }}</option>
                    @empty
                    <option disabled selected value>No Departments to Select</option>
                    @endforelse
                </select>

                <!-- Role -->
                <br><br><select name="role" id="role" required>
                    <option value="" selected disabled hidden >Select Role</option>
                    @forelse($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @empty
                    <option disabled selected value>No Role to Select</option>
                    @endforelse
                </select>

                <!-- change faculty options upon selecting university -->
                <script>
                    $(function() {
                        $('select[name=university]').change(function() {

                            var url = '{{ url('university') }}' + '/' + $(this).val() + '/faculties/';

                            $.get(url, function(data) {
                                var faculty_select = $('form select[name= faculty]');
                                var department_select = $('form select[name= department]');

                                faculty_select.empty();
                                department_select.empty();

                                $.each(data,function(key, value) {
                                    console.log(value.name);
                                    faculty_select.append('<option value=' + value.id + '>' + value.name + '</option>');
                                });
                                if(faculty_select.children('option').length != 0){
                                    faculty_select[0].selectedIndex = -1;
                                }
                                else{
                                    faculty_select.append('<option disabled>No Faculty to show</option>');
                                    department_select.append('<option disabled>No Department to show</option>');
                                }
                            });
                        });
                    });
                </script>

                <!-- change department options upon selecting faculty -->
                <script>
                    $(function() {
                        $('select[name=faculty]').change(function() {

                            var url = '{{ url('faculty') }}' + '/' + $(this).val() + '/departments/';

                            $.get(url, function(data) {
                                var department_select = $('form select[name= department]');

                                department_select.empty();

                                $.each(data,function(key, value) {
                                    console.log(value.name);
                                    department_select.append('<option value=' + value.id + '>' + value.name + '</option>');
                                });
                                if(department_select.children('option').length != 0)
                                    department_select[0].selectedIndex = -1;
                                else
                                    department_select.append('<option disabled>No Department to show</option>');
                            });
                        });
                    });
                </script>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
@endsection
