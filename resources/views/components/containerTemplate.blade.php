@props([
    'pathLayout' => 'layouts.master',
    'pageTitle' => 'Title Of Page',
])

@extends($pathLayout)
@section('title', $pageTitle)
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {{ $contentOfContainer ?? '' }}
            </div>
        </div>
    </div>
@endsection
