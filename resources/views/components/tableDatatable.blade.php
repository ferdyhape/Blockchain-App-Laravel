@props([
    'header' => null,
    'tableId' => '',
    'oneRowThArray' => null,
    'theadContent' => '',
])

<div class="col-md-12">
    @if ($header)
        <h5 class="fw-semibold mb-4">{{ $header }}</h5>
    @endif
    <div class="table-responsive ">
        <table id="{{ $tableId }}" class="display w-100 nowrap">
            <thead class="text-center">
                @if ($oneRowThArray)
                    <tr>
                        @foreach ($oneRowThArray as $th)
                            @if ($th == 'Action')
                                <th class="text-center">{{ $th }}</th>
                            @else
                                <th>{{ $th }}</th>
                            @endif
                        @endforeach
                    </tr>
                @else
                    {{ $theadContent }}
                @endif
            </thead>
        </table>
    </div>

</div>
