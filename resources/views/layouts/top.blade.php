<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('layouts.partials.head')
<style>
    [v-cloak] {
        display: none;
    }
</style>
<body class="bg">
    <div id="app">
        @include('layouts.partials.navi')
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
