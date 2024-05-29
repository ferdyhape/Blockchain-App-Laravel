@props(['breadcrumbMenu'])

<section id="header" class="my-3">
    <div class="d-flex justify-content-between align-items-center">

        <x-breadcrumb :breadcrumbArray="$breadcrumbMenu" />
        {{ $headerContent ?? '' }}
    </div>
</section>
