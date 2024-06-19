@props([
    'id' => 'pills-tab',
])

<div class="tab-content" id="{{ $id }}Content">
    {{ $slot }}
</div>
