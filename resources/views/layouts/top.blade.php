<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('layouts.partials.head')
<body class="top-bg">
    <div>
        @include('layouts.partials.navi')
        @yield('content')
    </div>
</body>
</html>
