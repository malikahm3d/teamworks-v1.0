@extends('layouts.app')

@section('content')
    @if(count($universities))
        @foreach($universities as $university)
            <div>
                <form action="{{ route('showFaculties', $university->name) }}" method="POST">
                    @csrf
                    <button class="btn-primary btn-lg" type="submit"><p> {{ $university->name }} </p></button>
                </form>
            </div>
        @endforeach
    @else
    <p class="btn-danger text-center">There are no avaliable info to show</p>
    @endif
@endsection
