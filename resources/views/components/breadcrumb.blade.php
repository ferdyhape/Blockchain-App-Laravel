@props([
    'breadcrumbArray' => ['Menu', 'Submenu', 'Current'],
])

<section id="header" class="my-3">
    <div class="d-flex justify-content-between align-items-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb py-auto my-auto gap-2 align-items-center">

                @foreach ($breadcrumbArray as $key => $item)
                    @if ($key === count($breadcrumbArray) - 1)
                        <li class="breadcrumb-item my-auto active" aria-current="page">
                            {{ $item }}
                        </li>
                    @else
                        <li class="breadcrumb-item my-auto">
                            {{ $item }}
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
