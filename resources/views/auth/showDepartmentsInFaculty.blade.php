@extends('layouts.app')

@section('content')
    @if(count($departments))
        @foreach($departments as $department)
            <div>
                <form action="{{ route('prefilledFrom', [$university->name, $faculty->name, $department->name]) }}" method="POST">
                    @csrf
                    <button class="btn-primary btn-lg" type="submit"><p> {{ $department->name }} </p></button>
                </form>
            </div>
        @endforeach
    @else
        <p class="btn-danger text-center">There are no avaliable info to show</p>
    @endif
@endsection
