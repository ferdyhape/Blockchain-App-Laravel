@props([
    'id' => 'pills-tab',
    'active' => false,
])

<div class="tab-pane fade {{ $active ? 'show active' : '' }}" id="{{ $id }}" role="tabpanel" tabindex="0">
    {{ $slot }}
</div>
