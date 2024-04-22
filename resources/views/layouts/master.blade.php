<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @yield('title')
    </title>
    @include('layouts.partials.cdn-head')
</head>

<body>
    @if (Auth::check())
        @include('layouts.partials.sidebar')
    @else
        @yield('content')
    @endif

    @include('layouts.partials.script')
</body>

</html>
