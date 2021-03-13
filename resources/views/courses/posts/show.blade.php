@extends('layouts.app')

@section('content')


    <h2 class="p-5">This is where the full post, media, and comments are shown</h2>


    <x-post :post="$post"/>
@endsection
