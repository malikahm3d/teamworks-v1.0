@extends('layouts.app')

@section('content')
    @if(count($faculties))
        @foreach($faculties as $faculty)
            <div>
                <form action="{{ route('showDepartments', [$university->name, $faculty->name]) }}" method="POST">
                    @csrf
                    <button type="submit"><p> {{ $faculty->name }} </p></button>
                </form>
            </div>
        @endforeach
    @else
        <p class="btn-danger text-center">There are no avaliable info to show</p>
    @endif
@endsection
