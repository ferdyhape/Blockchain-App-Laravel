 @if (session('success'))
     @push('custom-scripts')
         <script>
             showAlert('{{ session('success') }}', "success");
         </script>
     @endpush
 @endif
