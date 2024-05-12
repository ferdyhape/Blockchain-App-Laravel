@props([
    'header' => 'headerTable',
    'tableId' => '',
    'oneRowThArray' => null,
    'theadContent' => '',
])

<div class="col-md-12">
    <h1>{{ $header }}</h1>
    <div class="table-responsive mt-5">
        <table id="{{ $tableId }}" class="table">
            <thead>
                @if ($oneRowThArray)
                    <tr>
                        @foreach ($oneRowThArray as $th)
                            <th>{{ $th }}</th>
                        @endforeach
                    </tr>
                @else
                    {{ $theadContent }}
                @endif
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</div>
