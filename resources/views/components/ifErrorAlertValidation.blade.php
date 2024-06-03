@if ($errors->any())
    @push('custom-scripts')
        <script>
            @foreach ($errors->all() as $error)
                showAlert('{{ $error }}', "error");
            @endforeach
        </script>
    @endpush
@endif
