{{-- content --}}
@props([
    'id' => '',
])
<section id="{{ $id }}" class="my-4">
    {{ $contentOfContentSection ?? '' }}
</section>
