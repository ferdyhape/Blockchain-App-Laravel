@props([
    'header' => 'headerTable',
    'tableId' => '',
    'oneRowThArray' => null,
    'theadContent' => '',
])

<div class="col-md-12">
    <h1>{{ $header }}</h1>
    <div class="table-responsive mt-5">
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
