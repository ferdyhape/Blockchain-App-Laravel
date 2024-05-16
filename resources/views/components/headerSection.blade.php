@props(['breadcrumbMenu', 'breadcrumbCurrent'])

<section id="header" class="my-3">
    <div class="d-flex justify-content-between align-items-center">

        <x-breadcrumb :menu="$breadcrumbMenu" :current="$breadcrumbCurrent" />
        {{ $headerContent ?? '' }}
    </div>
</section>
