@extends('layouts.app')
@section('content')
<x-alert />
<x-guest-layout>
    <x-auth-card>
        <!-- Logo TBD: change to teamworks logo -->
        <x-slot name="logo">
            <h6>Mange User Permissions</h6>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('permissions.updatePermissions') }}">
            @csrf
            @method('patch')

             <!-- User -->
             <div class="">
                <label><strong>Select One User:</strong></label><br />
                <select class="selectpicker" data-live-search="true" id="user" name="user">
                    <option value="" selected disabled hidden>Select one user</option>
                    @forelse ($users as $user)
                        <option value="{{$user->id}}" >{{$user->id.'. '. $user->name}}</option>
                    @empty
                        <option disabled selected value>No User to Select</option>
                    @endforelse
                    
                </select>
            </div>


            <!-- Roles -->
            <div class="">
            <br /><label><strong>Select Permission(s) (CTRL + click for multiple selections):</strong></label><br />
            <label><strong>* only direct permissions are shown for each user.</strong></label><br />
            <label><strong>* unselected permissions will be revoked from user.</strong></label><br />
                <select multiple id="permission" name="permission[]">
                    @forelse ($permissions as $permission)
                        <option value="{{$permission->id}}">{{$permission->name}}</option>
                    @empty
                        <option disabled selected value>No Permission to Select</option>
                        
                    @endforelse
                </select>
                <script>
                    $(function() {
                        $('select[name=user]').change(function() {
                            var url = '{{ url("/panel/user") }}' + '/' + $(this).val() + '/permissions/';

                            $.get(url, function(data) {
                                $("#permission").val([]);
                                $('#permission').children('option').prop('disabled', false);
                                $('#permission').children('option').show();
                                // console.log(data[0]['id'])
                                $.each(data,function(key, value) {
                                    //console.log(value.id)
                                    var thisAttr = $("#permission option[value='" + value.id + "']").attr('disabled');
                                    if(thisAttr = "disabled") {
                                        $("#permission option[value='" + value.id + "']").hide();
                                    } 
                                });
                            });
                        });
                    });
                </script>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="mx-5 py-2 text-gray-400 cursor-pointer text-white" href="{{route('permissions.index')}}">
                    <span
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'" />
                    {{ __('back') }}
                </a>

                <x-button class="ml-4">
                    {{ __('assign') }}
                </x-button>

            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
@endsection
