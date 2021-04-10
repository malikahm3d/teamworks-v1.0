<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('includes.head')
@include('includes.navbar')
<body class="d-flex flex-column vh-100">
<div class="container p-3">
    <main>
        @yield('content')
    </main>
</div>
@include('includes.footer')
</body>
</html>
