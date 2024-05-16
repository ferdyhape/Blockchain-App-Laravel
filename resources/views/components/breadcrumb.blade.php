@php
    $breadcrumb = getBreadcrumb();
@endphp

<section id="header" class="my-3">
    <div class="d-flex justify-content-between align-items-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb py-auto my-auto gap-2 align-items-center">
                @foreach ($breadcrumb[$menu] as $item)
                    @php
                        $convertedRoute = $item['route'] == '#' ? '#' : route($item['route']);
                    @endphp
                    @if ($item['name'] === $current)
                        <li class="breadcrumb-item my-auto active" aria-current="page">
                            <a href="{{ $convertedRoute }}">{{ $item['name'] }}</a>
                        </li>
                    @break

                @else
                    <li class="breadcrumb-item my-auto">
                        <a href="{{ $convertedRoute }}"
                            class="text-secondary text-decoration-none">{{ $item['name'] }}</a>
                    </li>
                    <li class="d-flex align-items-center text-secondary">
                        <i class='bx bx-chevron-right align-middle'></i>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
</div>
</section>
