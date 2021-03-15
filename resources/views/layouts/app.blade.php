@include('includes.head')
@include('includes.navbar')
<div class="container p-3">
    <main>
        @yield('content')
        @yield('scripts')
    </main>
</div>
@include('includes.footer')
