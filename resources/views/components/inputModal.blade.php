@props([
    'id' => 'defaultId',
    'method' => 'POST',
    'route' => 'defaultRoute',
    'routeParams' => 'defaultRouteParams',
    'buttonName' => 'Edit',
    'modalTitle' => 'Edit Data',
    'handlingWithJSFunc' => null,
    'paramsHandlingWithJSFunc' => null,
    'input' => null,
])

@php
    $route = route($route, $routeParams);
@endphp

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inputModalLabel">{{ $modalTitle }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" {{ !$handlingWithJSFunc ? 'action=' . $route : '' }} method="POST">
                    @csrf
                    @method($method)
                    {{ $input }}

                    <button type="submit" class="btn btn-primary"
                        @if ($handlingWithJSFunc) onclick="{{ $handlingWithJSFunc }}('{{ $paramsHandlingWithJSFunc }}')"
                            type="button"
                        @else
                            type="submit" @endif>
                        {{ $buttonName }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
