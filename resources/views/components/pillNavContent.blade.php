@props([
    'active' => false,
    'id' => 'pills-home',
    'target' => 'pills-home-tab',
])

<li class="nav-item" role="presentation">
    <button class="nav-link {{ $active ? 'active' : '' }}" id="{{ $id }}-tab" data-bs-toggle="pill"
        data-bs-target="#{{ $target }}" type="button" role="tab">
        {{ $slot }}
    </button>
</li>
<li></li>
