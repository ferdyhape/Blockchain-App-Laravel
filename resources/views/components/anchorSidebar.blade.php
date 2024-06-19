@props([
    'route' => '',
    'icon' => '',
    'name' => '',
])

@php
    $stringRoute = $route ? $route : '';
    $route = $route ? route($route) : '#';
@endphp

<a href="{{ $route }}" class="nav_link {{ $route !== '#' && checkClassIsActive($stringRoute) ? 'active' : '' }}">
    <i class='bx {{ $icon }} nav_icon'></i>
    <span class="nav_name">{{ $name }}</span>
</a>
