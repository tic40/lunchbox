<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('layouts.partials.head')
<body>
    <div>
        @include('layouts.partials.navi')
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
