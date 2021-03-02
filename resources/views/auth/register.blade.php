@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('storeUser') }}" method="POST">
        @csrf
        <input type="text" name="name" id="name" placeholder="enter name" value="{{ old('name') }}">
        <input type="text" name="username" id="name" placeholder="enter username" value="{{ old('username') }}">
        <input type="email" name="email" id="email" placeholder="email" value="{{ old('email') }}">
        <input type="password" name="password" id="password" placeholder="password">

        <select name="university" id="university">
            @foreach($allUniversities as $uni)
                <option value="{{ $uni->id }}" {{ (isset($chosenUniversity) && $chosenUniversity == $uni ? 'selected':'') }}>{{ $uni->name }}</option>
            @endforeach
        </select>
        <select name="faculty" id="faculty">
            @foreach($allFaculties as $fac)
                <option value="{{ $fac->id }}" {{ (isset($chosenFaculty) && $chosenFaculty == $fac ? 'selected':'') }}>{{ $fac->name }}</option>
            @endforeach
        </select>
        <select name="department" id="department">
            @foreach($allDepartments as $dep)
                <option value="{{ $dep->id }}" {{ (isset($chosenDepartment) && $chosenDepartment == $dep ? 'selected':'') }}>{{ $dep->name }}</option>
            @endforeach
        </select>
        <button type="submit">Submit</button>
    </form>
@endsection
