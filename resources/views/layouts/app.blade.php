@include('includes.head')
@include('includes.navbar')
<div class="container p-3">
<x-alert />
    <main>
        @yield('content')
        @yield('scripts')
    </main>
</div>
@include('includes.footer')
